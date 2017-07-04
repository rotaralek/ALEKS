<div class="col-sm-6 margin-bottom-30">
	<article <?php post_class( 'archive-car-rentals-item card-shadow flex-box transition' ); ?>>
		<div class="image margin-bottom-15">
			<a href="<?php the_permalink(); ?>">
				<?php echo tell_get_post_image( 420, 260 ); ?>
			</a>
		</div>

		<div class="text cf">
			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h2>

			<div class="details margin-bottom-30">
				<?php $body_types = wp_get_post_terms( $post->ID, 'body-type', array( "fields" => "all" ) );
				foreach ( $body_types as $body_type ) {
					echo '<p><i class="material-icons">directions_car</i><em>' . __( 'Body type', 'local' ) . ':</em> ' . $body_type->name . '</p>';
				} ?>

				<?php $seats = wp_get_post_terms( $post->ID, 'seats', array( "fields" => "all" ) );
				foreach ( $seats as $seat ) {
					echo '<p><i class="material-icons">airline_seat_recline_normal</i><em>' . __( 'Seats', 'local' ) . ':</em> ' . $seat->name . '</p>';
				} ?>

				<?php $doors = wp_get_post_terms( $post->ID, 'doors', array( "fields" => "all" ) );
				foreach ( $doors as $door ) {
					echo '<p><i class="material-icons">markunread_mailbox</i><em>' . __( 'Doors', 'local' ) . ':</em> ' . $door->name . '</p>';
				} ?>

				<?php $trunks = wp_get_post_terms( $post->ID, 'trunk', array( "fields" => "all" ) );
				foreach ( $trunks as $trunk ) {
					echo '<p><i class="material-icons">card_travel</i><em>' . __( 'Bags', 'local' ) . ':</em> ' . $trunk->name . '</p>';
				} ?>

				<?php $transmissions = wp_get_post_terms( $post->ID, 'transmission', array( "fields" => "all" ) );
				foreach ( $transmissions as $transmission ) {
					echo '<p><i class="material-icons">settings_applications</i><em>' . __( 'Transmission', 'local' ) . ':</em> ' . $transmission->name . '</p>';
				} ?>

				<?php if ( 'yes' == tell_get_meta( 'car_rentals_air_conditioned' ) ) { ?>
					<p><i class="material-icons">toys</i><em><?php _e( 'Air conditioned', 'local' ); ?>
							?:</em> <?php echo tell_get_meta( 'car_rentals_air_conditioned' ); ?></p>
				<?php } ?>
			</div>

			<?php if ( tell_get_meta( 'post_price' ) ) { ?>
				<a href="<?php the_permalink(); ?>" class="btn small red-bg white-col blue-light-bg-hover btn-shadow left"><?php echo __( 'Price', 'local' ) . ': ' . tell_get_option( 'opt-currency' ) . ' ' . tell_get_meta( 'post_price' ); ?></a>
			<?php } ?>

			<a href="<?php the_permalink(); ?>" class="btn small orange-bg white-col blue-light-bg-hover btn-shadow right"><?php _e( 'Details', 'local' ); ?></a>
		</div>
	</article>
</div>