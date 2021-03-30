<?php
/**
 * Radiate dynamic CSS generation file for theme options.
 *
 * Class Radiate_Dynamic_CSS
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 1.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Radiate dynamic CSS generation file for theme options.
 *
 * Class Radiate_Dynamic_CSS
 */
class Radiate_Dynamic_CSS {

	/**
	 * Return dynamic CSS output.
	 *
	 * @param string $dynamic_css Dynamic CSS.
	 * @param string $dynamic_css_filtered Dynamic CSS Filters.
	 *
	 * @return string Generated CSS.
	 */
	public static function render_output( $dynamic_css, $dynamic_css_filtered = '' ) {

		/**
		 * Variable declarations.
		 */
		// Primary color.
		$primary_color = get_theme_mod( 'radiate_color_scheme', '#632e9b' );
		$primary_dark  = radiate_darkcolor( $primary_color, -50 );

		// Generate dynamic CSS.
		$parse_css = '';

		// For primary color option.
		$primary_color_css = array(
			'a, .site-title a:hover, .header-search-icon:before,.default-style2 .widget li::before,.posted-on:hover a span, .posted-on:hover a span.day, #content .entry-title a:hover, .entry-meta span:hover, #content .entry-meta span a:hover, #content .comments-area article header cite a:hover, #content .comments-area a.comment-edit-link:hover, #content .comments-area a.comment-permalink:hover, .comments-area .comment-author-link a:hover, .comment .comment-reply-link:hover, .site-header .menu-toggle, .site-header .menu-toggle:hover, #featured_pages a.more-link:hover,.layout-one.layout-two #content a.more-link:hover, a#scroll-up span' => array(
				'color' => esc_html( $primary_color ),
			),
			'.main-navigation a:hover, .main-navigation ul li.current-menu-item a, .main-navigation ul li.current_page_ancestor a, .main-navigation ul li.current-menu-ancestor a, .main-navigation ul li.current_page_item a, .main-navigation ul li:hover > a, .main-navigation ul li ul li a:hover, .main-navigation ul li ul li:hover > a, .main-navigation ul li.current-menu-item ul li a:hover, #masthead .search-form,.default-style2 .widget-title::before, button, input[type="button"], input[type="reset"], input[type="submit"], .main-small-navigation ul li ul li a:hover, .main-small-navigation ul li ul li:hover > a, .main-small-navigation ul li.current-menu-item ul li a:hover, a#back-top:before, .comments-area .comment-author-link span, .slider-meta .slider-button a:hover, .slider-nav a:hover' => array(
				'background-color' => esc_html( $primary_color ),
			),
			'.main-small-navigation li:hover, .main-small-navigation ul > .current_page_item, .main-small-navigation ul > .current-menu-item, .main-small-navigation ul li ul li.current-menu-item > a' => array(
				'background' => esc_html( $primary_color ),
			),
			'blockquote' => array(
				'border-left-color' => esc_html( $primary_color ),
			),
//			'' => array(
//				'background' => esc_html( $primary_dark ),
//			),
			'#featured_pages a.more-link:hover,.layout-one.layout-two #content a.more-link:hover, .slider-meta .slider-button a:hover, .slider-nav a:hover' => array(
				'border-color' => esc_html( $primary_color ),
			),
		);

		$parse_css .= radiate_parse_css( '#632e9b', $primary_color, $primary_color_css );

		// Add the custom CSS rendered dynamically, which is static.
		$parse_css .= self::render_custom_output();


		$parse_css .= $dynamic_css;

		return apply_filters( 'radiate_theme_dynamic_css', $parse_css );

	}

}

