<?php
/**
 * Class to register panels and sections for customize options.
 *
 * Class Radiate_Customize_Register_Section_Panels
 *
 * @package    ThemeGrill
 * @subpackage radiate
 * @since      Radiate 2.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to register panels and sections for customize options.
 *
 * Class Radiate_Customize_Register_Section_Panels
 */
class Radiate_Customize_Register_Section_Panels extends Radiate_Customize_Base_Option {

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

			// View Pro Version section.
			array(
				'name'             => 'radiate_customize_upsell_section',
				'type'             => 'section',
				'title'            => esc_html__( 'View Pro Version', 'radiate' ),
				'url'              => 'https://themegrill.com/radiate-pricing/?utm_source=radiate-customizer&utm_medium=view-pro-link&utm_campaign=radiate-pricing',
				'priority'         => 1,
				'section_callback' => 'Radiate_Upsell_Section',
			),

			/**
			 * Panels.
			 */
			array(
				'name'     => 'radiate_global_options',
				'type'     => 'panel',
				'title'    => esc_html__( 'Global', 'radiate' ),
				'priority' => 10,
			),

			array(
				'name'     => 'radiate_header_options',
				'type'     => 'panel',
				'title'    => esc_html__( 'Header', 'radiate' ),
				'priority' => 20,
			),

			array(
				'name'     => 'radiate_slider_options',
				'type'     => 'section',
				'title'    => esc_html__( 'Slider', 'radiate' ),
				'priority' => 30,
			),

			array(
				'name'     => 'radiate_front_page_options',
				'type'     => 'section',
				'title'    => esc_html__( 'Front Page Featured Section', 'radiate' ),
				'priority' => 35,
			),

			array(
				'name'     => 'radiate_content_options',
				'type'     => 'panel',
				'title'    => esc_html__( 'Content', 'radiate' ),
				'priority' => 40,
			),


			// Separator.
			array(
				'name'             => 'separator',
				'type'             => 'section',
				'priority'         => 80,
				'section_callback' => 'Radiate_WP_Customize_Separator',
			),

			/**
			 * Global.
			 */

			// Colors.
			array(
				'name'     => 'radiate_global_color_setting',
				'type'     => 'section',
				'title'    => esc_html__( 'Colors', 'radiate' ),
				'panel'    => 'radiate_global_options',
				'priority' => 10,
			),

			array(
				'name'     => 'radiate_primary_colors_section',
				'type'     => 'section',
				'title'    => esc_html__( 'Primary Colors', 'radiate' ),
				'panel'    => 'radiate_global_options',
				'section'  => 'radiate_global_color_setting',
				'priority' => 10,
			),

			array(
				'name'     => 'radiate_link_colors_section',
				'type'     => 'section',
				'title'    => esc_html__( 'Link Colors', 'radiate' ),
				'panel'    => 'radiate_global_options',
				'section'  => 'radiate_global_color_setting',
				'priority' => 10,
			),

			// Background.
			array(
				'name'     => 'radiate_global_background_section',
				'type'     => 'section',
				'title'    => esc_html__( 'Background', 'radiate' ),
				'panel'    => 'radiate_global_options',
				'priority' => 20,
			),

			/**
			 * Header.
			 */
			array(
				'name'     => 'title_tagline',
				'type'     => 'section',
				'title'    => esc_html__( 'Site Identity', 'radiate' ),
				'panel'    => 'radiate_header_options',
				'priority' => 5,
			),

			array(
				'name'     => 'radiate_header_main',
				'type'     => 'section',
				'title'    => esc_html__( 'Primary Header', 'radiate' ),
				'panel'    => 'radiate_header_options',
				'priority' => 30,
			),

			array(
				'name'     => 'radiate_header_primary_menu',
				'type'     => 'section',
				'title'    => esc_html__( 'Primary Menu', 'radiate' ),
				'panel'    => 'radiate_header_options',
				'priority' => 40,
			),

			/**
			 * Content.
			 */
			array(
				'name'     => 'radiate_post_page_content_options',
				'type'     => 'section',
				'title'    => esc_html__( 'Post/Page', 'radiate' ),
				'panel'    => 'radiate_content_options',
				'priority' => 10,
			),

			array(
				'name'     => 'radiate_single_post_section',
				'type'     => 'section',
				'title'    => esc_html__( 'Single Post', 'radiate' ),
				'panel'    => 'radiate_content_options',
				'priority' => 30,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Register_Section_Panels();
