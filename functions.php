<?php
/**
 * Dev Pro
 *
 * This file adds the default functionality to the Genesit Dev Theme.
 *
 */
// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Set the localization (do not remove)
load_child_theme_textdomain( 'Genesit Dev', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'genesis-dev' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'GENESIS DEV' );
define( 'CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'CHILD_THEME_URL', get_stylesheet_directory_uri() );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Add HTML5 market structure
add_theme_support( 'html5', array(
	'caption',
	'comment-form',
	'comment-list',
	'gallery',
	'search-form',
) );

// Add excerpt supprot for page, page deserve expert to.
add_post_type_support( 'page', 'excerpt' );

add_theme_support( 'automatic-feed-links' );

// Enable logo option in Customizer -> Site Identity
add_theme_support( 'custom-logo', array(
	'width'       => 200,
	'height'      => 60,
	'flex-width'  => true,
	'flex-height' => true,
	'header-text' => array( '.site-title', '.site-description' ),
) );

// Display custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Reposition primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'dev_genesis_do_nav', 12 );

remove_action( 'genesis_header', 'genesis_do_header' );
add_action( 'genesis_header', 'dev_genesis_do_header' );

add_theme_support( 'custom-header', array(
	'default-image' => get_stylesheet_directory() . '/assets/images/header.png',
	'width' => 1920,
	'height' => 1080,
	'flex-width' => true,
	'flex-height' => true,
	'video'		=> true,
	'header-text' => false,
	'default-text-color' => '#252525',
	'wp-head-callback' => 'dev_custom_header',
) );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add Accessibility support
add_theme_support( 'genesis-accessibility', array(
	'404-page',
	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
) );

// Rename primary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'genesis-dev' ) ) );

// Unregister sidebars
unregister_sidebar( 'sidebar-alt' );

genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Add support for shortcodes in widget area
add_filter( 'widget_text', 'do_shortcode' );

// Custom structural wraps.
add_action( 'genesis_footer', 'dev_footer_wrap_open', 6 );
add_action( 'genesis_footer', 'dev_footer_wrap_close', 13 );

// Add portfolio image size.
add_image_size( 'portfolio', 620, 380, true );

// Structural Wrap
add_theme_support( 'genesis-structural-wraps', array(
	'header',
) );

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_post_content', 'genesis_do_post_image' );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 1 );

// Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Remove Genesis Portfolio Pro default styles.
add_filter( 'genesis_portfolio_load_default_styles', '__return_false' );

// Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

// Reposition the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_dev_hero_section', 'genesis_do_breadcrumbs', 30 );

// Enable WooCommerce support.
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

// Enqueue Fonts
add_action( 'wp_enqueue_scripts', 'genesis_dev_font_scripts' );

function genesis_dev_font_scripts() {
	// Remove Simple Social Icons CSS (included with theme).
	wp_dequeue_style( 'simple-social-icons-font' );

	wp_enqueue_style( 'dev-google-fonts', '//fonts.googleapis.com/css?family=Libre+Franklin:300,300i,400,400i,600,600i,800,800i|Roboto&display=swap', array(), CHILD_THEME_VERSION );

	// Conditionally load woocommerce style
	if ( dev_is_woocommerce_page() ) {
		wp_enqueue_style( 'dev-woocommerce', get_stylesheet_directory_uri() . '/woocommerce.css', array(), CHILD_THEME_VERSION );
	}


	wp_enqueue_script( 'dev-responsive-menu', get_stylesheet_directory_uri() . '/assets/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Enqueue scripts.
	wp_enqueue_script( 'genesis-dev', get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'jquery' ), CHILD_THEME_VERSION, true );

	$output = array(
		'mainMenu' => __( 'Menu', 'genesis-dev' ),
		'subMenu'  => __( 'Menu', 'genesis-dev' ),
	);
	wp_localize_script( 'dev-responsive-menu', 'genesisDevL10n', $output );
}

// Load theme default
include_once( get_stylesheet_directory() . '/inc/helpers.php' );
include_once( get_stylesheet_directory() . '/inc/hero.php' );
include_once( get_stylesheet_directory() . '/inc/general.php' );
include_once( get_stylesheet_directory() . '/inc/customize.php' );
include_once( get_stylesheet_directory() . '/inc/sidebars.php' );
include_once( get_stylesheet_directory() . '/inc/theme-defaults.php' );
include_once( get_stylesheet_directory() . '/inc/woocommerce.php' );

