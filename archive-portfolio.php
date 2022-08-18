<?php
/**
 * Archive Portfolio.
 *
 * This template overrides the default archive template to clean up output.
 */

/**
 * Add portfolio body class.
 */
function dev_portfolio_body_class( $classes ) {
	$classes[] = 'portfolio';
	$classes[] = 'masonry';

	return $classes;
}

add_action( 'body_class', 'dev_portfolio_body_class', 999 );

// Force full width content layout.
add_action( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Enqueus scripts
wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/assets/js/isotope.pkgd.min.js', array( 'jquery' ),  CHILD_THEME_VERSION, false );
wp_enqueue_script( 'isotope-init', get_stylesheet_directory_uri() . '/assets/js/isotope.init.js', array( 'isotope' ), CHILD_THEME_VERSION, false );

// Remove standed loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

// Add custom portfolio loop.
add_action( 'genesis_loop', 'dev_portfolio_loop' );

/**
 * Output filterable portfolio items.
 */
function dev_portfolio_loop() {

	global $posts;
	$terms = get_terms( 'portfolio-type' );

	?>

	<div class="portfolio-contain">
		<?php if ( $terms ) : ?>
		<div class="filter-button-group">

			<div class="button active" data-filter="*"><?php esc_html_e( 'All', 'genesis-dev' ); ?></div>

			<?php foreach ( $terms as $term ) : ?>
			<div class="button" data-filter=".<?php echo esc_attr( $term->slug ) ?>"><?php echo esc_html( $term->name ); ?></div>
			<?php endforeach; ?>

		</div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
		<div class="portfolio-content">

			<?php while ( have_posts() ) : the_post();

				$types = get_the_terms( get_the_ID(), 'portfolio-type' );

				// Display portfolio items.
				if ( has_post_thumbnail( $post->ID ) ) :
			?>
				<article class="portfolio-item <?php echo esc_attr( $types[0]->slug ); ?> ">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php
							echo genesis_get_image( array (
								'size' 		=> 'portfolio',
								'itemprop'  => 'image',
							) );

							printf( '<p class="entry-title" itemprop="name"><span>%s</span></p>', get_the_title() );
						?>
					</a>
				</article>
			<?php
				endif;
				endwhile;
			?>
		</div>
		<?php endif; ?>
	</div>


<?php
}
// Run genesis
genesis();