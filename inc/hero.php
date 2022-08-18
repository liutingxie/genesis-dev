<?php
/**
 * This file adds hero section functionality to the Genesis Dev theme.
 */


function genesis_dev_hero_section_setup() {

	// Remove default hero section
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title', 10 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 12 );
	remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_open', 5, 3 );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_close', 15, 3 );
	remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
	remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
	remove_action( 'genesis_before_loop', 'genesis_do_search_title' );


	// Remove search results and shop page titles.
	add_filter( 'genesis_search_title_output', '__return_false' );

	// Add custom hero section.
	add_action( 'genesis_dev_hero_section', 'genesis_dev_title', 10 );
	add_action( 'genesis_dev_hero_section', 'genesis_dev_subtitle', 20 );
	add_action( 'genesis_dev_hero_section', 'genesis_do_posts_page_heading' );
	add_action( 'genesis_dev_hero_section', 'genesis_do_date_archive_title' );
	add_action( 'genesis_dev_hero_section', 'genesis_do_taxonomy_title_description' );
	add_action( 'genesis_dev_hero_section', 'genesis_do_author_title_description' );
	add_action( 'genesis_dev_hero_section', 'genesis_do_cpt_archive_title_description' );

}

add_action( 'genesis_before', 'genesis_dev_hero_section_setup', 99 );

/**
 * Get the title.
 */
function genesis_dev_title() {

	// Add post titles back inside posts loop.
	if ( is_home() || is_archive() || is_category() || is_tag() || is_tax() || is_search() || is_page_template( 'page_blog.php' ) ) {

		add_action( 'genesis_entry_header', 'genesis_do_post_title', 2 );

	}

	if ( class_exists('WooCommerce') && is_shop() ) {

		genesis_markup( array(
			'open'     => '<h1 %s>',
			'close'    => '</h1>',
			'content'  => get_the_title( wc_get_page_id('shop') ),
			'context'  => 'entry-title',
		) );

	} elseif ( 'posts' === get_option( 'show_on_front' ) && is_home() ) {

		genesis_markup( array(
			'open'     => '<h1 %s>',
			'close'    => '</h1>',
			'content'  => __( 'Latest Posts', 'genesis-dev' ),
			'context'  => 'entry-title',
		) );

	} elseif ( is_404() ) {

		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'	  => '</h1>',
			'content' => __( 'Not Found, Error 404', 'genesis-dev' ),
			'context' => 'entry-title',
		) );

	} elseif ( is_search() ) {

		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => __( 'Search results for: ', 'genesis-dev' )  . get_search_query(),
			'context' => 'entry-title',
		) );

	} elseif ( is_page_template( 'page_blog.php' ) ) {

		do_action( 'genesis_archive_title_descriptions', get_the_title(), '', 'posts-page-description' );

	} elseif ( is_single() || is_singular() ) {

		genesis_do_post_title();

	}
}

/**
 * Get the subtitle.
 */
function genesis_dev_subtitle() {

	$subtitle = '';

	if ( class_exists('WooCommerce') && is_shop() ) {

		$subtitle = woocommerce_result_count();

	} elseif ( is_home() ) {

		$subtitle = esc_html( get_the_excerpt( get_option( 'page_for_posts' ) ) );

	} elseif ( is_search() ) {

		$subtitle = __( 'This is the search results page', 'genesis-dev' );

	} elseif ( is_404() ) {

		$subtitle = __( 'Not Found, Error 404', 'genesis-dev' );

	} elseif ( ( is_single() || is_singular() ) && ! is_singular( 'product' ) && has_excerpt() ) {

		$subtitle = esc_html( get_the_excerpt() );

	}

	// Output subtitle
	if ( $subtitle ) {

		printf( '<p itemprop="description">%s</p>', esc_html( $subtitle ) );

	}
}

/**
 * Disply the hero section
 */
function genesis_dev_hero_section() {

	// Output hero section markup.
	genesis_markup( array (
		'open'	  => '<section %s><div class="wrap">',
		'context' => 'hero-section',
	) );

	/**
	 * Do hero section hook.
	 */
	do_action( 'genesis_dev_hero_section' );

	// Output hero section markup.
	genesis_markup( array (
		'close'   => '</div></section>',
		'context' => 'hero-section',
	) );
}

add_action( 'genesis_before_content_sidebar_wrap', 'genesis_dev_hero_section' );
