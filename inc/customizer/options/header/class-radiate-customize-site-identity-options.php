<?php
/**
 * Class to include Header Main Area customize options.
 *
 * Class Radiate_Customize_Site_Identity_Options
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
 * Class to include Header Main Area customize options.
 *
 * Class Radiate_Customize_Site_Identity_Options
 */
class Radiate_Customize_Site_Identity_Options extends Radiate_Customize_Base_Option {

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
				'name'     => 'site_icon_heading',
				'type'     => 'control',
				'control'  => 'radiate-title',
				'label'    => esc_html__( 'Site Icon', 'radiate' ),
				'section'  => 'title_tagline',
				'priority' => 8,
			),

			array(
				'name'     => 'site_title_heading',
				'type'     => 'control',
				'control'  => 'radiate-title',
				'label'    => esc_html__( 'Site Title', 'radiate' ),
				'section'  => 'title_tagline',
				'priority' => 9,
			),



			/**
			 * Colors.
			 */
			array(
				'name'     => 'header_text_color_heading',
				'type'     => 'control',
				'control'  => 'radiate-title',
				'label'    => esc_html__( 'Colors', 'radiate' ),
				'section'  => 'title_tagline',
				'priority' => 15,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Site_Identity_Options();
