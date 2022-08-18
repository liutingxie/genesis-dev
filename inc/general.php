<?php
/**
 * This file adds general theme functions to the Genesis Dev Theme.
 */


add_action( 'genesis_entry_header', 'dev_reposition_post_meta', 0 );
/**
 * Reposition post info and remove excerpts on archives.
 */
function dev_reposition_post_meta() {

	if ( is_archive() || is_home() || is_search() || is_post_type_archive() ) {

		// Reposition post meta.
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		add_action( 'genesis_entry_header', 'genesis_post_info', 1 );

		// Remove read more link on archives.
		// add_filter( 'get_the_content_more_link', '__return_empty_string' );

	}

}


add_filter( 'genesis_post_info', 'dev_post_info' );

/**
 * Output the custom post info.
 */
function dev_post_info( $post_info ) {

	if ( is_archive() || is_home() || is_search() || is_post_type_archive() ) {

		$post_info = '[post_date]';

	}

	return $post_info;
}

add_filter( 'genesis_post_meta', 'dev_post_meta' );

/**
 * Output the post meta on the entry footer.
 */
function dev_post_meta( $post_meta ) {

	if ( is_archive() || is_home() || is_search() || is_post_type_archive() || is_single() ) {

		$cat_img = '<img width=\'16\' height=\'16\' alt=\'' . $cat_alt . '\' src=\'' . CHILD_THEME_URL . '/assets/images/folder-open.svg\'>';

		$tag_img = '<img width=\'16\' height=\'16\' alt=\'' . $tag_alt . '\' src=\'' . CHILD_THEME_URL . '/assets/images/price-tags.svg\'>';

		$post_meta = '[post_categories before="' . $cat_img . '" sep=",&nbsp;"] [post_tags before="' . $tag_img . '" sep=",&nbsp;"]';
	}

	return $post_meta;

}


add_filter( 'http_request_args', 'dont_update_theme', 10, 2 );
/**
 * Prevent automatic theme updates.
 */
function dont_update_theme( $request, $url ) {

	// Not a theme update request. Bail immediately.
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) ) {
		return $request;
	}

	$themes = unserialize( $request['body']['themes'] );

	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );

	$request['body']['themes'] = serialize( $themes );

	return $request;

}

add_filter( 'comment_form_default_fields', 'remove_comment_form_fields' );
function remove_comment_form_fields( $fields ) {

    unset($fields['cookies']);

	return $fields;

}
