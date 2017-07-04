<article <?php post_class( 'archive-rooms-item card-shadow transition margin-bottom-30 cf' ); ?>>
	<div class="col-sm-5 margin-bottom-30">
		<div class="image row">
			<a href="<?php the_permalink(); ?>">
				<?php echo tell_get_post_image( 420, 420 ); ?>
			</a>
		</div>
	</div>

	<div class="col-sm-7 cf margin-bottom-30">
		<div class="text left-padding row">
			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h2>

			<dl class="details">
				<?php if ( tell_get_meta( 'post_price' ) ) { ?>
					<dt class="left clear"><i class="material-icons">credit_card</i><?php _e( 'Price', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'post_price' ) . ' ' . tell_get_option( 'opt-currency' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_size' ) ) { ?>
					<dt class="left clear"><i class="material-icons">zoom_out_map</i><?php _e( 'Size', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'rooms_size' );
						_e( ' m<sup>2</sup>' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_guests' ) ) { ?>
					<dt class="left clear"><i class="material-icons">transfer_within_a_station</i><?php _e( 'Guests', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'rooms_guests' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_entertainment' ) ) { ?>
					<dt class="left clear"><i class="material-icons">streetview</i><?php _e( 'Entertainment', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'rooms_entertainment' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_food_rink' ) ) { ?>
					<dt class="left clear"><i class="material-icons">restaurant</i><?php _e( 'Food & Drink', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'rooms_food_rink' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_sleep' ) ) { ?>
					<dt class="left clear"><i class="material-icons">hotel</i><?php _e( 'Sleep', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'rooms_sleep' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_bathroom' ) ) { ?>
					<dt class="left clear"><i class="material-icons">hot_tub</i><?php _e( 'Bathroom', 'local' ); ?>:</dt>

					<dd><?php echo tell_get_meta( 'rooms_bathroom' ); ?></dd>
				<?php } ?>

				<?php if ( tell_get_meta( 'rooms_comfort' ) ) { ?>
					<dt class="left clear">
						<i class="material-icons">airline_seat_recline_extra</i><?php _e( 'Comfort', 'local' ); ?>:
					</dt>

					<dd><?php echo tell_get_meta( 'rooms_comfort' ); ?></dd>
				<?php } ?>
			</dl>
		</div>
	</div>

	<div class="clear text">
		<?php $rooms_details = tell_get_meta( 'rooms_details' );
		if ( is_array( tell_get_meta( 'rooms_details' ) ) && !empty( $rooms_details ) ) { ?>
			<div class="details margin-bottom-30">
				<dl class="cf">
					<dt><em><?php _e( 'Details', 'local' ); ?>:</em></dt>

					<?php foreach ( tell_get_meta( 'rooms_details' ) as $item ) {
						echo '<dd class="left">' . $item . '</dd>';
					} ?>
				</dl>
			</div>
		<?php } ?>

		<a href="<?php the_permalink(); ?>" class="btn small orange-bg white-col blue-light-bg-hover btn-shadow right"><?php _e( 'Details', 'local' ); ?></a>
	</div>
</article>