<div class="col-sm-6 margin-bottom-30">
	<article <?php post_class( 'archive-hotels-item card-shadow flex-box transition' ); ?>>
		<div class="image">
			<a href="<?php the_permalink(); ?>">
				<?php echo tell_get_post_image( 420, 260 ); ?>
			</a>

			<?php if ( tell_get_meta( 'post_stars' ) ) { ?>
				<div class="stars">
					<?php $number_of_stars = tell_get_meta( 'post_stars' );
					for ( $i = 0; $i < $number_of_stars; $i++ ) { ?>
						<i class="material-icons yellow-col">star_rate</i>
					<?php } ?>
				</div>
			<?php } ?>
		</div>

		<div class="text cf">
			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h2>

			<div class="details">
				<?php if ( tell_get_meta( 'hotels_location' ) ) { ?>
					<p class="address"><i class="material-icons">location_on</i><?php _e( 'Address', 'local' ); ?>
						: <?php echo tell_get_meta( 'hotels_location' ); ?></p>
				<?php } ?>
			</div>

			<div class="details margin-bottom-15 left">
				<?php if ( tell_get_meta( 'post_price' ) ) { ?>
					<p class="price-from"><i class="material-icons">credit_card</i><?php _e( 'Price from', 'local' ); ?>
						: <?php echo tell_get_meta( 'post_price' ) . ' ' . tell_get_option( 'opt-currency' ); ?></p>
				<?php } ?>

				<?php if ( tell_get_meta( 'post_price_end' ) ) { ?>
					<p class="price-from"><i class="material-icons">credit_card</i><?php _e( 'Price to', 'local' ); ?>
						: <?php echo tell_get_meta( 'post_price_end' ) . ' ' . tell_get_option( 'opt-currency' ); ?></p>
				<?php } ?>
			</div>

			<a href="<?php the_permalink(); ?>" class="btn small orange-bg white-col blue-light-bg-hover btn-shadow right"><?php _e( 'Details', 'local' ); ?></a>
		</div>
	</article>
</div>