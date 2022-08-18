<?php
/**
 * Template Name: Landing Page
 *
 * This files add the landing page template to the Genesis Dev Theme.
 *
 */

/**
 * Add landing page body class to the head.
 */
function dev_add_body_class( $classes ) {
	$classes[] = 'landing-page';
	return $classes;
}

add_filter( 'body_class', 'dev_add_body_class' );

// Remove Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

/**
 * Dequeue Skip Links Script.
 */
function dev_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

add_action( 'wp_enqueue_scripts', 'dev_dequeue_skip_links' );

// Force full width content layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'dev_genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove cusotm hero section and setup
remove_action( 'genesis_before', 'genesis_dev_hero_section_setup', 99 );
remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_dev_hero_section' );

// Remove navigation.
remove_theme_support( 'genesis-menus' );

// Remove breadcrumbs.
remove_action( 'genesis_dev_hero_section', 'genesis_do_breadcrumbs', 30 );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_footer', 'genesis_dev_footer_widgets', 5 );
remove_action( 'genesis_footer', 'genesis_dev_before_footer', 5 );
remove_action( 'genesis_footer', 'dev_footer_wrap_open', 6 );
remove_action( 'genesis_footer', 'dev_footer_wrap_close', 13 );

// Run the Genesis loop.
genesis();