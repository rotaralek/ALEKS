<?php get_header();
$page_object = get_queried_object(); ?>

	<section class="container">
		<div class="heading">
			<h1><?php wp_title( '', true ); ?></h1>
		</div>

		<?php ob_start();

		wp_reset_query();
		$posts_per_page = get_option( 'posts_per_page' );
		$query          = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => $posts_per_page,
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
			get_template_part( '/partials/article/post' );
		endwhile; endif;
		wp_reset_query();

		$content = ob_get_contents();
		ob_end_clean();

		//Show or hide sidebar function
		tell_sidebar_trigger( $content ); ?>
	</section>

<?php get_footer(); ?>
