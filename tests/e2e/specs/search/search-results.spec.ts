import { test, expect } from "../../fixtures";

/**
 * @area search
 * @tier fresh
 * @source radiate-qa-report.html — Confirmed clean (populated search)
 * @why Takes the title of the first post on the front page and searches for
 *      it, so it holds on any site with at least one post rather than
 *      depending on seeded titles. Guards that search.php lists the match.
 *      Does not assert ranking or excerpt formatting.
 */
test("searching for a post's title lists that post @fresh @search", async ({
  page,
}) => {
  await page.goto("/");
  const title = (
    await page.getByRole("main").getByRole("article").first()
      .getByRole("heading").first().innerText()
  ).trim();
  expect(title, "front page should list at least one post").not.toBe("");

  await page.goto(`/?s=${encodeURIComponent(title)}`);
  await expect(
    page.getByRole("main").getByRole("heading", { name: title, exact: true }),
  ).toBeVisible();
});

/**
 * @area search
 * @tier fresh
 * @source radiate-qa-report.html — Confirmed clean (zero-result search)
 * @why The negative case: content-none.php shows "Nothing Found" plus a
 *      working search form to retry with, instead of an empty main region.
 *      Does not assert the exact apology copy below the heading.
 */
test("a search with no matches says so and offers a new search form @fresh @search", async ({
  page,
}) => {
  await page.goto("/?s=zzqx-no-such-post-9f3");

  const main = page.getByRole("main");
  await expect(main.getByRole("heading", { name: "Nothing Found" })).toBeVisible();
  await expect(main.getByRole("article")).toHaveCount(0);

  const retry = main.getByRole("search");
  await expect(retry).toBeVisible();
  await expect(retry.getByRole("searchbox", { name: "Search for:" })).toBeVisible();
});
