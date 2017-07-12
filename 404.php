<?php get_header(); ?>

	<section class="container">
		<div class="heading">
			<h1><?php _e( 'Error 404', 'local' ); ?></h1>
		</div>

		<?php ob_start(); ?>

		<div class="content-style">
			<h4><?php _e( 'Pages that you were looking for does not exist', 'local' ); ?>.</h4>

			<br>

			<h6>
				<a href="<?php echo esc_url( home_url() ); ?>/"><i class="material-icons">keyboard_return</i> <?php _e( 'Go back to main page', 'local' ); ?>
				</a>
			</h6>
		</div>

		<?php $content = ob_get_contents();
		ob_end_clean();

		//Show or hide sidebar function
		tell_sidebar_trigger( $content ); ?>
	</section>

<?php get_footer(); ?>