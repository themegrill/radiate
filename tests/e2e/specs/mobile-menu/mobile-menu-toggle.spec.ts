import { test, expect } from "@playwright/test";

const MOBILE = { width: 375, height: 812 };
const DESKTOP = { width: 1440, height: 900 };

/**
 * @area mobile-menu
 * @tier fresh
 * @source radiate-qa-report.html — Radiate Free, mobile navigation
 * @why js/navigation.js swaps #site-navigation between .main-navigation and
 *      .main-small-navigation when the toggle is clicked. The mobile menu is
 *      the most-fixed area in git history (#5, #41, 9545764, 0986d8b…). Guards
 *      open and close with the default responsive style; does not cover the
 *      "better responsive" style, which custom.js drives instead.
 */
test("the toggle opens and closes the primary menu at a phone viewport @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize(MOBILE);
  await page.goto("/");

  // Assert on the first menu link, not the <ul>: its items float, so the list
  // itself has zero height and Playwright would report it hidden regardless.
  const nav = page.locator("#site-navigation");
  const toggle = nav.locator(".menu-toggle");
  const menu = nav.getByRole("link").first();

  await expect(toggle).toBeVisible();
  await expect(menu).toBeHidden();

  await toggle.click();
  await expect(nav).toHaveClass(/main-small-navigation/);
  await expect(menu).toBeVisible();

  await toggle.click();
  await expect(nav).toHaveClass(/main-navigation/);
  await expect(menu).toBeHidden();
});

/**
 * @area mobile-menu
 * @tier fresh
 * @source human 2026-09-24
 * @why The negative half of the toggle: on desktop the toggle is display:none
 *      and the menu is shown inline. Catches a responsive rule leaking up a
 *      breakpoint. Does not assert menu item styling.
 */
test("desktop shows the primary menu inline with no toggle @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize(DESKTOP);
  await page.goto("/");

  const nav = page.locator("#site-navigation");
  await expect(nav.locator(".menu-toggle")).toBeHidden();
  await expect(nav.getByRole("link").first()).toBeVisible();
});

// Quarantined: radiate#52 is not fixed yet. Drop `.fixme` in the PR that fixes it.
/**
 * @area mobile-menu
 * @tier fresh
 * @guards themegrill/radiate#52
 * @source radiate-qa-report.html — Mobile navigation is inaccessible to screen readers
 * @why header.php:63 renders the toggle as an empty <h4 class="menu-toggle">:
 *      no accessible name, no button role, no aria-expanded even after it
 *      opens the menu (WCAG 4.1.2). Encodes the desired behaviour; expected to
 *      fail until #52 is fixed. Does not prescribe the exact label text.
 */
test.fixme("the mobile toggle is a named button that reports its expanded state @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize(MOBILE);
  await page.goto("/");

  const toggle = page.locator("#site-navigation").getByRole("button");
  await expect(toggle).toHaveAccessibleName(/\S/);
  await expect(toggle).toHaveAttribute("aria-expanded", "false");
  await toggle.click();
  await expect(toggle).toHaveAttribute("aria-expanded", "true");
});

// Quarantined: radiate#52 is not fixed yet. Drop `.fixme` in the PR that fixes it.
/**
 * @area mobile-menu
 * @tier fresh
 * @guards themegrill/radiate#52
 * @source radiate-qa-report.html — Mobile navigation is inaccessible to screen readers
 * @why Because the toggle is an <h4>, the mobile heading outline reads
 *      H1 (site title) → H4 (empty) → H2 (first post) (WCAG 2.4.6). Guards
 *      that the toggle is not a heading; does not audit the rest of the
 *      outline.
 */
test.fixme("the mobile toggle does not add an empty heading to the outline @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize(MOBILE);
  await page.goto("/");

  await expect(
    page.locator("#site-navigation").getByRole("heading"),
  ).toHaveCount(0);
});

// Quarantined: radiate#52 is not fixed yet. Drop `.fixme` in the PR that fixes it.
/**
 * @area mobile-menu
 * @tier fresh
 * @guards themegrill/radiate#52
 * @source radiate-qa-report.html — Evidence, dropdowns
 * @why Dropdown parents are plain <a> with no aria-haspopup / aria-expanded,
 *      so screen-reader users get no signal a submenu exists. Needs a nested
 *      menu, which the CI blueprint seeds ("Dropdown Parent"); skips on a site
 *      without one rather than passing vacuously.
 */
test.fixme("dropdown parents announce that they open a submenu @fresh @mobile-menu", async ({
  page,
}) => {
  await page.setViewportSize(DESKTOP);
  await page.goto("/");

  const parents = page.locator(
    "#site-navigation .menu-item-has-children > a, #site-navigation .page_item_has_children > a",
  );
  test.skip((await parents.count()) === 0, "no nested menu on this site");

  const first = parents.first();
  await expect(first).toHaveAttribute("aria-haspopup", "true");
  await expect(first).toHaveAttribute("aria-expanded", "false");
});
