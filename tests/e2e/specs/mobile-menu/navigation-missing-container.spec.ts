import { test, expect } from "../../fixtures";

/**
 * @area mobile-menu
 * @tier fresh
 * @guards themegrill/radiate-pro#28
 * @source fix/28-navigation-guard 2026-09-30; js/navigation.js
 * @why The touch-submenu handler in navigation.js read #site-navigation
 *      without a null check (the first handler already had one), so any page
 *      without that element (a child theme whose header.php drops the nav)
 *      threw "Cannot read properties of null (reading 'querySelectorAll')".
 *      Removes the <nav> while the page loads to reproduce that header, and
 *      asserts the page raises no script error.
 */
test("navigation.js raises no error when #site-navigation is missing @fresh @mobile-menu", async ({
  page,
}) => {
  // Drop the <nav> as the parser adds it, so it is gone before the footer scripts run.
  await page.addInitScript(() => {
    new MutationObserver(() =>
      document.getElementById("site-navigation")?.remove(),
    ).observe(document, { childList: true, subtree: true });
  });

  const errors: string[] = [];
  page.on("pageerror", (e) => errors.push(e.message));

  await page.goto("/");
  await page.waitForLoadState("networkidle");

  await expect(page.locator("#site-navigation")).toHaveCount(0);
  await expect(page.locator("script[src*='navigation']")).toHaveCount(1);
  expect(errors, "script errors").toEqual([]);
});
