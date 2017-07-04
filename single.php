<?php get_header( '2' ); ?>

<?php get_template_part( 'partials/post-slider' ); ?>

	<div class="container padding-top-60">
		<div class="row cf">
			<div class="col-md-9 margin-bottom-30">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="content-style margin-bottom-30">
						<?php the_content(); ?><?php wp_link_pages(); ?>
					</div>
				<?php endwhile; endif;
				wp_reset_query(); ?>

				<div class="social-block text-center share margin-bottom-30">
					<?php get_template_part( 'partials/social' ); ?>
				</div>

				<?php get_template_part( 'partials/comments-reviews' ); ?>
			</div>

			<div class="col-md-3 margin-bottom-30">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>