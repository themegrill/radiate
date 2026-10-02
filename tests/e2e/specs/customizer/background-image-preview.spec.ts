import { test, expect } from "../../fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "../../utils/login";

test.use({ storageState: ADMIN_STATE });

/**
 * @area customizer
 * @tier fresh
 * @guards radiate-pro#48
 * @source fix/48-background-image-preview 2026-09-29; js/customizer.js
 * @why WordPress live-previews the background settings by rewriting the theme's
 *      background style element, but Radiate paints its background on #content,
 *      so choosing an image changed nothing in the Customizer preview until
 *      publishing. The image is only previewed, never saved. Guards image and
 *      repeat; position, attachment and colour share the same handler and are
 *      deliberately not asserted separately.
 */
test("the Customizer previews a background image and its repeat setting live @fresh @customizer", async ({
  page,
}) => {
  test.skip(!hasAdminCredentials(), "needs TGQA_ADMIN_USER / TGQA_ADMIN_PASS");
  test.setTimeout(120_000);
  page.on("dialog", (dialog) => dialog.accept());
  await page.goto("/wp-admin/customize.php");
  await expect(page.locator("#customize-theme-controls")).toBeVisible({ timeout: 90_000 });

  const preview = page.frameLocator("#customize-preview iframe").last();
  const content = preview.locator("#content");
  await expect(content).toBeVisible({ timeout: 60_000 });

  // Any URL works: only the computed style is read, the file need not load.
  await page.evaluate(() => {
    const api = (window as any).wp.customize;
    api("background_image").set(`${api.settings.url.home}/wp-content/themes/radiate/screenshot.png`);
    api("background_repeat").set("no-repeat");
  });

  await expect(content).toHaveCSS("background-image", /radiate\/screenshot\.png/);
  await expect(content).toHaveCSS("background-repeat", "no-repeat");
});
