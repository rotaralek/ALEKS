<?php
wp_reset_query();
$posts_per_page = get_option( 'posts_per_page' );
$query          = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => $posts_per_page
	)
);
if ( $query->have_posts() ) : ?>

	<?php while ( $query->have_posts() ) : $query->the_post(); ?>

		<?php get_template_part( 'partials/article/post' ); ?>

	<?php endwhile; ?>

<?php endif;
wp_reset_query(); ?>