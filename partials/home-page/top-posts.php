<?php
wp_reset_query();
$query          = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3
	)
);
if ( $query->have_posts() ) : ?>
	<div class="container">
		<div class="row cf">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>

				<?php get_template_part( 'partials/article/post' ); ?>

			<?php endwhile; ?>
		</div>
	</div>
<?php endif;
wp_reset_query(); ?>
