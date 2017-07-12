<?php get_header(); ?>

	<section class="container">
		<div class="heading">
			<h1><?php wp_title( '', true ); ?></h1>
		</div>

		<?php ob_start();

		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="content-style">
				<?php the_content();
				wp_link_pages(); ?>
			</div>
		<?php endwhile; endif;
		wp_reset_query();

		$content = ob_get_contents();
		ob_end_clean();

		//Show or hide sidebar function
		tell_sidebar_trigger( $content ); ?>
	</section>

<?php get_footer(); ?>
