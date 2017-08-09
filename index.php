<?php get_header(); ?>

	<section class="container">
		<div class="heading">
			<h1>
				<?php
				if ( '' != wp_title( '', false ) ) {
					wp_title( '', true );
				} else {
					_e( 'Blog', 'local' );
				} ?>
			</h1>
		</div>

		<?php ob_start();

		wp_reset_query();
		$posts_per_page = get_option( 'posts_per_page' );
		$query          = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => $posts_per_page
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