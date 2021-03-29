<?php
/**
 * Class to include Header General customize options.
 *
 * Class Radiate_Customize_Primary_Header_Options
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
 * Class to include Header General customize options.
 *
 * Class Radiate_Customize_Primary_Header_Options
 */
class Radiate_Customize_Primary_Header_Options extends Radiate_Customize_Base_Option {

	/**
	 * Include customize options.
	 *
	 * @param array $options Customize options provided via the theme.
	 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
	 *
	 * @return mixed|void Customizer options for registering panels, sections as well as controls.
	 */
	public function register_options( $options, $wp_customize ) {

		$configs = array(

			array(
				'name'     => 'radiate_header_search_hide_heading',
				'type'     => 'control',
				'control'  => 'radiate-title',
				'label'    => esc_html__( 'Header Search Icon.', 'radiate' ),
				'section'  => 'radiate_header_main',
				'priority' => 10,
			),

			array(
				'name'     => 'radiate_header_search_hide',
				'default'  => 0,
				'type'     => 'control',
				'control'  => 'checkbox',
				'label'    => esc_html__( 'Check to hide Header Search Icon.', 'radiate' ),
				'section'  => 'radiate_header_main',
				'priority' => 10,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Primary_Header_Options();
