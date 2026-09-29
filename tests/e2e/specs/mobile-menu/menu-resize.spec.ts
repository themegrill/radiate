import { test, expect, expectLoggedOut } from "../../fixtures";

/**
 * @area mobile-menu
 * @tier fresh
 * @guards radiate-pro#53
 * @source fix/53-menu-desktop-reset 2026-09-29; js/custom.js
 * @why Widening the viewport with the mobile menu open (rotating a tablet,
 *      or switching the Customizer preview from mobile to desktop) left the
 *      vertical mobile layout in place. Guards that the desktop menu comes
 *      back inline. Does not cover submenu state or the closed-menu case,
 *      which never broke.
 */
test("widening the viewport with the mobile menu open restores the desktop menu @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize({ width: 375, height: 800 });
  await page.goto("/");
  await expectLoggedOut(page);

  const nav = page.locator("#site-navigation");
  await nav.locator(".menu-toggle").click();
  await expect(nav).toHaveClass(/\bmain-small-navigation\b/);

  await page.setViewportSize({ width: 1280, height: 800 });

  await expect(nav).toHaveClass(/\bmain-navigation\b/);
  await expect(nav.locator(".menu-toggle")).toBeHidden();
  const firstItem = nav.locator("ul").first().locator("> li").first();
  await expect(firstItem).toHaveCSS("float", "left");
});

/**
 * @area mobile-menu
 * @tier fresh
 * @guards radiate-pro#53
 * @source fix/53-menu-desktop-reset 2026-09-29; js/custom.js
 * @why With the new responsive menu style the toggle slides the menu list
 *      open and shut with an inline display value. Closing it and then
 *      widening left the list at display: none, so the desktop menu vanished.
 *      The style class is added before the page scripts run, as a fresh site
 *      does not have it. Does not assert submenu state.
 */
test("widening the viewport after closing the new-style mobile menu keeps the desktop menu visible @fresh @mobile-menu", async ({
  page,
}) => {
  // The class must exist before the theme scripts run, as it does when PHP prints it.
  await page.addInitScript(() => {
    const observer = new MutationObserver(() => {
      if (document.body) {
        document.body.classList.add("better-responsive-menu");
        observer.disconnect();
      }
    });
    observer.observe(document, { childList: true, subtree: true });
  });
  await page.setViewportSize({ width: 375, height: 800 });
  await page.goto("/");
  await expectLoggedOut(page);

  const nav = page.locator("#site-navigation");
  const menu = nav.locator("ul").first();
  await nav.locator(".menu-toggle").click();
  await expect(menu).toBeVisible();
  await nav.locator(".menu-toggle").click();
  await expect(menu).toBeHidden();

  await page.setViewportSize({ width: 1280, height: 800 });

  await expect(menu).toBeVisible();
});
