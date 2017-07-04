<?php get_header( '2' );
$page_object           = get_queried_object();
$current_category_slug = $page_object->slug;
$current_category_name = $page_object->name; ?>
	<div class="top-page-header cf" style="background-image: url('<?php $archive_image = tell_get_option( 'opt-top-image-tours', 'url' );
	echo tell_get_image_src( $archive_image, 1920, 400 ); ?>');">
		<div class="all-offers left white-col text-center cf">
			<div class="background blue-bg"></div>

			<?php global $post;
			$current_category = wp_get_post_terms( $post->ID, 'tours-country', array( "fields" => "all" ) );
			if ( is_array( $current_category ) && !empty( $current_category ) ) {
				foreach ( $current_category as $category ) { ?>
					<div class="country-flag left">
						<?php $link = get_term_link( $category->slug, 'tours-country' ); ?>

						<a href="<?php echo $link; ?>" class="white-col yellow-col-hover">
							<?php echo tell_get_image( tell_taxonomy_image_url( $category->term_id ), 70, 48 ); ?>
						</a>
					</div>
				<?php }
			} ?>

			<div class="left">
				<p class="number-of-posts"><?php echo $GLOBALS[ 'wp_query' ]->found_posts; ?></p>
				<p><?php _e( 'offers', 'local' ); ?></p>
			</div>
		</div>

		<h1 class="white-col"><?php echo $current_category_name; ?></h1>
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
							if ( $current_category_slug == $category->slug ) {
								$active = 'active';
							} else {
								$active = '';
							}
							echo '<li><a href="' . home_url() . '/tours-country/' . $category->slug . '" class="black-col red-col-hover ' . $active . '">' . $category->name . '</a></li>';
						} ?>
					</ul>
				</nav>
			</div>

			<div class="col-md-9 items-col">
				<div class="container-fluid" data-post-type="tours" data-number-of-posts="<?php echo tell_get_option( 'opt-pagination-tours' ); ?>" data-offset="<?php echo tell_get_option( 'opt-pagination-tours' ); ?>" data-category="<?php echo $current_category_slug; ?>">
					<div class="place-for-upload flex-box cf">
						<?php
						wp_reset_query();
						$number_of_posts = tell_get_option( 'opt-pagination-tours' );
						$query           = new WP_Query(
							array(
								'post_type'      => 'tours',
								'posts_per_page' => $number_of_posts,
								'tax_query'      => array(
									array(
										'taxonomy' => 'tours-country',
										'field'    => 'slug',
										'terms'    => $current_category_slug
									)
								)
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