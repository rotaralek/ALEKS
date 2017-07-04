<?php get_header( '2' ); ?>

	<div class="container padding-top-60">
		<div class="row cf">
			<div class="col-md-9 margin-bottom-30">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					the_content();
				endwhile; endif; ?>
			</div>

			<div class="col-md-3 margin-bottom-30">
				<div class="sidebar cf">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>