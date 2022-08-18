<?php
/**
 * Template name: Archive
 */

/**
 * Add archive page body class to the head.
 */
function dev_archive_body_class( $classes ) {
	$classes[] = 'archive-page';
	return $classes;
}

add_action( 'body_class', 'dev_archive_body_class' );

// Remove default page content and add custom archive content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'dev_genesis_archive_content' );

function dev_genesis_archive_content() {

    $heading = ( genesis_a11y( 'headings' ) ? 'h2' : 'h4' );

	genesis_sitemap( $heading );

}

genesis();