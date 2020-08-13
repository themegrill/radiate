<?php
/**
 * Radiate Admin Class.
 *
 * @author  ThemeGrill
 * @package Radiate
 * @since   Radiate 1.2.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Radiate_admin' ) ) :

	/**
	 * Radiate_admin class.
	 */
	class Radiate_admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'radiate-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), RADIATE_THEME_VERSION );

			wp_enqueue_script( 'radiate-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), RADIATE_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&radiate-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'radiate' ),
				'nonce'    => wp_create_nonce( 'radiate_demo_import_nonce' ),
			);

			wp_localize_script( 'radiate-plugin-install-helper', 'radiateRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new Radiate_admin();
