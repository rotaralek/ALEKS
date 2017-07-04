<div class="template-article-slider cf">
	<div class="tell-slider">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div <?php post_class( 'item' ); ?>>
				<?php echo tell_get_post_image( 1920, 720 ); ?>

				<div class="background black-bg"></div>

				<div class="text text-center">
					<h2 class="margin-bottom-30 white-col"><?php the_title(); ?></h2>

					<?php if ( tell_get_meta( 'post_stars' ) ) { ?>
						<div class="rating margin-bottom-30">
							<?php $number_of_stars = tell_get_meta( 'post_stars' );
							for ( $i = 0; $i < $number_of_stars; $i++ ) { ?>
								<i class="material-icons yellow-col">star_rate</i>
							<?php } ?>
						</div>
					<?php } ?>

					<?php if ( tell_get_meta( 'tours_length' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Length', 'local' ) . ': ' . tell_get_meta( 'tours_length' ) . '</p>';
					} ?>

					<?php if ( tell_get_meta( 'excursions_length' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Length', 'local' ) . ': ' . tell_get_meta( 'excursions_length' ) . '</p>';
					} ?>

					<?php if ( tell_get_meta( 'post_date_begin' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Date', 'local' ) . ': ' . tell_get_meta( 'post_date_begin' );
						if ( tell_get_meta( 'post_date_end' ) ) {
							echo ' - ' . tell_get_meta( 'post_date_end' );
						}
						echo '</p>';
					} ?>

					<?php if ( tell_get_meta( 'post_price' ) ) {
						echo '<p class="margin-bottom-15 price">' . __( 'Price', 'local' ) . ': ' . tell_get_meta( 'post_price' );
						if ( tell_get_meta( 'post_price_end' ) ) {
							echo ' - ' . tell_get_meta( 'post_price_end' );
						}
						echo tell_get_option( 'opt-currency' );
						echo '</p>';
					} ?>

					<?php if ( tell_get_meta( 'cruises_departs' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Departs', 'local' ) . ': ' . tell_get_meta( 'cruises_departs' ) . '</p>';
					} ?>

					<?php if ( tell_get_meta( 'cruises_ship' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Ship', 'local' ) . ': ' . tell_get_meta( 'cruises_ship' ) . '</p>';
					} ?>

					<?php if ( tell_get_meta( 'cruises_destination' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Destination', 'local' ) . ': ' . tell_get_meta( 'cruises_destination' ) . '</p>';
					} ?>

					<?php if ( tell_get_meta( 'cruises_duration' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Duration', 'local' ) . ': ' . tell_get_meta( 'cruises_duration' ) . '</p>';
					} ?>

					<?php if ( tell_get_meta( 'cruises_ports_of_call' ) ) {
						echo '<p class="margin-bottom-15 white-col">' . __( 'Ports of Call', 'local' ) . ': ' . tell_get_meta( 'cruises_ports_of_call' ) . '</p>';
					} ?>
				</div>

				<?php global $post;
				if ( 'tours' == $post->post_type ) {
					$taxonomy = 'tours-country';
				} else if ( 'excursions' == $post->post_type ) {
					$taxonomy = 'excursions-country';
				} else if ( 'cruises' == $post->post_type ) {
					$taxonomy = 'cruises-country';
				} else if ( 'hotels' == $post->post_type ) {
					$taxonomy = 'hotels-country';
				} else if ( 'car-rentals' == $post->post_type ) {
					$taxonomy = 'car-rentals-country';
				}
				if ( isset( $taxonomy ) ) {
					$current_category = wp_get_post_terms( $post->ID, $taxonomy, array( "fields" => "all" ) );
					if ( is_array( $current_category ) && !empty( $current_category ) ) {
						foreach ( $current_category as $category ) { ?>
							<div class="country-flag">
								<div class="background blue-bg"></div>

								<?php $link = get_term_link( $category->slug, $taxonomy ); ?>

								<a href="<?php echo $link; ?>" class="white-col yellow-col-hover">
									<?php echo tell_get_image( tell_taxonomy_image_url( $category->term_id ), 100, 75 ); ?>
								</a>
							</div>
						<?php }
					}
				} ?>
			</div>

			<?php if ( tell_get_meta( 'post_gallery' ) ) {
				$post_gallery = tell_get_meta( 'post_gallery', 'type=image' ); ?><?php foreach ( $post_gallery as $post_image ) { ?>
					<div <?php post_class( 'item' ); ?>>
						<?php echo tell_get_image( $post_image[ 'full_url' ], 1920, 720 ); ?>
						<div class="background black-bg"></div>

						<div class="text text-center">
							<h2 class="margin-bottom-30 white-col"><?php the_title(); ?></h2>

							<?php if ( tell_get_meta( 'post_stars' ) ) { ?>
								<div class="rating margin-bottom-30">
									<?php $number_of_stars = tell_get_meta( 'post_stars' );
									for ( $i = 0; $i < $number_of_stars; $i++ ) { ?>
										<i class="material-icons yellow-col">star_rate</i>
									<?php } ?>
								</div>
							<?php } ?>

							<?php if ( tell_get_meta( 'tours_length' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Length', 'local' ) . ': ' . tell_get_meta( 'tours_length' ) . '</p>';
							} ?>

							<?php if ( tell_get_meta( 'excursions_length' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Length', 'local' ) . ': ' . tell_get_meta( 'excursions_length' ) . '</p>';
							} ?>

							<?php if ( tell_get_meta( 'post_date_begin' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Date', 'local' ) . ': ' . tell_get_meta( 'post_date_begin' );
								if ( tell_get_meta( 'post_date_end' ) ) {
									echo ' - ' . tell_get_meta( 'post_date_end' );
								}
								echo '</p>';
							} ?>

							<?php if ( tell_get_meta( 'post_price' ) ) {
								echo '<p class="margin-bottom-15 price">' . __( 'Price', 'local' ) . ': ' . tell_get_meta( 'post_price' );
								if ( tell_get_meta( 'post_price_end' ) ) {
									echo ' - ' . tell_get_meta( 'post_price_end' );
								}
								echo tell_get_option( 'opt-currency' );
								echo '</p>';
							} ?>

							<?php if ( tell_get_meta( 'cruises_departs' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Departs', 'local' ) . ': ' . tell_get_meta( 'cruises_departs' ) . '</p>';
							} ?>

							<?php if ( tell_get_meta( 'cruises_ship' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Ship', 'local' ) . ': ' . tell_get_meta( 'cruises_ship' ) . '</p>';
							} ?>

							<?php if ( tell_get_meta( 'cruises_destination' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Destination', 'local' ) . ': ' . tell_get_meta( 'cruises_destination' ) . '</p>';
							} ?>

							<?php if ( tell_get_meta( 'cruises_duration' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Duration', 'local' ) . ': ' . tell_get_meta( 'cruises_duration' ) . '</p>';
							} ?>

							<?php if ( tell_get_meta( 'cruises_ports_of_call' ) ) {
								echo '<p class="margin-bottom-15 white-col">' . __( 'Ports of Call', 'local' ) . ': ' . tell_get_meta( 'cruises_ports_of_call' ) . '</p>';
							} ?>
						</div>

						<?php global $post;
						if ( 'tours' == $post->post_type ) {
							$taxonomy = 'tours-country';
						} else if ( 'excursions' == $post->post_type ) {
							$taxonomy = 'excursions-country';
						} else if ( 'cruises' == $post->post_type ) {
							$taxonomy = 'cruises-country';
						} else if ( 'hotels' == $post->post_type ) {
							$taxonomy = 'hotels-country';
						} else if ( 'car-rentals' == $post->post_type ) {
							$taxonomy = 'car-rentals-country';
						}
						if ( isset( $taxonomy ) ) {
							$current_category = wp_get_post_terms( $post->ID, $taxonomy, array( "fields" => "all" ) );
							if ( is_array( $current_category ) && !empty( $current_category ) ) {
								foreach ( $current_category as $category ) { ?>
									<div class="country-flag">
										<div class="background blue-bg"></div>

										<?php $link = get_term_link( $category->slug, $taxonomy ); ?>

										<a href="<?php echo $link; ?>" class="white-col yellow-col-hover">
											<?php echo tell_get_image( tell_taxonomy_image_url( $category->term_id ), 100, 75 ); ?>
										</a>
									</div>
								<?php }
							}
						} ?>
					</div>
				<?php } ?><?php }
		endwhile; endif;
		wp_reset_query(); ?>
	</div>
</div>