import { test, expect } from "../../fixtures";

/**
 * @area header
 * @tier fresh
 * @source human 2026-09-24
 * @why header.php:55 renders the search icon and form unless
 *      radiate_header_search_hide is set (default 0); custom.js toggles the
 *      form when the icon is clicked. The docs promise the icon "will allow
 *      you to enable/disable the search icon in your header section". Guards
 *      the default-on state and that the form it reveals really searches.
 *      Does not cover the hide setting (needs a theme-mod fixture).
 */
test("the header search icon reveals a search form that returns results @fresh @header", async ({
  page,
}) => {
  await page.setViewportSize({ width: 1440, height: 900 });
  await page.goto("/");

  const banner = page.getByRole("banner");
  const form = banner.getByRole("search");
  await expect(form).toBeHidden();

  await banner.locator(".header-search-icon").click();
  await expect(form).toBeVisible();

  // The header form hides its submit button by design (style.css:744);
  // users submit with Enter.
  const field = form.getByRole("searchbox", { name: "Search for:" });
  await field.fill("a");
  await field.press("Enter");
  await expect(page).toHaveURL(/[?&]s=a\b/);
  await expect(page.getByRole("main").getByRole("article").first()).toBeVisible();
});
