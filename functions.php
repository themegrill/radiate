<?php
/**
 * Radiate functions and definitions
 *
 * @package    ThemeGrill
 * @subpackage Radiate
 * @since      Radiate 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 768; /* pixels */
}

if ( ! function_exists( 'radiate_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function radiate_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on radiate, use a find and replace
		 * to change 'radiate' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'radiate', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 * Post thumbail is used for pages that are shown in the featured section of Front page.
		 */
		add_theme_support( 'post-thumbnails' );

		// Gutenberg wide layout support.
		add_theme_support( 'align-wide' );

		// Gutenberg block layout support.
		add_theme_support( 'wp-block-styles' );

		// Gutenberg editor support.
		add_theme_support( 'responsive-embeds' );

		// Supporting title tag via add_theme_support (since WordPress 4.1)
		add_theme_support( 'title-tag' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'radiate' ),
			)
		);

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

		// Setup the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'radiate_custom_background_args',
				array(
					'default-color' => 'EAEAEA',
					'default-image' => '',
				)
			)
		);

		// Adding excerpt option box for pages as well
		add_post_type_support( 'page', 'excerpt' );

		// Cropping images to different sizes to be used in the theme
		add_image_size( 'featured-image-medium', 768, 350, true );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Gutenberg wide layout support.
		add_theme_support( 'align-wide' );

		// Gutenberg block styles support.
		add_theme_support( 'wp-block-styles' );

		// Gutenberg responsive embeds support.
		add_theme_support( 'responsive-embeds' );

		// Enable support for WooCommerce
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
endif; // radiate_setup
add_action( 'after_setup_theme', 'radiate_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function radiate_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'radiate' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}

add_action( 'widgets_init', 'radiate_widgets_init' );

/**
 * Assign the Radiate version to a variable.
 */
$radiate_theme = wp_get_theme( 'radiate' );

define( 'RADIATE_THEME_VERSION', $radiate_theme->get( 'Version' ) );

/**
 * Enqueue Google fonts and editor styles.
 */
function radiate_block_editor_styles() {
	wp_enqueue_style( 'radiate-editor-googlefonts', '//fonts.googleapis.com/css2?family=Roboto|Merriweather:400,300' );
	wp_enqueue_style( 'radiate-block-editor-styles', get_template_directory_uri() . '/style-editor-block.css' );
}

add_action( 'enqueue_block_editor_assets', 'radiate_block_editor_styles', 1, 1 );


/**
 * Define URL Location Constants
 */
define( 'RADIATE_PARENT_DIR', get_template_directory() );
define( 'RADIATE_INCLUDES_DIR', RADIATE_PARENT_DIR . '/inc' );
define( 'RADIATE_CUSTOMIZER_DIR', RADIATE_INCLUDES_DIR . '/customizer' );

define( 'RADIATE_PARENT_URL', get_template_directory_uri() );
define( 'RADIATE_INCLUDES_URL', RADIATE_PARENT_URL . '/inc' );
define( 'RADIATE_CUSTOMIZER_URL', RADIATE_INCLUDES_URL . '/customizer' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/class-radiate-customizer.php';
require get_template_directory() . '/inc/customizer/class-radiate-customizer-partials.php';
require_once RADIATE_INCLUDES_DIR . '/class-radiate-dynamic-css.php';
require_once RADIATE_INCLUDES_DIR . '/enqueue-scripts.php';
require_once RADIATE_INCLUDES_DIR . '/migration.php';
require_once RADIATE_INCLUDES_DIR . '/demo-import-migration.php';
require_once RADIATE_INCLUDES_DIR . '/depreciated/depreciated-functions.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Calling in the admin area for the Welcome Page as well as for the new theme notice too.
 */
if ( is_admin() ) {
	require get_template_directory() . '/inc/admin/class-radiate-admin.php';
	require get_template_directory() . '/inc/admin/class-radiate-dashboard.php';
	require get_template_directory() . '/inc/admin/class-radiate-notice.php';
	require get_template_directory() . '/inc/admin/class-radiate-welcome-notice.php';
	require get_template_directory() . '/inc/admin/class-radiate-upgrade-notice.php';
	require get_template_directory() . '/inc/admin/class-radiate-theme-review-notice.php';
}


