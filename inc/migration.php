<?php
/**
 * Migration scripts for Radiate theme.
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
 * Migrate all of the customize options for 2.5.0 theme update.
 *
 * @since Radiate 2.3.0
 */
function radiate_major_controls_migrate() {

	$demo_import_migration = radiate_demo_import_migration();

	// Migrate the customize option if migration is done manually.
	if ( ! $demo_import_migration ) {

		// Bail out if the migration is already done.
		if ( get_option( 'radiate_major_controls_migrate' ) ) {
			return;
		}
	}

	$radiate_content_font    = get_theme_mod( 'radiate_content_font', 'Default' );
	$radiate_all_titles_font = get_theme_mod( 'radiate_all_titles_font', 'Default' );

	// Heading migration.
	$radiate_heading_h1_font_size = get_theme_mod( 'radiate_heading_h1_font_size', 30 );
	$radiate_heading_h2_font_size = get_theme_mod( 'radiate_heading_h2_font_size', 28 );
	$radiate_heading_h3_font_size = get_theme_mod( 'radiate_heading_h3_font_size', 26 );
	$radiate_heading_h4_font_size = get_theme_mod( 'radiate_heading_h4_font_size', 24 );
	$radiate_heading_h5_font_size = get_theme_mod( 'radiate_heading_h5_font_size', 22 );
	$radiate_heading_h6_font_size = get_theme_mod( 'radiate_heading_h6_font_size', 19 );

	// Post title.
	$radiate_post_page_title_font_size = get_theme_mod( 'radiate_post_page_title_font_size', 30 );

	// Widget Title font size.
	$radiate_widget_title_font_size = get_theme_mod( 'radiate_widget_title_font_size', 25 );

	// SIte title and tagline.
	$radiate_site_title_font       = get_theme_mod( 'radiate_site_title_font', 'Default' );
	$radiate_site_title_font_size  = get_theme_mod( 'radiate_site_title_font_size', 36 );
	$radiate_site_tagline_font     = get_theme_mod( 'radiate_site_tagline_font', 'Default' );
	$radiate_site_tagline_font_size = get_theme_mod( 'radiate_site_tagline_font_size', 14 );

	// Menu font.
	$radiate_menu_font      = get_theme_mod( 'radiate_menu_font', 'Default' );
	$radiate_menu_font_size = get_theme_mod( 'radiate_menu_font_size', 18 );

	if ( 'Default' !== $radiate_content_font ) {
		set_theme_mod(
			'radiate_content_font_typography',
			array(
				'font-family' => $radiate_content_font,
			)
		);
	}

	if ( 'Default' !== $radiate_all_titles_font ) {
		set_theme_mod(
			'radiate_titles_font_typography',
			array(
				'font-family' => $radiate_all_titles_font,
			)
		);
	}

	if ( 30 !== $radiate_heading_h1_font_size ) {
		set_theme_mod(
			'radiate_h1_heading_font_size_typography',
			array(
				'font-size' => $radiate_heading_h1_font_size,
			)
		);
	}

	if ( 28 !== $radiate_heading_h2_font_size ) {
		set_theme_mod(
			'radiate_h2_heading_font_size_typography',
			array(
				'font-size' => $radiate_heading_h2_font_size,
			)
		);
	}

	if ( 26 !== $radiate_heading_h3_font_size ) {
		set_theme_mod(
			'radiate_h3_heading_font_size_typography',
			array(
				'font-size' => $radiate_heading_h3_font_size,
			)
		);
	}

	if ( 24 !== $radiate_heading_h4_font_size ) {
		set_theme_mod(
			'radiate_h4_heading_font_size_typography',
			array(
				'font-size' => $radiate_heading_h4_font_size,
			)
		);
	}

	if ( 22 !== $radiate_heading_h5_font_size ) {
		set_theme_mod(
			'radiate_h5_heading_font_size_typography',
			array(
				'font-size' => $radiate_heading_h5_font_size,
			)
		);
	}

	if ( 19 !== $radiate_heading_h6_font_size ) {
		set_theme_mod(
			'radiate_h6_heading_font_size_typography',
			array(
				'font-size' => $radiate_heading_h6_font_size,
			)
		);
	}

	// Post Title font size.
	if ( 30 !== $radiate_post_page_title_font_size ) {
		set_theme_mod(
			'radiate_post_page_title_font_size_typography',
			array(
				'font-size' => $radiate_post_page_title_font_size,
			)
		);
	}

	// Widget Title font size.
	if ( 25 !== $radiate_widget_title_font_size ) {
		set_theme_mod(
			'radiate_widget_title_font_size_typography',
			array(
				'font-size' => $radiate_widget_title_font_size,
			)
		);
	}

	// Site title.
	if ( 'Default' !== $radiate_site_title_font || '46' !== $radiate_site_title_font_size ) {
		set_theme_mod(
			'colormag_site_title_typography_setting',
			array(
				'font-family' => $radiate_site_title_font,
				'font-size'   => array(
					'desktop' => $radiate_site_title_font_size,
					'tablet'  => '',
					'mobile'  => '',
				),
			)
		);
	}

	// Site tagline.
	if ( 'Default' !== $radiate_site_tagline_font || '16' !== $radiate_site_tagline_font_size ) {
		set_theme_mod(
			'colormag_site_tagline_typography_setting',
			array(
				'font-family' => $radiate_site_tagline_font,
				'font-size'   => array(
					'desktop' => $radiate_site_tagline_font_size,
					'tablet'  => '',
					'mobile'  => '',
				),
			)
		);
	}

	// Menu.
	if ( 'Default' !== $radiate_menu_font || 18 !== $radiate_menu_font_size ) {
		set_theme_mod(
			'radiate_primary_menu_font_typography',
			array(
				'font-family' => $radiate_menu_font,
				'font-size'   => array(
					'desktop' => $radiate_menu_font_size,
					'tablet'  => '',
					'mobile'  => '',
				),
			)
		);
	}

	/**
	 * Remove unrequired theme mods datas.
	 */
	$remove_theme_mod_settings = array(
		'radiate_content_font',
		'radiate_all_titles_font',
		'radiate_heading_h1_font_size',
		'radiate_heading_h2_font_size',
		'radiate_heading_h3_font_size',
		'radiate_heading_h4_font_size',
		'radiate_heading_h5_font_size',
		'radiate_heading_h6_font_size',
		'radiate_post_page_title_font_size',
		'radiate_widget_title_font_size',
		'radiate_site_title_font',
		'radiate_site_title_font_size',
		'radiate_site_tagline_font',
		'radiate_site_tagline_font_size',
		'radiate_menu_font',
		'radiate_menu_font_size',
	);

	// Loop through the theme mods to remove them.
	foreach ( $remove_theme_mod_settings as $remove_theme_mod_setting ) {
		remove_theme_mod( $remove_theme_mod_setting );
	}

	// Set flag to not repeat the migration process, ie, run it only once.
	update_option( 'radiate_demo_import_migration', true );

	// Set flag for demo import migration to not repeat the migration process, ie, run it only once.
	if ( $demo_import_migration ) {
		update_option( 'radiate_demo_import_migration_notice_dismiss', true );
	}
}

add_action( 'after_setup_theme', 'radiate_major_controls_migrate' );

