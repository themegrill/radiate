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
				'label'   => esc_html__( 'Note:If featured image is set for the following selected pages then the same image will appear in the featured section for the respective pages.', 'radiate' ),
				'section' => 'radiate_front_page_options',
			),

			array(
				'name'    => 'radiate_featured_page_select_option',
				'default' => 9,
				'type'    => 'control',
				'control' => 'text',
				'label'   => esc_html__( 'Enter the number of pages you wish to display. Default value is 9.', 'radiate' ),
				'section' => 'radiate_front_page_options',
			),

		);

		$options = array_merge( $options, $configs );

		for ( $i = 1; $i <= 3; $i++ ) {

			$configs[] = array(
				'name'       => 'page-setting-' . $i,
				'default'    => 9,
				'type'       => 'control',
				'control'    => 'dropdown-pages',
				'label'      => sprintf( esc_html__( 'Featured page %1$s', 'radiate' ), $i ),
				'section'    => 'radiate_front_page_options',
			);
		}

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Front_Page_Options();
