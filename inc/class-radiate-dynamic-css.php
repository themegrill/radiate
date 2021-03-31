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
			'.site-title a:hover, a, .header-search-icon:before, #content .comments-area a.comment-edit-link:hover, #content .comments-area a.comment-permalink:hover, #content .comments-area article header cite a:hover,#content .entry-meta span a:hover,#content .entry-title a:hover,.comment .comment-reply-link:hover, .comments-area .comment-author-link a:hover,.entry-meta span:hover,.site-header .menu-toggle,.site-header .menu-toggle:hover, #featured_pages a.more-link:hover, a#scroll-up span, .woocommerce .woocommerce-message::before' => array(
				'color' => esc_html( $primary_color ),
			),
			'#masthead .search-form,.main-navigation a:hover,.main-navigation ul li ul li a:hover,.main-navigation ul li ul li:hover>a,.main-navigation ul li.current-menu-ancestor a,.main-navigation ul li.current-menu-item a,.main-navigation ul li.current-menu-item ul li a:hover,.main-navigation ul li.current_page_ancestor a,.main-navigation ul li.current_page_item a,.main-navigation ul li:hover>a, button,input[type=button],input[type=reset],input[type=submit], .main-small-navigation ul li ul li a:hover,.main-small-navigation ul li:hover,.main-small-navigation ul li a:hover,.main-small-navigation ul li ul li:hover>a,.main-small-navigation ul > .current_page_item, .main-small-navigation ul > .current-menu-item,.main-small-navigation ul li.current-menu-item ul li a:hover, a#back-top:before, .woocommerce ul.products li.product .onsale,.woocommerce span.onsale,.woocommerce #respond input#submit:hover, .woocommerce a.button:hover,
			.wocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover,
			.woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover' => array(
				'background-color' => esc_html( $primary_color ),
			),
			'.main-small-navigation ul li ul li.current-menu-item > a' => array(
				'background' => esc_html( $primary_color ),
			),
			'blockquote' => array(
				'border-left-color' => esc_html( $primary_color ),
			),
//			'' => array(
//				'background' => esc_html( $primary_dark ),
//			),
			'#featured_pages a.more-link:hover' => array(
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

