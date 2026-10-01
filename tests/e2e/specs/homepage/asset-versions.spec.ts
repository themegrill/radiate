import { test, expect } from "../../fixtures";
/**
 * @area homepage
 * @tier fresh
 * @guards radiate-pro#33
 * @source fix/33-asset-versions 2026-09-30; functions.php
 * @why The main stylesheet and custom.js were enqueued without a version, so
 *      WordPress stamped them with the WP core version and a theme update
 *      shipping new CSS/JS kept the old ?ver= (browsers and CDNs served stale
 *      files). Guards that they carry the theme's own Version header. Reads the
 *      Version from the theme's style.css, so it does not go stale on a release.
 */
test("the theme's own stylesheet and script are versioned with the theme version @fresh @homepage", async ({
  page,
  request,
}) => {
  await page.goto("/");

  const styleHref = await page
    .locator("link#radiate-style-css")
    .getAttribute("href");
  const scriptSrc = await page
    .locator("script#radiate-custom-js-js")
    .getAttribute("src");
  expect(styleHref, "radiate-style-css href").toBeTruthy();
  expect(scriptSrc, "radiate-custom-js src").toBeTruthy();

  const css = await (await request.get(styleHref!.split("?")[0])).text();
  const themeVersion = css.match(/^\s*Version:\s*(\S+)/m)?.[1];
  expect(themeVersion, "Version header in style.css").toBeTruthy();

  const ver = (url: string) => new URL(url, "http://x").searchParams.get("ver");
  expect(ver(styleHref!)).toBe(themeVersion);
  expect(ver(scriptSrc!)).toBe(themeVersion);
});
