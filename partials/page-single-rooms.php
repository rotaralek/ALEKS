<?php wp_reset_query();
global $post;
$query = new WP_Query(
	array(
		'post_type'      => 'rooms',
		'posts_per_page' => -1,
		'meta_query'     => array(
			array(
				'key'     => 'tell_rooms_hotel',
				'value'   => $post->ID,
				'compare' => 'LIKE'
			)
		)
	)
);
if ( $query->have_posts() ) : ?>
	<div class="hotel-rooms margin-bottom-60">
		<div class="heading text-center margin-bottom-30">
			<h2><?php _e( 'Rooms', 'local' ); ?></h2>
		</div>

		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<article <?php post_class( 'cf margin-bottom-30 grey-light-bg card-shadow transition' ); ?>>
				<div class="image left">
					<a href="<?php the_permalink(); ?>">
						<?php echo tell_get_post_image( 140, 140 ); ?>
					</a>
				</div>

				<div class="text left">
					<h3>
						<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
					</h3>

					<div class="details left">
						<?php if ( tell_get_meta( 'post_price' ) ) { ?>
							<p class="price-from">
								<i class="material-icons">credit_card</i><?php _e( 'Price from', 'local' ); ?>
								: <?php echo tell_get_meta( 'post_price' ) . ' ' . tell_get_option( 'opt-currency' ); ?>
							</p>
						<?php } ?>

						<?php if ( tell_get_meta( 'rooms_size' ) ) { ?>
							<p class="size"><i class="material-icons">zoom_out_map</i><?php _e( 'Size', 'local' ); ?>
								: <?php echo tell_get_meta( 'rooms_size' );
								_e( ' m<sup>2</sup>' ); ?></p>
						<?php } ?>
					</div>
				</div>

				<a href="<?php the_permalink(); ?>" class="btn small orange-bg white-col blue-light-bg-hover btn-shadow right"><?php _e( 'Details', 'local' ); ?></a>
			</article>
		<?php endwhile; ?>
	</div>
<?php endif;
wp_reset_query(); ?>