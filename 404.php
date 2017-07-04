<?php get_header( '2' ); ?>

<div class="top-page-header cf" style="background-image: url('<?php $archive_image = tell_get_option( 'opt-top-image-page', 'url' );
echo tell_get_image_src( $archive_image, 1920, 400 ); ?>');">
	<h1 class="white-col"><?php _e( 'Error 404', 'local' ); ?></h1>
</div>

<div class="container padding-top-60">
	<div class="row cf">
		<div class="col-md-9">
			<div class="content-style margin-bottom-30">
				<h4><?php _e( 'Pages that you were looking for does not exist', 'local' ); ?>.</h4><br>
				<h6>
					<a href="<?php echo esc_url( home_url() ); ?>/"><i class="ti-arrow-left"></i> <?php _e( 'Go back to main page', 'local' ); ?>
					</a></h6>
			</div>
		</div>

		<div class="col-md-3 margin-bottom-30">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>

