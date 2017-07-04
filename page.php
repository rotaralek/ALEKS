<?php get_header( '2' ); ?>
	<div class="top-page-header cf" style="background-image: url('<?php $archive_image = tell_get_option( 'opt-top-image-page', 'url' );
	echo tell_get_image_src( $archive_image, 1920, 400 ); ?>');">
		<h1 class="white-col"><?php wp_title( '', true ); ?></h1>
	</div>

	<div class="container padding-top-60">
		<div class="row cf">
			<div class="col-md-9">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="content-style margin-bottom-30">
						<?php the_content(); ?>
					</div>
				<?php endwhile; endif;
				wp_reset_query(); ?>
			</div>

			<div class="col-md-3 margin-bottom-30">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>