<?php
/**
 * Deprecated functions for Radiate theme.
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 1.4.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'radiate_sanitize_radio' ) ) :

	/**
	 * Deprecate function for radio/select sanitization.
	 *
	 * @param string $input Input from the customize controls.
	 * @param WP_Customize_Setting $setting Setting instance.
	 */
	function radiate_sanitize_radio( $input, $setting ) {

		_deprecated_function( __FUNCTION__, '1.4.0', 'Radiate_Customizer_Sanitizes::sanitize_radio_select( $input, $setting )' );

		return Radiate_Customizer_Sanitizes::sanitize_radio_select( $input, $setting );

	}

endif;


if ( ! function_exists( 'radiate_checkbox_sanitize' ) ) :

	/**
	 * Deprecate function for checkbox sanitization.
	 *
	 * @param string $input Input from the customize controls.
	 */
	function radiate_checkbox_sanitize( $input ) {

		_deprecated_function( __FUNCTION__, '1.4.0', 'Radiate_Customizer_Sanitizes::sanitize_checkbox( $input )' );

		return Radiate_Customizer_Sanitizes::sanitize_checkbox( $input );

	}

endif;


if ( ! function_exists( 'radiate_sanitize_hex_color' ) ) :

	/**
	 * Deprecate function for hex color sanitization.
	 *
	 * @param string $color Input from the customize controls.
	 *
	 * @return string
	 */
	function radiate_sanitize_hex_color( $color ) {

		_deprecated_function( __FUNCTION__, '1.4.0', 'Radiate_Customizer_Sanitizes::sanitize_hex_color( $color )' );

		return Radiate_Customizer_Sanitizes::sanitize_hex_color( $color );

	}

endif;

if ( ! function_exists( 'radiate_sanitize_integer' ) ) :

	/**
	 * Deprecate function for integer sanitization.
	 *
	 * @param string $input Input from the customize controls.
	 */
	function radiate_sanitize_integer( $input ) {

		_deprecated_function( __FUNCTION__, '1.4.0' );

	}

endif;

if ( ! function_exists( 'radiate_sanitize_escaping' ) ) :

	/**
	 * Deprecate function for integer sanitization.
	 *
	 * @param string $input Input from the customize controls.
	 */
	function radiate_sanitize_escaping( $input ) {

		_deprecated_function( __FUNCTION__, '1.4.0' );

	}

endif;

if ( ! function_exists( 'radiate_sanitize_important_links' ) ) :

	/**
	 * Deprecate function for important sanitization.
	 *
	 * @param string $input Input from the customize controls.
	 */
	function radiate_sanitize_important_links( $input ) {

		_deprecated_function( __FUNCTION__, '1.4.0' );

	}

endif;

