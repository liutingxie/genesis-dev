<?php
/**
 * Template Name: Page Builder
 *
 * This files add the page builder template to the Genesis Dev Theme.
 */

// Remove custom before footer widget area.
remove_action( 'genesis_footer', 'genesis_dev_before_footer', 5 );

// Get site-header.
get_header();

// Custom loop, remove all hooks except entry content.
if ( have_posts() ) :

	while ( have_posts() ) : the_post();

		do_action( 'genesis_entry_content' );

	endwhile; // End of post.

endif; // End loop.

// Get site-footer.
get_footer();