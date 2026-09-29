import { test, expect } from "@playwright/test";

/**
 * @area mobile-menu
 * @tier fresh
 * @guards radiate#49
 * @source fix/submenu-viewport-overflow 2026-09-29; js/navigation.js, style.css
 * @why Submenus opened past the right edge of the viewport when their parent
 *      sat at the end of the menu. Guards that every open level stays inside
 *      the viewport. The menu items are injected into the primary menu because
 *      a fresh site has no nested menu and navigation.js listens on the
 *      container. Does not assert the flip direction or the RTL layout.
 */
test("nested submenus at the menu edge stay inside the viewport @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1280, height: 800 });
  await page.goto("/");

  await page.evaluate(() => {
    const list = document.querySelector("#site-navigation ul") as HTMLElement;
    list.insertAdjacentHTML(
      "beforeend",
      '<li class="menu-item menu-item-has-children"><a href="#">Spec edge one</a>' +
        '<ul class="sub-menu"><li class="menu-item menu-item-has-children"><a href="#">Spec edge two</a>' +
        '<ul class="sub-menu"><li class="menu-item"><a href="#">Spec edge three</a></li></ul></li></ul></li>'
    );
  });

  const nav = page.locator("#site-navigation");
  await nav.getByRole("link", { name: "Spec edge one" }).hover();
  await nav.getByRole("link", { name: "Spec edge two" }).hover();

  const viewport = page.viewportSize()!;
  for (const name of ["Spec edge two", "Spec edge three"]) {
    const box = await nav.getByRole("link", { name }).boundingBox();
    expect(box!.x + box!.width, `${name} inside the viewport`).toBeLessThanOrEqual(viewport.width);
  }
});
