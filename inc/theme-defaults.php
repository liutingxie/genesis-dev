<?php
/**
 * This file adds default theme settings to the Genesis Dev Theme.
 */

add_filter( 'genesis_theme_settings_defaults', 'dev_theme_defaults' );
/**
* Updates theme settings on reset.
*/
function dev_theme_defaults( $defaults ) {

	$defaults['blog_cat_num']              = 12;
	$defaults['content_archive']           = 'excerpt';
	$defaults['content_archive_limit']     = 300;
	$defaults['content_archive_thumbnail'] = 1;
	$defaults['image_alignment']           = 'alignnone';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['image_size']                = 'portfolio';
	$defaults['posts_nav']                 = 'numeric';
	$defaults['site_layout']               = 'full-width-content';

	return $defaults;

}

add_action( 'after_switch_theme', 'dev_theme_setting_defaults' );
/**
* Updates theme settings on activation.
*/
function dev_theme_setting_defaults() {

	if ( function_exists( 'genesis_update_settings' ) ) {

		genesis_update_settings( array(
			'blog_cat_num'              => 12,
			'content_archive'           => 'excerpt',
			'content_archive_limit'     => 300,
			'content_archive_thumbnail' => 1,
			'image_alignment'           => 'alignnone',
			'image_size'                => 'portfolio',
			'posts_nav'                 => 'numeric',
			'site_layout'               => 'full-width-content',
		) );
	}

	update_option( 'posts_per_page', 12 );

}

/**
 * Update Simple Social Icon Defaults.
 */
function dev_social_default_styles( $defaults ) {

	$args = array(

		// 'padding'				 => 9,
		'new_window'             => 1,
		'size'                   => 36,
		'border_radius'          => 4,
		'border_color'           => '#ffffff',
		'border_color_hover'     => '#ffffff',
		'icon_color'             => '#ffffff',
		'icon_color_hover'       => '#ffffff',
		'background_color'       => '#000000',
		'background_color_hover' => '#000000',
		'alignment'              => 'alignleft',
		'facebook'               => '#',
		'instagram'              => '#',
		'pinterest'              => '#',
		'twitter'                => '#',
		'youtube'                => '#',
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}
add_filter( 'simple_social_default_styles', 'dev_social_default_styles' );