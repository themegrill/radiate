import { type Page } from "@playwright/test";
import { test, expect, expectLoggedOut } from "../../fixtures";
import { ADMIN_STATE, hasAdminCredentials } from "../../utils/login";

/** Pixels the fixed header's top edge sits below the admin bar's bottom edge. */
async function headerGapBelowAdminBar(page: Page): Promise<number> {
  await expect(
    page.locator("#wpadminbar"),
    "admin bar should be rendered for a logged-in user",
  ).toBeAttached();
  const bar = await page.locator("#wpadminbar").boundingBox();
  const header = await page.locator("#masthead .header-wrap").boundingBox();
  expect(bar, "admin bar should be rendered for a logged-in user").not.toBeNull();
  expect(header, "header should be rendered").not.toBeNull();
  return header!.y - (bar!.y + bar!.height);
}

/**
 * @area header
 * @tier fresh
 * @source radiate-qa-report.html — Logged out, clean
 * @why The audit confirmed the fixed header renders fully for logged-out
 *      visitors at 375px. This is the control for the logged-in scenario
 *      below: if it fails too, the header is broken for everyone. Does not
 *      assert the header's height or colours.
 */
test("logged-out visitors see the site title at the top of the page on a phone @fresh @header", async ({
  page,
}) => {
  await page.setViewportSize({ width: 375, height: 812 });
  await page.goto("/");
  await expectLoggedOut(page);

  const title = page.locator("#masthead .site-title a");
  await expect(title).toBeVisible();
  const box = await title.boundingBox();
  expect(box!.y).toBeGreaterThanOrEqual(0);
});

test.describe("logged in", () => {
  test.use({ storageState: ADMIN_STATE });
  test.skip(!hasAdminCredentials(), "TGQA_ADMIN_USER / TGQA_ADMIN_PASS not set");

  /**
   * @area header
   * @tier fresh
   * @source human 2026-09-24
   * @why style.css:691 offsets the fixed header by 32px for the desktop admin
   *      bar. Guards that a logged-in admin on desktop sees the header directly
   *      below the toolbar, not under it. Allows a 1px rounding tolerance.
   */
  test("on desktop the fixed header sits below the admin bar for a logged-in user @fresh @header", async ({
    page,
  }) => {
    await page.setViewportSize({ width: 1440, height: 900 });
    await page.goto("/");

    expect(await headerGapBelowAdminBar(page)).toBeGreaterThanOrEqual(-1);
  });

  // Quarantined: radiate#53 is not fixed yet. Drop `.fixme` in the PR that fixes it.
  /**
   * @area header
   * @tier fresh
   * @guards themegrill/radiate#53
   * @source radiate-qa-report.html — Fixed header collides with WordPress's mobile admin bar
   * @why Logged in at 375px, the header renders under core's 46px mobile admin
   *      bar (measured 2026-09-24: bar absolute at 0–46px, header fixed at 0). NOTE: #53 blames a missing 782px override, but style.css
   *      already has one (:1816); the likelier cause is the ≤600px
   *      `body.admin-bar .header-wrap { top: 0 }` rule (:1974). This asserts the
   *      outcome only, so it holds whichever rule is fixed.
   */
  test.fixme("on a phone the fixed header sits below the admin bar for a logged-in user @fresh @header", async ({
    page,
  }) => {
    await page.setViewportSize({ width: 375, height: 812 });
    await page.goto("/");

    expect(await headerGapBelowAdminBar(page)).toBeGreaterThanOrEqual(-1);
  });
});
