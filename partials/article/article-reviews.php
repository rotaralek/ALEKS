<div class="col-sm-6">
	<article <?php post_class( 'margin-bottom-30 archive-reviews-item' ); ?>>
		<h2 class="cf">
			<?php $reviews_posts = tell_get_meta( 'reviews_posts' );
			if ( is_array( $reviews_posts ) ) {
				foreach ( $reviews_posts as $reviews_post ) {
					$reviews_post_id = $reviews_post;
				};
			} else {
				$reviews_post_id = tell_get_meta( 'reviews_posts' );
			} ?>
			<a href="<?php the_permalink( $reviews_post_id ); ?>" class="black-col blue-col-hover">
				<?php echo get_the_title( $reviews_post_id ); ?>
			</a>

			<?php if ( tell_get_meta( 'reviews_stars' ) ) { ?>
				<span class="rating">
					<?php $number_of_stars = tell_get_meta( 'post_stars' );
					for ( $i = 0; $i < $number_of_stars; $i++ ) { ?>
						<i class="material-icons yellow-col">star_rate</i>
					<?php } ?>
				</span>
			<?php } ?>
		</h2>

		<h3>
			<small><?php _e( 'The author of this review', 'local' ); ?></small>
			: <?php the_title(); ?>
		</h3>

		<div class="string">
			<?php the_content(); ?>
		</div>
	</article>
</div>