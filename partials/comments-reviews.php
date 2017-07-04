<div class="comment-reviews-block multi-tabs">
	<nav class="cf">
		<a href="#comments" class="left blue-bg white-col active"><?php _e( 'Comments', 'local' ); ?></a>
		<a href="#reviews" class="left red-bg white-col"><?php _e( 'Reviews', 'local' ); ?></a>
	</nav>

	<div class="tab-container margin-bottom-30">
		<div class="tab-item active blue-bg white-col" id="comments">
			<?php comments_template(); ?>
		</div>

		<div class="tab-item blue-bg white-col" id="reviews">
			<?php
			wp_reset_query();
			$post_reviews_id = $post->ID;
			$query_reviews   = new WP_Query(
				array(
					'post_type'      => 'reviews',
					'posts_per_page' => -1,
					'meta_query'     => array(
						array(
							'key'     => 'tell_reviews_posts',
							'value'   => $post_reviews_id,
							'compare' => 'LIE'
						)
					)
				)
			);
			if ( $query_reviews->have_posts() ) : ?>
				<div class="reviews-list margin-bottom-30">
					<?php while ( $query_reviews->have_posts() ) : $query_reviews->the_post(); ?>
						<div class="item margin-bottom-30 padding-bottom-30">
							<h4 class="cf">
								<?php the_title(); ?>

								<?php if ( tell_get_meta( 'reviews_stars' ) ) { ?>
									<span class="right rating">
										<?php $number_of_stars = tell_get_meta( 'post_stars' );
										for ( $i = 0; $i < $number_of_stars; $i++ ) { ?>
											<i class="material-icons yellow-col">star_rate</i>
										<?php } ?>
									</span>
								<?php } ?>
							</h4>

							<div class="string">
								<?php the_content(); ?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
			<?php endif;
			wp_reset_query(); ?>

			<div class="reviews-form">
				<h3><?php _e( 'Create the review', 'local' ); ?></h3>
				<form action="<?php the_permalink(); ?>">
					<div class="text clear cf margin-bottom-15">
						<label>
							<textarea name="text" placeholder="<?php _e( 'Your review', 'local' ); ?>"></textarea>
						</label>
					</div>

					<div class="row cf">
						<div class="name-surname cf col-md-6 margin-bottom-15">
							<label>
								<input type="text" name="name" placeholder="<?php _e( 'Name', 'local' ); ?>">
							</label>
						</div>

						<div class="stars-select cf col-md-6 star-select margin-bottom-15">
							<select name="stars" class="select-menu">
								<option value="" label><?php _e( 'Evaluate the quality of services', 'local' ) ?></option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div>
					</div>

					<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">

					<div class="cf">
						<div class="left response">

						</div>

						<button type="submit" class="btn small blue-light-bg orange-bg-hover white-col right btn-shadow"><?php _e( 'Leave a review', 'local' ); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>