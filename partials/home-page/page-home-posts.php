<?php if ( tell_get_meta( 'page_home_post_type' ) ) {
	$post_types = tell_get_meta( 'page_home_post_type' );
	if ( !empty( $post_types ) ) {
		$post_types_category = $post_types . '-country';
	} else {
		$post_types = 'post';
	}
} else {
	$post_types = 'post';
} ?>
<div class="container has-categories-page padding-top-60 cf no-redirect">
	<div class="row cf">
		<div class="col-md-3 margin-bottom-30 categories-col category-no-redirect">
			<nav>
				<?php $args = array(
					'type'         => $post_types,
					'child_of'     => 0,
					'parent'       => 0,
					'orderby'      => 'name',
					'order'        => 'ASC',
					'hide_empty'   => 1,
					'hierarchical' => 1,
					'exclude'      => '',
					'include'      => '',
					'number'       => '',
					'taxonomy'     => $post_types_category,
					'pad_counts'   => false );

				$categories = get_categories( $args ); ?>
				<ul>
					<?php foreach ( $categories as $cat ) {
						echo '<li><a href="' . home_url() . '/' . $post_types_category . '/' . $cat->slug . '" class="black-col red-col-hover" data-post-type="' . $post_types . '" data-category="' . $cat->slug . '">' . $cat->name . '</a></li>';
					} ?>

					<li>
						<a href="<?php echo home_url() . '/' . $post_types_category . '/'; ?>" class="black-col red-col-hover" data-post-type="<?php echo $post_types; ?>" data-category=""><?php _e( 'All', 'local' ); ?></a>
					</li>
				</ul>
			</nav>
		</div>

		<div class="col-md-9 items-col">
			<div class="row ajax-data" data-post-type="<?php echo $post_types; ?>" data-number-of-posts="<?php echo tell_get_meta( 'page_home_post_type_number' ); ?>" data-offset="<?php echo tell_get_meta( 'page_home_post_type_number' ); ?>">
				<div class="place-for-upload flex-box cf">
					<?php wp_reset_query();
					$number_of_posts = tell_get_meta( 'page_home_post_type_number' );
					$query           = new WP_Query(
						array(
							'post_type'      => $post_types,
							'posts_per_page' => $number_of_posts
						)
					);
					if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
						global $post;
						if ( 'tours' == $post->post_type ) {
							get_template_part( 'partials/article/article', 'tours' );
						} elseif ( 'excursions' == $post->post_type ) {
							get_template_part( 'partials/article/article', 'excursions' );
						} elseif ( 'cruises' == $post->post_type ) {
							echo '<div class="container-fluid">';
							get_template_part( 'partials/article/article', 'cruises' );
							echo '</div>';
						} elseif ( 'hotels' == $post->post_type ) {
							get_template_part( 'partials/article/article', 'hotels' );
						} elseif ( 'rooms' == $post->post_type ) {
							get_template_part( 'partials/article/article', 'rooms' );
						} elseif ( 'car-rentals' == $post->post_type ) {
							get_template_part( 'partials/article/article', 'car-rentals' );
						} elseif ( 'reviews' == $post->post_type ) {
							get_template_part( 'partials/article/article', 'reviews' );
						} else {
							get_template_part( 'partials/article/article', 'post' );
						}
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