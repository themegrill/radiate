<?php
/**
 * Radiate customizer class for theme customize options.
 *
 * Class Radiate_Customizer
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 2.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the customizer framework files.
require( dirname( __FILE__ ) . '/core/class-radiate-customizer-framework.php' );
require( dirname( __FILE__ ) . '/core/class-radiate-customize-base-option.php' );

/**
 * Radiate customizer class.
 *
 * Class Radiate_Customizer
 */
class Radiate_Customizer {

	/**
	 * Customizer setup constructor.
	 *
	 * Radiate_Customizer constructor.
	 */
	public function __construct() {

		// Include the required files for Customize option.
		add_action( 'customize_register', array( $this, 'customize_register' ), 12 );

		// Include the required files for Customize option.
		add_action( 'customize_register', array( $this, 'customize_options_file_include' ), 1 );

	}

	/**
	 * Include the required files for extending the custom Customize controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_custom_panels_sections_includes( $wp_customize ) {

		// Include the required customizer nested panels and sections files.
		require RADIATE_CUSTOMIZER_DIR . '/extend-customizer/class-radiate-upsell-section.php';

	}


	/**
	 * Include the required files for extending the custom Customize controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {

		// Override default.
		require RADIATE_CUSTOMIZER_DIR . '/override-defaults.php';

	}

	/**
	 * Register Radiate customize panels, sections and controls type.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register_panels_sections_controls( $wp_customize ) {

		// Register panels and sections.
		$wp_customize->register_panel_type( 'Radiate_WP_Customize_Panel' );
		$wp_customize->register_section_type( 'Radiate_WP_Customize_Section' );
		$wp_customize->register_section_type( 'Radiate_Upsell_Section' );

		/**
		 * Register controls.
		 */
		/**
		 * WordPress default controls.
		 */
		// Checkbox control.
		Radiate_Customize_Base_Control::add_control(
			'checkbox',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_checkbox',
				),
			)
		);

		// Radio control.
		Radiate_Customize_Base_Control::add_control(
			'radio',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_radio_select',
				),
			)
		);

		// Select control.
		Radiate_Customize_Base_Control::add_control(
			'select',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_radio_select',
				),
			)
		);

		// Text control.
		Radiate_Customize_Base_Control::add_control(
			'text',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_nohtml',
				),
			)
		);

		// Number control.
		Radiate_Customize_Base_Control::add_control(
			'number',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_number',
				),
			)
		);

		// Email control.
		Radiate_Customize_Base_Control::add_control(
			'email',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_email',
				),
			)
		);

		// URL control.
		Radiate_Customize_Base_Control::add_control(
			'url',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_url',
				),
			)
		);

		// Textarea control.
		Radiate_Customize_Base_Control::add_control(
			'textarea',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_html',
				),
			)
		);

		// Dropdown pages control.
		Radiate_Customize_Base_Control::add_control(
			'dropdown-pages',
			array(
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_dropdown_pages',
				),
			)
		);

		// Color control.
		Radiate_Customize_Base_Control::add_control(
			'color',
			array(
				'callback'          => 'WP_Customize_Color_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_hex_color',
				),
			)
		);

		// Image upload control.
		Radiate_Customize_Base_Control::add_control(
			'image',
			array(
				'callback'          => 'WP_Customize_Image_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_image_upload',
				),
			)
		);

		// Radio image control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-radio-image',
			array(
				'callback'          => 'Radiate_Radio_Image_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_radio_select',
				),
			)
		);

		// Heading control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-heading',
			array(
				'callback'          => 'Radiate_Heading_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_false_values',
				),
			)
		);

		// Editor control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-editor',
			array(
				'callback'          => 'Radiate_Editor_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_html',
				),
			)
		);

		// Color control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-color',
			array(
				'callback'          => 'Radiate_Color_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_alpha_color',
				),
			)
		);

		// Buttonset control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-buttonset',
			array(
				'callback'          => 'Radiate_Buttonset_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_radio_select',
				),
			)
		);

		// Toggle control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-toggle',
			array(
				'callback'          => 'Radiate_Toggle_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_checkbox',
				),
			)
		);

		// Divider control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-divider',
			array(
				'callback'          => 'Radiate_Divider_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_false_values',
				),
			)
		);

		// Slider control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-slider',
			array(
				'callback'          => 'Radiate_Slider_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_number',
				),
			)
		);

		// Custom control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-custom',
			array(
				'callback'          => 'Radiate_Custom_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_false_values',
				),
			)
		);

		// Dropdown categories control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-dropdown-categories',
			array(
				'callback'          => 'Radiate_Dropdown_Categories_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_dropdown_categories',
				),
			)
		);

		// Background control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-background',
			array(
				'callback'          => 'Radiate_Background_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_background',
				),
			)
		);

		// Typography control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-typography',
			array(
				'callback'          => 'Radiate_Typography_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_typography',
				),
			)
		);

		// Hidden control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-hidden',
			array(
				'callback'          => 'Radiate_Hidden_Control',
				'sanitize_callback' => '',
			)
		);

		// Sortable control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-sortable',
			array(
				'callback'          => 'Radiate_Sortable_Control',
				'sanitize_callback' => array(
					'Radiate_Customizer_Sanitizes',
					'sanitize_sortable',
				),
			)
		);

		// Group control.
		Radiate_Customize_Base_Control::add_control(
			'Radiate-group',
			array(
				'callback' => 'Radiate_Group_Control',
			)
		);

	}

	/**
	 * Include the required files for Customize option.
	 */
	public function customize_options_file_include() {

		// Include the required customize section and panels register file.
		require RADIATE_CUSTOMIZER_DIR . '/class-radiate-customizer-register-sections-panels.php';

		/**
		 * Include the required customize options file.
		 */
		// Global.
		require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-colors-options.php';
		require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-background-options.php';

//		// Header.
		require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-site-identity-options.php';
		require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-primary-header-options.php';
		require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-primary-menu-options.php';


		// Front page featured section.
		require RADIATE_CUSTOMIZER_DIR . '/options/front-page/class-radiate-customize-front-page-options.php';

		// Content.
		require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-single-post-options.php';

	}

}

return new Radiate_Customizer();
