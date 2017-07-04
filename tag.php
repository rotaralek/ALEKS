<?php get_header( '2' );
$page_object = get_queried_object(); ?>
	<div class="top-page-header cf" style="background-image: url('<?php $archive_image = tell_get_option( 'opt-top-image-page', 'url' );
	echo tell_get_image_src( $archive_image, 1920, 400 ); ?>');">
		<div class="all-offers left white-col text-center">
			<div class="background blue-bg"></div>

			<p class="number-of-posts"><?php echo $page_object->count; ?></p>
			<p><?php _e( 'posts', 'local' ); ?></p>
		</div>

		<h1 class="white-col"><?php wp_title( '', true ); ?></h1>
	</div>

	<div class="container padding-top-60">
		<div class="row cf">
			<div class="col-md-9 margin-bottom-30">
				<div data-post-type="post,tours,excursions,cruises,hotels,rooms,car-rentals" data-number-of-posts="<?php echo tell_get_option( 'opt-pagination-tags' ); ?>" data-offset="<?php echo tell_get_option( 'opt-pagination-tags' ); ?>" data-tags="<?php echo $page_object->slug; ?>">
					<div class="place-for-upload flex-box cf">
						<?php wp_reset_query();
						$number_of_posts = get_option( 'posts_per_page' );
						$query           = new WP_Query(
							array(
								'post_type'      => array( 'post', 'tours', 'excursions', 'cruises', 'hotels', 'rooms', 'car-rentals', 'news' ),
								'posts_per_page' => $number_of_posts,
								'tax_query'      => array(
									array(
										'taxonomy' => 'post_tag',
										'field'    => 'slug',
										'terms'    => $page_object->slug
									)
								)
							)
						);
						if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
							get_template_part( 'partials/article/article', 'post' );
						endwhile; endif;
						wp_reset_query(); ?>
					</div>

					<div class="load-more text-center margin-bottom-30">
						<button type="button" class="btn medium blue-bg white-col orange-bg-hover btn-shadow"><?php _e( 'Load more', 'local' ); ?></button>
					</div>
				</div>
			</div>

			<div class="col-md-3 margin-bottom-30">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>