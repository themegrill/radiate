import { test, expect, expectLoggedOut } from "../../fixtures";

/**
 * @area mobile-menu
 * @tier fresh
 * @guards radiate-pro#109
 * @source fix/109-responsive-submenu-toggle 2026-10-02; style.css
 * @why With the new responsive menu style an open submenu kept the desktop
 *      float, so it shrank to its widest label. A short child that has its
 *      own submenu then got a narrow row, and its arrow sat next to the label
 *      instead of at the right edge. Guards that the child row is as wide as
 *      the top-level row and both arrows line up. The style class and a
 *      nested branch are added before the page scripts run, since a fresh
 *      site has neither; the class goes on as soon as <body> exists so
 *      navigation.js stands down as it does on a real site.
 */
test("a nested responsive submenu row and arrow reach the right edge @fresh @mobile-menu", async ({
  page,
}) => {
  await page.addInitScript(() => {
    // navigation.js skips the new style's menu when it sees this class, so it has to be on <body> before footer scripts run.
    new MutationObserver((_, observer) => {
      if (document.body) {
        document.body.classList.add("better-responsive-menu");
        observer.disconnect();
      }
    }).observe(document, { childList: true, subtree: true });
    document.addEventListener("DOMContentLoaded", () => {
      document
        .querySelector("#site-navigation ul")!
        .insertAdjacentHTML(
          "beforeend",
          '<li class="menu-item menu-item-has-children"><a href="#">Spec parent</a><ul class="sub-menu"><li class="menu-item menu-item-has-children"><a href="#">Kid</a><ul class="sub-menu"><li class="menu-item"><a href="#">Grandkid</a></li></ul></li></ul></li>'
        );
    });
  });
  await page.setViewportSize({ width: 375, height: 800 });
  await page.goto("/");
  await expectLoggedOut(page);
  await page.locator("#site-navigation .menu-toggle").click();

  const parent = page.locator("#site-navigation li", { hasText: "Spec parent" }).last();
  const child = parent.locator("li", { hasText: "Kid" }).first();
  await parent.locator("> .sub-toggle").click();
  await child.locator("> .sub-toggle").click();
  await expect(child.getByRole("link", { name: "Grandkid" })).toBeVisible();

  const parentRow = (await parent.boundingBox())!;
  const childRow = (await child.boundingBox())!;
  const parentArrow = (await parent.locator("> .sub-toggle").boundingBox())!;
  const childArrow = (await child.locator("> .sub-toggle").boundingBox())!;

  expect(Math.abs(childRow.width - parentRow.width)).toBeLessThanOrEqual(1);
  expect(Math.abs(childArrow.x - parentArrow.x)).toBeLessThanOrEqual(1);
});
