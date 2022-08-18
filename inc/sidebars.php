<?php
/**
 * This file adds custom widget areas to the Genesis Dev Theme.
 */



// Register webshop sidebar
genesis_register_sidebar( array(
    'id'            => 'woo_primary_sidebar',
    'name'          => __( 'Woocommerce Sidebar', 'genesis-dev' ),
    'description' => __( 'This is the WooCommerce shop sidebar', 'genesis-dev' ),
) );

//* Display the WooCommerce sidebar
function dev_woo_sidebar() {
    if ( ! dynamic_sidebar( 'woo_primary_sidebar' ) && current_user_can( 'edit_theme_options' )  ) {
        genesis_default_widget_area_content( __( 'WooCommerce Primary Sidebar', 'genesis-dev' ) );
    }

}


/**
 * Dinamic front-page widget area.
 */
$count_front_page_widgets = is_customize_preview() ? 24 : get_option( 'dev_front_page_widget', 6 );


// Register dynamic front page widget area.
for ( $i = 1; $i <= $count_front_page_widgets ; $i++ ) {
	genesis_register_sidebar(
		array(
			'id' => 'front-page-' . $i,
			'name' => __( 'Front Page ', 'genesis-dev' ) . $i,
			'description' => __( 'This is front page ', 'genesis-dev' ) . $i . __( ' widget area', 'genesis-dev' ),
		)
	);
}

for ( $i = 1; $i <= 4; $i++ ) {
	genesis_register_sidebar( array(
		'id'          => 'footer-widget-' . $i,
		'name'        => __( 'Footer Widget ', 'genesis-dev' ) . $i,
		'description' => __( 'This is the footer widget ', 'genesis-dev' ) . $i . __( ' widget area.', 'genesis-dev' ),
	) );
}

// Register Before Footer widget area.
genesis_register_sidebar( array(
	'id'          => 'before-footer',
	'name'        => __( 'Before Footer', 'genesis-dev' ),
	'description' => __( 'Before Footer widget area.', 'genesis-dev' ),
) );

add_action( 'genesis_footer', 'genesis_dev_before_footer', 5 );

/**
 * Display Before Footer widget area.
 */
function genesis_dev_before_footer() {

	genesis_widget_area( 'before-footer', array(
		'before' => '<div class="before-footer widget-area"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

function genesis_dev_footer_widgets() {
	// Return early if no footer widget areas.
	if ( '0' === $widget_areas ) {
		return;
	}
	// Opening markup with custom wrap.
	echo '<div class="footer-widgets"><div class="wrap">';

	// Loop through widget areas.
	for ( $i = 1; $i <= 4; $i++ ) {
		genesis_widget_area( "footer-widget-$i", array(
			'before' => sprintf( '<div class="widget-area footer-widgets-%s">', $i ),
			'after'  => '</div>',
		) );
	}

	// Closing markup.
	echo '</div></div>';
}

add_action( 'genesis_footer', 'genesis_dev_footer_widgets', 5 );