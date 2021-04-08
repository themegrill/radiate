<?php
/**
 * Class to include Header Primary Menu customize options.
 *
 * Class Radiate_Customize_Primary_Menu_Options
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 2.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to include Header Primary Menu customize options.
 *
 * Class Radiate_Customize_Primary_Menu_Options
 */
class Radiate_Customize_Primary_Menu_Options extends Radiate_Customize_Base_Option {

	/**
	 * Include customize options.
	 *
	 * @param array $options Customize options provided via the theme.
	 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @return mixed|void Customizer options for registering panels, sections as well as controls.
	 */
	public function register_options( $options, $wp_customize ) {

		// Customize transport postMessage variable to set `postMessage` or `refresh` as required.
		$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

		$configs = array(

			// Responsive menu style heading.
			array(
				'name'     => 'header_primary_menu_responsive_style',
				'type'     => 'control',
				'control'  => 'radiate-title',
				'label'    => esc_html__( 'Responsive Menu Style', 'radiate' ),
				'section'  => 'radiate_header_primary_menu',
				'priority' => 60,
			),

			array(
				'name'     => 'radiate_new_menu_enable',
				'default'  => 0,
				'type'     => 'control',
				'control'  => 'checkbox',
				'label'    => esc_html__( 'Switch to full width menu style.', 'radiate' ),
				'section'  => 'radiate_header_primary_menu',
				'priority' => 70,
			),

			array(
				'name'     => 'radiate_responsive_menu_style',
				'default'  => 0,
				'type'     => 'control',
				'control'  => 'checkbox',
				'label'    => esc_html__( 'Switch to new responsive menu style.', 'radiate' ),
				'section'  => 'radiate_header_primary_menu',
				'priority' => 70,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Primary_Menu_Options();
