<?php
/**
 * Helper class for font settings for this theme.
 *
 * Class Radiate_Fonts
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper class for font settings for this theme.
 *
 * Class Radiate_Fonts
 */
class Radiate_Fonts {

	/**
	 * System Fonts
	 *
	 * @var array
	 */
	public static $system_fonts = array();

	/**
	 * Google Fonts
	 *
	 * @var array
	 */
	public static $google_fonts = array();

	/**
	 * Custom Fonts
	 *
	 * @var array
	 */
	public static $custom_fonts = array();

	/**
	 * Font variants
	 *
	 * @var array
	 */
	public static $font_variants = array();

	/**
	 * Google font subsets
	 *
	 * @var array
	 */
	public static $google_font_subsets = array();

	/**
	 * Get system fonts.
	 *
	 * @return mixed|void
	 */
	public static function get_system_fonts() {

		if ( empty( self::$system_fonts ) ) :

			self::$system_fonts = array(

				'default'                                                                                                                              => array(
					'family' => 'default',
					'label'  => 'Default',
				),
				'Georgia,Times,"Times New Roman",serif'                                                                                                 => array(
					'family' => 'Georgia,Times,"Times New Roman",serif',
					'label'  => 'serif',
				),
				'-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif' => array(
					'family' => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif',
					'label'  => 'sans-serif',
				),
				'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'                                                   => array(
					'family' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
					'label'  => 'monospace',
				),

			);

		endif;

		return apply_filters( 'radiate_system_fonts', self::$system_fonts );

	}

	/**
	 * Get Google fonts.
	 * It's array is generated from the google-fonts.json file.
	 *
	 * @return mixed|void
	 */
	public static function get_google_fonts() {

		if ( empty( self::$google_fonts ) ) :

			global $wp_filesystem;
			$google_fonts_file = apply_filters( 'radiate_google_fonts_json_file', dirname(__FILE__) . '/custom-controls/typography/google-fonts.json' );

			if ( ! file_exists( dirname(__FILE__) . '/custom-controls/typography/google-fonts.json' ) ) {
				return array();
			}

			// Require `file.php` file of WordPress to include filesystem check for getting the file contents.
			if ( ! $wp_filesystem ) {
				require_once ABSPATH . '/wp-admin/includes/file.php';
			}

			// Proceed only if the file is readable.
			if ( is_readable( $google_fonts_file ) ) {
				WP_Filesystem();

				$file_contents     = $wp_filesystem->get_contents( $google_fonts_file );
				$google_fonts_json = json_decode( $file_contents, 1 );

				foreach ( $google_fonts_json['items'] as $key => $font ) {

					$google_fonts[ $font['family'] ] = array(
						'family'   => $font['family'],
						'label'    => $font['family'],
						'variants' => $font['variants'],
						'subsets'  => $font['subsets'],
					);

					self::$google_fonts = $google_fonts;

				}
			}

		endif;

		return apply_filters( 'radiate_system_fonts', self::$google_fonts );

	}

	/**
	 * Get custom fonts.
	 *
	 * @return mixed|void
	 */
	public static function get_custom_fonts() {

		return apply_filters( 'radiate_custom_fonts', self::$custom_fonts );

	}

	/**
	 * Get font variants.
	 *
	 * @return mixed|void
	 */
	public static function get_font_variants() {

		if ( empty( self::$font_variants ) ) :

			self::$font_variants = array(
				'100'       => esc_html__( 'Thin 100', 'radiate' ),
				'100italic' => esc_html__( 'Thin 100 Italic', 'radiate' ),
				'200'       => esc_html__( 'Extra-Light 200', 'radiate' ),
				'200italic' => esc_html__( 'Extra-Light 200 Italic', 'radiate' ),
				'300'       => esc_html__( 'Light 300', 'radiate' ),
				'300italic' => esc_html__( 'Light 300 Italic', 'radiate' ),
				'regular'   => esc_html__( 'Regular 400', 'radiate' ),
				'italic'    => esc_html__( 'Regular 400 Italic', 'radiate' ),
				'500'       => esc_html__( 'Medium 500', 'radiate' ),
				'500italic' => esc_html__( 'Medium 500 Italic', 'radiate' ),
				'600'       => esc_html__( 'Semi-Bold 600', 'radiate' ),
				'600italic' => esc_html__( 'Semi-Bold 600 Italic', 'radiate' ),
				'700'       => esc_html__( 'Bold 700', 'radiate' ),
				'700italic' => esc_html__( 'Bold 700 Italic', 'radiate' ),
				'800'       => esc_html__( 'Extra-Bold 800', 'radiate' ),
				'800italic' => esc_html__( 'Extra-Bold 800 Italic', 'radiate' ),
				'900'       => esc_html__( 'Black 900', 'radiate' ),
				'900italic' => esc_html__( 'Black 900 Italic', 'radiate' ),
			);

		endif;

		return apply_filters( 'radiate_font_variants', self::$font_variants );

	}

	/**
	 * Get Google font subsets.
	 *
	 * @return mixed|void
	 */
	public static function get_google_font_subsets() {

		if ( empty( self::$google_font_subsets ) ) :

			self::$google_font_subsets = array(
				'arabic'              => esc_html__( 'Arabic', 'radiate' ),
				'bengali'             => esc_html__( 'Bengali', 'radiate' ),
				'chinese-hongkong'    => esc_html__( 'Chinese (Hong Kong)', 'radiate' ),
				'chinese-simplified'  => esc_html__( 'Chinese (Simplified)', 'radiate' ),
				'chinese-traditional' => esc_html__( 'Chinese (Traditional)', 'radiate' ),
				'cyrillic'            => esc_html__( 'Cyrillic', 'radiate' ),
				'cyrillic-ext'        => esc_html__( 'Cyrillic Extended', 'radiate' ),
				'devanagari'          => esc_html__( 'Devanagari', 'radiate' ),
				'greek'               => esc_html__( 'Greek', 'radiate' ),
				'greek-ext'           => esc_html__( 'Greek Extended', 'radiate' ),
				'gujarati'            => esc_html__( 'Gujarati', 'radiate' ),
				'gurmukhi'            => esc_html__( 'Gurmukhi', 'radiate' ),
				'hebrew'              => esc_html__( 'Hebrew', 'radiate' ),
				'japanese'            => esc_html__( 'Japanese', 'radiate' ),
				'kannada'             => esc_html__( 'Kannada', 'radiate' ),
				'khmer'               => esc_html__( 'Khmer', 'radiate' ),
				'korean'              => esc_html__( 'Korean', 'radiate' ),
				'latin'               => esc_html__( 'Latin', 'radiate' ),
				'latin-ext'           => esc_html__( 'Latin Extended', 'radiate' ),
				'malayalam'           => esc_html__( 'Malayalam', 'radiate' ),
				'myanmar'             => esc_html__( 'Myanmar', 'radiate' ),
				'oriya'               => esc_html__( 'Oriya', 'radiate' ),
				'sinhala'             => esc_html__( 'Sinhala', 'radiate' ),
				'tamil'               => esc_html__( 'Tamil', 'radiate' ),
				'telugu'              => esc_html__( 'Telugu', 'radiate' ),
				'thai'                => esc_html__( 'Thai', 'radiate' ),
				'tibetan'             => esc_html__( 'Tibetan', 'radiate' ),
				'vietnamese'          => esc_html__( 'Vietnamese', 'radiate' ),
			);

		endif;

		return apply_filters( 'radiate_font_variants', self::$google_font_subsets );

	}

}
