<?php
/**
 * Class to include Background customize options.
 *
 * Class Radiate_Customize_Background_Options
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
 * Class to include Background customize option.
 *
 * Class Radiate_Customize_Background_Options
 */
class Radiate_Customize_Background_Options extends Radiate_Customize_Base_Option {

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
			 * Global color background options.
			 */
			// Post/Page/Blog general design options heading separator.
			array(
				'name'     => 'global_content_background_heading',
				'type'     => 'control',
				'control'  => 'radiate-title',
				'label'    => esc_html__( 'Outside Container', 'radiate' ),
				'section'  => 'radiate_global_background_section',
				'priority' => 5,
			),

		);

		$options = array_merge( $options, $configs );

		return $options;
	}

}

return new Radiate_Customize_Background_Options();
