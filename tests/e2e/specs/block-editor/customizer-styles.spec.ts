import type { Frame, Page } from "@playwright/test";
import { test, expect } from "../../fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "../../utils/login";

test.use({ storageState: ADMIN_STATE });

/**
 * @area block-editor
 * @tier fresh
 * @guards themegrill/radiate-pro#112
 * @source themegrill/radiate-pro#112 (reported by subin-shk)
 * @why 1.5.0 loaded the editor stylesheet and the default fonts in the editor
 *      iframe, but the Customizer primary color never reached it: editor links,
 *      quotes and buttons kept the default #632E9B. Saves a custom primary color
 *      through the Customizer itself (restored afterwards), then checks on a post
 *      and a page
 *      that the canvas loads the front end's font families, and that each
 *      element computes the same font, size, weight, color and background in
 *      the editor as on the published page. Reads the stylesheet links, so it
 *      needs no network access to Google.
 */
const settings: Record<string, string> = {
  radiate_color_scheme: "#e86a46",
};

const content = [
  '<!-- wp:heading --><h2 class="wp-block-heading">TGQA heading</h2><!-- /wp:heading -->',
  '<!-- wp:paragraph --><p>TGQA text with <a href="https://example.com">a link</a>.</p><!-- /wp:paragraph -->',
  '<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li>TGQA list item</li><!-- /wp:list-item --></ul><!-- /wp:list -->',
  '<!-- wp:freeform --><blockquote><p>TGQA classic quote</p></blockquote><p><input type="submit" value="Go" /> <button type="button">Plain button</button></p><!-- /wp:freeform -->',
  '<!-- wp:search {"label":"Search","buttonText":"Search"} /-->',
].join("\n");

const targets: Record<string, string> = {
  heading: "h2.wp-block-heading",
  text: "p",
  link: "p a",
  list: "li",
  "classic quote": "blockquote:not(.wp-block-quote)",
  submit: "input[type=submit]",
  button: "p button",
  "search field": ".wp-block-search__input",
};

async function styles(root: Page | Frame, scope: string, title: string) {
  return root.locator(scope).first().evaluate(
    (el, { targets, title }) => {
      const read = (node: Element | null) => {
        if (!node) return null;
        const c = getComputedStyle(node);
        return `${c.fontFamily.split(",")[0].replace(/["']/g, "")} ${c.fontSize} ${c.fontWeight} ${c.color} on ${c.backgroundColor} border ${c.borderLeftColor}`;
      };
      const out: Record<string, string | null> = { title: read(document.querySelector(title)) };
      for (const [name, selector] of Object.entries(targets)) out[name] = read(el.querySelector(selector));
      return out;
    },
    { targets, title },
  );
}

/** Font family names in a Google Fonts URL (legacy `family=A|B:400` or CSS2 `family=A&family=B:wght@400`). */
function families(href: string | null): string[] {
  const query = (href ?? "").replace(/&(amp;|#038;)/g, "&").split("?")[1] ?? "";
  return query
    .split("&")
    .filter((part) => part.startsWith("family="))
    .flatMap((part) => decodeURIComponent(part.slice(7).replace(/\+/g, " ")).split("|"))
    .map((family) => family.split(":")[0].trim())
    .sort();
}

/** Set Customizer values through the Customizer's own API and publish them; returns the previous values. */
async function saveCustomizer(page: Page, values: Record<string, string>): Promise<Record<string, string>> {
  await page.goto("/wp-admin/customize.php", { waitUntil: "domcontentloaded" });
  await page.waitForFunction(() => (window as any).wp?.customize?.state?.("activated")?.get(), null, { timeout: 90_000 });
  return page.evaluate(async (values) => {
    const api = (window as any).wp.customize;
    const previous: Record<string, string> = {};
    for (const [key, value] of Object.entries(values)) {
      const setting = api(key);
      if (!setting) throw new Error(`Customizer setting ${key} is not registered`);
      previous[key] = setting.get();
      setting.set(value);
    }
    await new Promise((resolve, reject) => api.previewer.save().done(resolve).fail(reject));
    return previous;
  }, values);
}

async function restNonce(page: Page): Promise<string> {
  const res = await page.request.get("/wp-admin/admin-ajax.php?action=rest-nonce");
  expect(res.ok(), "could not get a REST nonce — is the admin logged in?").toBeTruthy();
  return (await res.text()).trim();
}

async function createPost(page: Page, type: "posts" | "pages", title: string): Promise<{ id: number; link: string }> {
  const res = await page.request.post(`/?rest_route=/wp/v2/${type}`, {
    headers: { "X-WP-Nonce": await restNonce(page) },
    data: { title, content, status: "publish" },
  });
  expect(res.ok(), `creating the test ${type} failed: HTTP ${res.status()}`).toBeTruthy();
  const body = await res.json();
  return { id: body.id, link: body.link };
}

// POST with a method override: some hosts answer a bare DELETE with 405.
async function deletePost(page: Page, type: "posts" | "pages", id: number): Promise<void> {
  const res = await page.request.post(`/?rest_route=/wp/v2/${type}/${id}&force=true`, {
    headers: { "X-WP-Nonce": await restNonce(page), "X-HTTP-Method-Override": "DELETE" },
  });
  expect(res.ok(), `deleting test ${type} ${id} failed: HTTP ${res.status()}`).toBeTruthy();
}

test("the block editor uses the front end's fonts and Customizer primary color @block-editor @fresh", async ({
  page,
}) => {
  test.skip(!hasAdminCredentials(), "needs TGQA_ADMIN_USER / TGQA_ADMIN_PASS");
  test.setTimeout(420_000);
  page.on("dialog", (dialog) => dialog.accept());
  let previous: Record<string, string> | null = null;
  const created: { type: "posts" | "pages"; id: number }[] = [];
  try {
    previous = await saveCustomizer(page, settings);

    for (const type of ["posts", "pages"] as const) {
      const item = await createPost(page, type, `TGQA editor styles ${type}`);
      created.push({ type, id: item.id });

      await page.goto(item.link);
      const front = await styles(page, ".entry-content", ".entry-title");
      const frontFonts = await page.locator("#radiate-google-fonts-css").evaluateAll((links) => links[0]?.getAttribute("href") ?? null);

      await page.goto(`/wp-admin/post.php?post=${item.id}&action=edit`, { waitUntil: "domcontentloaded" });
      const canvas = page.frameLocator('iframe[name="editor-canvas"]');
      await expect(canvas.locator(".editor-styles-wrapper .wp-block-search__input")).toBeVisible({ timeout: 90_000 });
      const frame = page.frame({ name: "editor-canvas" })!;

      await expect(canvas.locator("#radiate-block-editor-styles-css"), "the theme's editor styles must reach the canvas").toBeAttached({ timeout: 15_000 });
      const editorFonts = await canvas.locator("#radiate-editor-googlefonts-css").evaluateAll((links) => links[0]?.getAttribute("href") ?? null);
      expect.soft(families(editorFonts), `${type}: the editor canvas must load the front end's font families`).toEqual(families(frontFonts));

      const editor = await styles(frame, ".editor-styles-wrapper", ".editor-post-title__input");
      for (const name of Object.keys(front)) {
        expect(front[name], `${type}: ${name} is missing on the front end`).not.toBeNull();
        expect.soft(editor[name], `${type}: ${name} (font size weight color on background, border) differs from the front end`).toBe(front[name]);
      }
    }
  } finally {
    for (const { type, id } of created) await deletePost(page, type, id);
    if (previous) await saveCustomizer(page, previous);
  }
});
