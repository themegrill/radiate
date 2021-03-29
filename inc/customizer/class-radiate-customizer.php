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
	public function customize_register( $wp_customize ) {

		// Override default.
		require RADIATE_CUSTOMIZER_DIR . '/override-defaults.php';

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
		// require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-colors-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-background-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-typography-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-layout-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/global/class-radiate-customize-global-general-options.php';

//		// Header.
		// require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-site-identity-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-header-media-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-primary-header-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/header/class-radiate-customize-primary-menu-options.php';

//		// Slider.
		// require RADIATE_CUSTOMIZER_DIR . '/options/slider/class-radiate-customize-slider-options.php';

		// Front page featured section.
		// require RADIATE_CUSTOMIZER_DIR . '/options/front-page/class-radiate-customize-front-page-options.php';

		// Content.
		// require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-post-page-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-blog-archive-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-single-post-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-post-meta-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-sidebar-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/content/class-radiate-customize-comments-options.php';

//		// Footer.
		// require RADIATE_CUSTOMIZER_DIR . '/options/footer/class-radiate-customize-footer-widgets-area-options.php';
		// require RADIATE_CUSTOMIZER_DIR . '/options/footer/class-radiate-customize-footer-bottom-bar-options.php';

//		// WooCommerce.
		// require RADIATE_CUSTOMIZER_DIR . '/options/woocommerce/class-radiate-customize-woocommerce-options.php';
	}

}

return new Radiate_Customizer();
