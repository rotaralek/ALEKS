<?php get_header( '2' ); ?>

<?php get_template_part( 'partials/post-slider' ); ?>

	<div class="post-details small-text blue-light-bg white-col">
		<div class="container cf content-style">
			<?php echo tell_get_meta( 'tours_short_text' ); ?>
		</div>
	</div>

	<div class="container padding-top-60">
		<div class="row cf">
			<div class="col-md-9 margin-bottom-30">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
					$GLOBALS[ 'global_post_id' ] = $post->ID; ?>

					<div class="content-style margin-bottom-30">
						<?php the_content(); ?>
					</div>
				<?php endwhile; endif;
				wp_reset_query(); ?>

				<?php if ( 'show' == tell_get_option( 'opt-information-show' ) ): ?>
					<div class="important-information red-bg white-col text-center margin-bottom-30">
						<p>
							<?php if ( tell_get_option( 'opt-information-text-begin' ) ) {
								echo tell_get_option( 'opt-information-text-begin' );
							} ?>

							<?php if ( tell_get_option( 'opt-information-number-begin' ) ) { ?>
								<b>
									<?php echo tell_get_option( 'opt-information-number-begin' ); ?>
								</b>
							<?php } ?>

							<?php if ( tell_get_option( 'opt-information-number-end' ) ) { ?>
								<strong>
									<?php echo tell_get_option( 'opt-information-number-end' ); ?>
								</strong>
							<?php } ?>
						</p>

						<p>
							<?php if ( tell_get_option( 'opt-information-text-end' ) ) {
								echo tell_get_option( 'opt-information-text-end' );
							} ?>
						</p>
					</div>
				<?php endif; ?>

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