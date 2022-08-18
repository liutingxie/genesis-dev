<?php

add_filter( 'woocommerce_output_related_products_args', 'dev_related_products_args', 20 );

function dev_related_products_args( $args ) {

	$args['posts_per_page'] = 6; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns

	return $args;

}

// Remove Single Product title.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

// Remove result count on shop loop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

add_filter( 'woocommerce_show_page_title', '__return_null' );

//* Remove default sidebar, add shop sidebar
add_action( 'genesis_before', 'dev_add_woo_sidebar', 20 );

function dev_add_woo_sidebar() {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        if ( is_woocommerce() ) {

            remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
            remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

            add_action( 'genesis_sidebar', 'dev_woo_sidebar' );
        }
    }
}