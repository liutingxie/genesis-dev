<?php
/**
 * Genesis Dev Theme
 *
 * This file adds the front page to the Genesis Dev Theme.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// Check if any front page widgets are active.
if ( is_active_sidebar( 'front-page-1' ) ||
	 is_active_sidebar( 'front-page-2' ) ||
	 is_active_sidebar( 'front-page-3' ) ||
	 is_active_sidebar( 'front-page-4' ) ||
	 is_active_sidebar( 'front-page-5' ) ||
	 is_active_sidebar( 'front-page-6' )  ) {

	// Force full-width-content layout.
	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	// Remove content-sidebar-wrap.
	add_filter( 'genesis_markup_content-sidebar-wrap', '__return_null' );

	// Remove custom hero section.
	remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_dev_hero_section' );

	// Remove default loop.
	remove_action( 'genesis_loop', 'genesis_do_loop' );

	add_filter( 'body_class', 'dev_front_body_class' );

}

function dev_front_body_class( $classes ) {
	$classes[] = 'front-page';

	return $classes;
}


function dev_front_page_widgets() {
	if ( is_paged() && ! is_front_page() ) {
		return;
	}

	$count_front_page_widgets = get_option( 'dev_front_page_widget', 6 );

	// Loop through dynamic widget areas.
	for ( $i = 1; $i <= $count_front_page_widgets; $i++ ) {
		if ( $i === 1 && is_active_sidebar( 'front-page-1' ) ) : ?>
			<div class="front-page-1 hero-section front-widget-area" role="banner">
			<?php the_custom_header_markup(); ?>
				<div class="wrap">
				<?php
					genesis_widget_area( "front-page-1", array(
						'before' => false,
						'after'  => false,
					) );
				?>
				</div>
			</div>
		<?php else :

			genesis_widget_area( "front-page-$i", array(
					'before' => sprintf( '<div class="front-page-%s front-widget-area" %s><div class="wrap">', $i, $i == 3 ? 'id="front-page-3"' : '' ),
					'after'  => sprintf( '</div></div>' ),
				)
			);

		endif;
	}
}

// Add action front page widgets to before content sidebar wrap hook.
add_action( 'genesis_loop', 'dev_front_page_widgets' );

// Run genesis
genesis();