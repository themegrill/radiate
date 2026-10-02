import { test, expect, expectLoggedOut } from "../../fixtures";

/**
 * @area mobile-menu
 * @tier fresh
 * @guards radiate-pro#51
 * @source fix/51-responsive-submenu-arrow 2026-09-29; js/navigation.js, style.css
 * @why With the new responsive menu style the submenu arrow kept pointing
 *      down after the submenu opened, and every tap threw a jQuery selector
 *      error. Guards that it flips to the collapse arrow when expanded and
 *      back when closed. The style class and a nested item are added before
 *      the page scripts run, since a fresh site has neither. Also guards that
 *      the footer scroll-up icon, which shares the collapse class, keeps its
 *      own styling. Does not assert the glyph.
 */
test("the responsive submenu arrow flips when the submenu is expanded @fresh @mobile-menu", async ({
  page,
}) => {
  await page.addInitScript(() => {
    document.addEventListener("DOMContentLoaded", () => {
      document.body.classList.add("better-responsive-menu");
      document
        .querySelector("#site-navigation ul")!
        .insertAdjacentHTML(
          "beforeend",
          '<li class="menu-item menu-item-has-children"><a href="#">Spec parent</a><ul class="sub-menu"><li class="menu-item"><a href="#">Spec child</a></li></ul></li>'
        );
    });
  });
  await page.setViewportSize({ width: 375, height: 800 });
  await page.goto("/");
  await expectLoggedOut(page);
  await page.locator("#site-navigation .menu-toggle").click();

  const item = page.locator("#site-navigation li", { hasText: "Spec parent" }).last();
  const toggle = item.locator("> .sub-toggle");
  const arrow = toggle.locator(".genericon");

  await expect(arrow).toHaveClass(/genericon-expand/);

  await toggle.click();
  await expect(item.getByRole("link", { name: "Spec child" })).toBeVisible();
  await expect(arrow).toHaveClass(/genericon-collapse/);

  await toggle.click();
  await expect(item.getByRole("link", { name: "Spec child" })).toBeHidden();
  await expect(arrow).toHaveClass(/genericon-expand/);

  const scrollUpLineHeight = await page
    .locator("#scroll-up .genericon")
    .evaluate((el) => getComputedStyle(el, "::before").lineHeight);
  expect(scrollUpLineHeight).not.toBe("22px");
});
