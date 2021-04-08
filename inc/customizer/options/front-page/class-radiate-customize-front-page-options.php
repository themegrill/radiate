<?php
/**
 * Class to include Featured Page on front customize options.
 *
 * Class Radiate_Customize_Front_Page_Options
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
 * Class to include Page customize options.
 *
 * Class Radiate_Customize_Front_Page_Options
 */
class Radiate_Customize_Front_Page_Options extends Radiate_Customize_Base_Option {

	/**
	 * Include customize options.
	 *
	 * @param array $options Customize options provided via the theme.
	 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @return mixed|void Customizer options for registering panels, sections as well as controls.
	 */
	public function register_options( $options, $wp_customize ) {

		$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

		$configs = array(

			array(
				'name'    => 'radiate_featured_page',
				'type'    => 'control',
				'control' => 'radiate-title',
				'section' => 'radiate_front_page_options',
			),

			array(
				'name'     => 'page-setting-one',
				'type'     => 'control',
				'control'  => 'dropdown-pages',
				'label'    => esc_html( 'First featured page', 'radiate' ),
				'section'  => 'radiate_front_page_options',
				'priority' => 20,
			),

			array(
				'name'     => 'page-setting-two',
				'type'     => 'control',
				'control'  => 'dropdown-pages',
				'label'    => esc_html( 'Second featured page', 'radiate' ),
				'section'  => 'radiate_front_page_options',
				'priority' => 20,
			),

			array(
				'name'     => 'page-setting-three',
				'type'     => 'control',
				'control'  => 'dropdown-pages',
				'label'    => esc_html( 'Third featured page', 'radiate' ),
				'section'  => 'radiate_front_page_options',
				'priority' => 20,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Front_Page_Options();
