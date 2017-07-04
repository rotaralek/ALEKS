<?php get_header( '2' );
$page_object = get_queried_object(); ?>
	<div class="top-page-header cf" style="background-image: url('<?php $archive_image = tell_get_option( 'opt-top-image-tours', 'url' );
	echo tell_get_image_src( $archive_image, 1920, 400 ); ?>');">
		<div class="all-offers left white-col text-center">
			<div class="background blue-bg"></div>
			<p class="number-of-posts"><?php echo $GLOBALS[ 'wp_query' ]->found_posts; ?></p>
			<p><?php _e( 'offers', 'local' ); ?></p>
		</div>

		<h1 class="white-col"><?php wp_title( '', true ); ?></h1>
	</div>

	<div class="container has-categories-page padding-top-60">
		<div class="row cf">
			<div class="col-md-3 margin-bottom-30 categories-col">
				<nav>
					<?php $args = array(
						'type'         => 'tours',
						'child_of'     => 0,
						'parent'       => 0,
						'orderby'      => 'name',
						'order'        => 'ASC',
						'hide_empty'   => 1,
						'hierarchical' => 1,
						'exclude'      => '',
						'include'      => '',
						'number'       => '',
						'taxonomy'     => 'tours-country',
						'pad_counts'   => false );

					$categories = get_categories( $args ); ?>
					<ul>
						<?php foreach ( $categories as $category ) {
							echo '<li><a href="' . home_url() . '/tours-country/' . $category->slug . '" class="black-col red-col-hover">' . $category->name . '</a></li>';
						} ?>
					</ul>
				</nav>
			</div>

			<div class="col-md-9 items-col">
				<div class="row" data-post-type="tours" data-number-of-posts="<?php echo tell_get_option( 'opt-pagination-tours' ); ?>" data-offset="<?php echo tell_get_option( 'opt-pagination-tours' ); ?>">
					<div class="place-for-upload flex-box cf">
						<?php
						wp_reset_query();
						$number_of_posts = tell_get_option( 'opt-pagination-tours' );
						$query           = new WP_Query(
							array(
								'post_type'      => 'tours',
								'posts_per_page' => $number_of_posts
							)
						);
						if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
							get_template_part( 'partials/article/article', 'tours' );
						endwhile; endif;
						wp_reset_query(); ?>
					</div>

					<div class="load-more text-center margin-bottom-30">
						<button type="button" class="btn medium blue-bg white-col orange-bg-hover btn-shadow"><?php _e( 'Load more', 'local' ); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>