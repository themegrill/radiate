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
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'radiate-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), SUFFICE_THEME_VERSION );

			wp_enqueue_script( 'radiate-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), SUFFICE_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&radiate-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'radiate' ),
				'nonce'    => wp_create_nonce( 'radiate_demo_import_nonce' ),
			);

			wp_localize_script( 'radiate-plugin-install-helper', 'radiateRedirectDemoPage', $welcome_data );
		}

		/**
		 * Add admin menu.
		 */
		public function admin_menu() {
			$theme = wp_get_theme( get_template() );
			$page  = add_theme_page(
				esc_html__( 'About', 'radiate' ) . ' ' . $theme->display( 'Name' ),
				esc_html__( 'About', 'radiate' ) . ' ' . $theme->display( 'Name' ),
				'activate_plugins',
				'radiate-welcome',
				array(
					$this,
					'welcome_screen',
				)
			);
			add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Enqueue styles.
		 */
		public function enqueue_styles() {
			wp_enqueue_style( 'radiate-welcome', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), RADIATE_THEME_VERSION );
		}


		/**
		 * Intro text/links shown to all about pages.
		 *
		 * @access private
		 */
		private function intro() {

			$theme = wp_get_theme( get_template() );

			// Drop minor version if 0
			$major_version = substr( RADIATE_THEME_VERSION, 0, 3 );
			?>
			<div class="radiate-theme-info">
				<h1>
					<?php esc_html_e( 'About', 'radiate' ); ?>
					<?php echo $theme->display( 'Name' ); ?>
					<?php printf( '%s', $major_version ); ?>
				</h1>

				<div class="welcome-description-wrap">
					<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

					<div class="radiate-screenshot">
						<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.jpg'; ?>" />
					</div>
				</div>
			</div> <!-- /.radiate-theme-info -->

			<p class="radiate-actions">
				<a href="<?php echo esc_url( 'https://themegrill.com/themes/radiate/?utm_source=radiate-about&utm_medium=theme-info-link&utm_campaign=theme-info' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'radiate' ); ?></a>

				<a href="<?php echo esc_url( 'https://demo.themegrill.com/radiate/' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'radiate' ); ?></a>

				<a href="<?php echo esc_url( 'https://themegrill.com/themes/radiate/?utm_source=radiate-about&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'radiate' ); ?></a>

				<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/radiate/reviews/?filter=5' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'radiate' ); ?></a>
			</p> <!-- /.radiate-actions -->

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab
				<?php
				if ( empty( $_GET['tab'] ) && $_GET['page'] == 'radiate-welcome' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'radiate-welcome' ), 'themes.php' ) ) ); ?>">
					<?php echo $theme->display( 'Name' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'radiate-welcome',
								'tab'  => 'supported_plugins',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Supported Plugins', 'radiate' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'radiate-welcome',
								'tab'  => 'free_vs_pro',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Free Vs Pro', 'radiate' ); ?>
				</a>
				<a class="nav-tab
				<?php
				if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) {
					echo 'nav-tab-active';
				}
				?>
				" href="
				<?php
				echo esc_url(
					admin_url(
						add_query_arg(
							array(
								'page' => 'radiate-welcome',
								'tab'  => 'changelog',
							),
							'themes.php'
						)
					)
				);
				?>
				">
					<?php esc_html_e( 'Changelog', 'radiate' ); ?>
				</a>
			</h2>
			<?php
		}

		/**
		 * Welcome screen page
		 */
		public function welcome_screen() {
			$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

			// Look for a {$current_tab}_screen method.
			if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
				return $this->{$current_tab . '_screen'}();
			}

			// Fallback to about screen.
			return $this->about_screen();
		}

		public function about_screen() {
			$theme = wp_get_theme( get_template() );
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<div class="changelog point-releases">
					<div class="under-the-hood two-col">
						<div class="col">
							<h3><?php esc_html_e( 'Import Demo', 'radiate' ); ?></h3>
							<p><?php esc_html_e( 'Needs ThemeGrill Demo Importer plugin.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo esc_url( network_admin_url( 'plugin-install.php?tab=search&type=term&s=themegrill-demo-importer' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install', 'radiate' ); ?></a>
							</p>
						</div>
						<div class="col">
							<h3><?php esc_html_e( 'Theme Customizer', 'radiate' ); ?></h3>
							<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'radiate' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Documentation', 'radiate' ); ?></h3>
							<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://docs.themegrill.com/radiate/?utm_source=radiate-about&utm_medium=documentation-link&utm_campaign=documentation' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Documentation', 'radiate' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got theme support question?', 'radiate' ); ?></h3>
							<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/support-forum/?utm_source=radiate-about&utm_medium=support-forum-link&utm_campaign=support-forum' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Support Forum', 'radiate' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Need more features?', 'radiate' ); ?></h3>
							<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/themes/radiate/?utm_source=radiate-about&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ); ?>" target="_blank " class="button button-secondary"><?php esc_html_e( 'View Pro', 'radiate' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3><?php esc_html_e( 'Got sales related question?', 'radiate' ); ?></h3>
							<p><?php esc_html_e( 'Please send it via our sales contact page.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'https://themegrill.com/contact/?utm_source=radiate-about&utm_medium=contact-page-link&utm_campaign=contact-page' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'radiate' ); ?></a>
							</p>
						</div>

						<div class="col">
							<h3>
								<?php
								esc_html_e( 'Translate', 'radiate' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</h3>
							<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'radiate' ); ?></p>
							<p>
								<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/radiate' ); ?>" target="_blank" class="button button-secondary">
									<?php
									esc_html_e( 'Translate', 'radiate' );
									echo ' ' . $theme->display( 'Name' );
									?>
								</a>
							</p>
						</div>

					</div>
				</div> <!-- /.changelog -->

			</div> <!-- /.about-wrap -->
			<?php
		}

		/**
		 * Output the supported plugins screen.
		 */
		public function supported_plugins_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'radiate' ); ?></p>
				<ol>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'radiate' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'radiate' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'radiate' ); ?></a>
						<?php esc_html_e( ' by ThemeGrill', 'radiate' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'radiate' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><?php esc_html_e( 'WooCommerce', 'radiate' ); ?></a>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wordpress.org/plugins/polylang/' ); ?>" target="_blank"><?php esc_html_e( 'Polylang', 'radiate' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'radiate' ); ?>
					</li>
					<li>
						<a href="<?php echo esc_url( 'https://wpml.org/' ); ?>" target="_blank"><?php esc_html_e( 'WPML', 'radiate' ); ?></a>
						<?php esc_html_e( 'Fully Compatible in Pro Version', 'radiate' ); ?>
					</li>
				</ol>

			</div> <!-- /.wrap about-wrap -->
			<?php
		}

		/**
		 * Output the free vs pro screen.
		 */
		public function free_vs_pro_screen() {
			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'radiate' ); ?></p>

				<div class="btn-wrapper">
					<a href="<?php echo esc_url( apply_filters( 'radiate_pro_theme_url', 'https://themegrill.com/themes/radiate/?utm_source=radiate-free-vs-pro-table&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View Pro', 'radiate' ); ?></a>
				</div>

			</div> <!-- /.about-wrap -->
			<?php
		}

		/**
		 * Output the changelog screen.
		 */
		public function changelog_screen() {
			global $wp_filesystem;

			?>
			<div class="wrap about-wrap">

				<?php $this->intro(); ?>

				<p class="about-description"><?php esc_html_e( 'View changelog below:', 'radiate' ); ?></p>

				<?php
				$changelog_file = apply_filters( 'radiate_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog      = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
				?>
			</div> <!-- /.about-wrap -->
			<?php
		}

		/**
		 * Parse changelog from readme file.
		 *
		 * @param  string $content
		 *
		 * @return string
		 */
		private function parse_changelog( $content ) {
			$matches   = null;
			$regexp    = '~==\s*CHANGE LOG\s*==(.*)($)~Uis';
			$changelog = '';

			if ( preg_match( $regexp, $content, $matches ) ) {
				$changes = explode( '\r\n', trim( $matches[1] ) );

				$changelog .= '<pre class="changelog">';

				foreach ( $changes as $index => $line ) {
					$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
				}

				$changelog .= '</pre>';
			}

			return wp_kses_post( $changelog );
		}

	}

endif;

return new Radiate_admin();
