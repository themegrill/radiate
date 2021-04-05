<?php
/**
 * Class to include Colors customize options.
 *
 * Class Radiate_Customize_Colors_Options
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
 * Class to include Colors customize options.
 *
 * Class Radiate_Customize_Colors_Options
 */
class Radiate_Customize_Colors_Options extends Radiate_Customize_Base_Option {

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

			/**
			 * Primary Colors.
			 */
			// Primary color option.
			array(
				'name'     => 'radiate_color_scheme',
				'default'  => '#632E9B',
				'type'     => 'control',
				'control'  => 'radiate-color',
				'label'    => esc_html__( 'Primary Color', 'radiate' ),
				'section'  => 'radiate_primary_colors_section',
				'priority' => 5,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Colors_Options();
