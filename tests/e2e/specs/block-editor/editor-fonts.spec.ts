import { test, expect } from "../../fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "../../utils/login";

test.use({ storageState: ADMIN_STATE });

/**
 * @area block-editor
 * @tier fresh
 * @guards radiate-pro#63
 * @source fix/63-editor-google-fonts-url 2026-09-30; functions.php
 * @why The theme asked Google for its editor fonts with an invalid css2 URL
 *      (HTTP 400) and on a hook whose styles never reach the editor iframe, so
 *      the editor text fell back to generic fonts. Guards that the editor canvas
 *      carries the fonts stylesheet with valid css2 syntax. Reads the link
 *      itself, so it needs no network access to Google; it does not assert which
 *      font is rendered.
 */
test("the block editor canvas loads the theme's Google fonts with a valid CSS2 URL @fresh @block-editor", async ({
  page,
}) => {
  test.skip(!hasAdminCredentials(), "needs TGQA_ADMIN_USER / TGQA_ADMIN_PASS");
  test.setTimeout(90_000);
  page.on("dialog", (dialog) => dialog.accept());

  await page.goto("/wp-admin/post-new.php");
  await expect(page.locator('iframe[name="editor-canvas"]')).toBeVisible({ timeout: 60_000 });

  const fonts = page
    .frameLocator('iframe[name="editor-canvas"]')
    .locator('link[href*="fonts.googleapis.com"]');
  await expect(fonts.first()).toBeAttached({ timeout: 20_000 });

  const href = (await fonts.first().getAttribute("href"))!;
  expect(href).toMatch(/^https:\/\/fonts\.googleapis\.com\/css2\?family=[^|]+$/);
  expect(href).toContain("Merriweather");
  expect(href).toContain("Roboto");
});
