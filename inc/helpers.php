<?php
/**
 * This file contain theme-specfic function for the Genesis Dev theme.
 */

/**
 *  Custom header image callback
 */
function dev_custom_header() {

	// Get the featured image if one is set.
	if ( get_the_post_thumbnail_url() ) {

		$image = '';

		if ( class_exists('WooCommerce') && is_shop() ) {

			$image = get_the_post_thumbnail_url( get_option('woocommerce_shop_page_id') );

			if ( ! $image ) {

				$image = get_header_image();

			}

		} elseif ( is_home() ) {

			$image = get_the_post_thumbnail_url( get_option( 'page_for_posts' ) );

			if ( ! $image ) {

				$image = get_header_image();

			}

		} elseif ( is_archive() || is_category() || is_tag() || is_tax() || is_home() ) {

			$image = get_header_image();

		} else {

			$image = get_the_post_thumbnail_url();

		}

	} elseif ( has_header_image() ) {

		$image = get_header_image();

	}


	if ( ! empty( $image ) ) {
		printf( '<style>.hero-section { background-image:url(%s); }</style>', esc_url( $image ) );
	}
}

/**
 * Overry genesis_do_header function.
 */
function dev_genesis_do_header() {
	global $wp_registered_sidebars;

	genesis_markup(
		array(
			'open'    => '<div %s>',
			'context' => 'title-area',
		)
	);

		/**
		 * Fires inside the title area, before the site description hook.
		 */
		do_action( 'genesis_site_title' );

		/**
		 * Fires inside the title area, after the site title hook.
		 */
		do_action( 'genesis_site_description' );

	genesis_markup(
		array(
			'close'   => '</div>',
			'context' => 'title-area',
		)
	);

}

/**
 * Override genesis_do_nav
 */
function dev_genesis_do_nav() {

	// Do nothing if menu not supported.
	if ( ! genesis_nav_menu_supported( 'primary' ) || ! has_nav_menu( 'primary' ) ) {
		return;
	}

	$class = 'menu genesis-nav-menu menu-primary';
	if ( genesis_superfish_enabled() ) {
		$class .= ' js-superfish';
	}

	genesis_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_class'     => $class,
		)
	);

	global $wp_registered_sidebars;
	if ( has_action( 'genesis_header_right' ) || ( isset( $wp_registered_sidebars['header-right'] ) && is_active_sidebar( 'header-right' ) ) ) {

		genesis_markup(
			array(
				'open'    => '<div %s>',
				'context' => 'header-widget-area',
			)
		);

			/**
			 * Fires inside the header widget area wrapping markup, before the Header Right widget area.
			 */
			do_action( 'genesis_header_right' );
			add_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			add_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );
			dynamic_sidebar( 'header-right' );
			remove_filter( 'wp_nav_menu_args', 'genesis_header_menu_args' );
			remove_filter( 'wp_nav_menu', 'genesis_header_menu_wrap' );

		genesis_markup(
			array(
				'close'   => '</div>',
				'context' => 'header-widget-area',
			)
		);

	}

}

/**
 * Custom opening wrap.
 *
 */
function dev_wrap_open() {
	echo '<div class="wrap">';
}

/**
 * Custom closing wrap.
 *
 */
function dev_wrap_close() {
	echo '</div>';
}

/**
 * Custom footer opening wrap.
 *
 */
function dev_footer_wrap_open() {
	echo '<div class="footer-wrap">';
}

/**
 * Custom footer closing wrap.
 *
 */
function dev_footer_wrap_close() {
	echo '</div>';
}

/**
 * Helper function to check if we're on a WoocCommerce page.
 */
function dev_is_woocommerce_page() {

	if ( ! class_exists( 'WooCommerce' ) ) {

		return false;

	}

	if ( is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() ) {

		return true;

	} else {

		return false;

	}

}