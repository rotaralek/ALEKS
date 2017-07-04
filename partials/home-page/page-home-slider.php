<?php wp_reset_query();
$number       = tell_get_meta( 'opt-pagination-facts' );
$query_slider = new WP_Query(
	array(
		'post_type'      => array( 'tours', 'excursions', 'cruises', 'hotels', 'rooms', 'car-rentals', 'post', 'news' ),
		'posts_per_page' => $number,
		'meta_query'     => array(
			array(
				'key'   => 'tell_slider_home_show',
				'value' => 'show'
			)
		)
	)
);
if ( $query_slider->have_posts() ) : ?>
	<div class="template-home-slider">
		<div class="tell-slider">
			<?php while ( $query_slider->have_posts() ) : $query_slider->the_post(); ?>
				<div class="item" style="background-image: url(<?php echo tell_get_post_image_src( 1920, 1080 ); ?>);">
					<?php /*if ( tell_get_meta( 'post_video' ) ) { */?><!--
						<div class="video">
							<?php /*$link = tell_get_meta( 'post_video' );
							$link       = str_replace( 'https://www.youtube.com/watch?v=', '', $link );
							$link       = str_replace( 'https://youtu.be/', '', $link );
							$is_embed   = preg_match( '/embed/', $link );
							if ( !$is_embed ) {
								$link = 'https://www.youtube.com/embed/' . $link;
							} */?>
							<video src="<?php /*echo $link; */?>" width="100%" height="100%" loop muted poster="<?php /*echo tell_get_post_image_src( 1920, 1080 ); */?>" class="grey-bg"></video>
						</div>
					--><?php /*} */?>

					<div class="text text-center">
						<h2 class="margin-bottom-30">
							<a href="<?php the_permalink(); ?>" class="white-col blue-col-hover"><?php the_title(); ?></a>
						</h2>

						<a href="<?php the_permalink(); ?>" class="btn big orange-bg white-col blue-bg-hover btn-shadow"><?php _e( 'Details', 'local' ); ?></a>
					</div>

					<?php global $post;
					$current_category = wp_get_post_terms( $post->ID, 'tours-country', array( "fields" => "all" ) );
					if ( is_array( $current_category ) && !empty( $current_category ) ) {
						foreach ( $current_category as $category ) { ?>
							<div class="all-offers left white-col text-center cf">
								<div class="background blue-bg"></div>

								<?php global $post;
								$current_category = wp_get_post_terms( $post->ID, 'tours-country', array( "fields" => "all" ) );
								if ( is_array( $current_category ) && !empty( $current_category ) ) {
									foreach ( $current_category as $category ) { ?>
										<div class="country-flag left">
											<?php $link = get_term_link( $category->slug, 'tours-country' ); ?>

											<a href="<?php echo $link; ?>" class="white-col yellow-col-hover">
												<?php echo '<img src="' . tell_get_image_src( tell_taxonomy_image_url( $category->term_id ), 70, 48 ) . '" width="70" height="48" alt="">'; ?>
											</a>
										</div>
									<?php }
								} ?>

								<div class="left">
									<p class="number-of-posts">
										<?php $category_args = get_category( $category->term_id );
										echo $count = $category_args->category_count; ?>
									</p>
									<?php if ( 1 == $count ) { ?>
										<p><?php _e( 'offer', 'local' ); ?></p>
									<?php } else { ?>
										<p><?php _e( 'offers', 'local' ); ?></p>
									<?php } ?>
								</div>
							</div>
						<?php }
					} ?>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif;
wp_reset_query();