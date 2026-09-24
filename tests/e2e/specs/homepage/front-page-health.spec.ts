import { test, expect, expectLoggedOut } from "../../fixtures";

/**
 * @area homepage
 * @tier fresh
 * @source human 2026-09-24
 * @why The baseline every other spec assumes: the front page serves, logs no
 *      console errors, and has exactly one h1 — the site title (header.php
 *      renders it as h1 only on the front/blog page, h3 elsewhere). Does not
 *      assert layout or content.
 */
test("front page renders with no console errors and the site title as its only h1 @fresh @homepage", async ({
  page,
}) => {
  const consoleErrors: string[] = [];
  page.on("console", (msg) => {
    if (msg.type() === "error") consoleErrors.push(msg.text());
  });

  const response = await page.goto("/");
  expect(response?.ok()).toBeTruthy();

  const h1 = page.getByRole("heading", { level: 1 });
  await expect(h1).toHaveCount(1);
  await expect(h1.getByRole("link")).toHaveAttribute("rel", "home");
  expect(
    consoleErrors,
    `unexpected console errors: ${consoleErrors.join("; ")}`,
  ).toEqual([]);
});

/**
 * @area homepage
 * @tier fresh
 * @source radiate-theme-research-and-improvement-report.html §17
 * @why The 2026-09-17 audit confirmed the skip link is present and correctly
 *      implemented. Guards that it stays the first Tab stop and points at the
 *      #content region that exists on the page. Does not assert its styling.
 */
test("skip link is the first Tab stop and targets the content region @fresh @homepage", async ({
  page,
}) => {
  await page.goto("/");
  await expectLoggedOut(page);
  await page.keyboard.press("Tab");

  const skip = page.getByRole("link", { name: "Skip to content" });
  await expect(skip).toBeFocused();
  await expect(skip).toHaveAttribute("href", "#content");
  await expect(page.locator("#content")).toHaveCount(1);
});

// Quarantined: not fixed yet and no issue filed. Drop `.fixme` in the PR that fixes it.
/**
 * @area homepage
 * @tier fresh
 * @source human 2026-09-24
 * @why functions.php:170 registers html5shiv with
 *      wp_script_add_data( 'html5shiv', 'conditional', 'lte IE 8' ), which
 *      WordPress 6.9+ deprecates, so every front-end page prints a
 *      "Deprecated: WP_Dependencies->add_data()" notice when WP_DEBUG_DISPLAY
 *      is on (confirmed on test-theme.local, WP 7.1). Only observable where
 *      debug display is enabled; on a site with it off this passes regardless.
 *      Asserts no PHP notice markup in the body, not the absence of html5shiv.
 */
test.fixme("front page prints no PHP notices or deprecations @fresh @homepage", async ({
  page,
}) => {
  await page.goto("/");
  await expect(page.locator("body")).not.toContainText(
    /(Deprecated|Notice|Warning|Fatal error):\s/,
  );
});
