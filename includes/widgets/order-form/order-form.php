<?php

// Creating the widget
class Tell_Order_Form_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'tell_order_form_widget', // Base ID
			__( 'Order Form (Tellus)', 'local' ), // Name
			array( 'description' => __( 'Widget displays the Order Form.', 'local' ) ) // Args
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		global $post;
		if ( is_single() && isset( $post->post_type ) && ( 'tours' == $post->post_type || 'cruises' == $post->post_type || 'excursions' == $post->post_type || 'hotels' == $post->post_type || 'rooms' == $post->post_type || 'car-rentals' == $post->post_type ) ) {
			if ( isset( $instance[ 'title' ] ) ) {
				$title = apply_filters( 'widget_title', $instance[ 'title' ] );
			}

			// before and after widget arguments are defined by themes
			echo $args[ 'before_widget' ];
			echo '<div class="cf">';
			if ( !empty( $title ) ) {
				echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
			} ?>

			<form action="<?php the_permalink(); ?>" method="POST" class="order-form grey-light-bg text-center">
				<input type="text" name="order_item_id" value="<?php global $global_post_id, $global_post_name;
				if ( isset( $global_post_id ) && !empty( $global_post_id ) ) {
					echo $global_post_id;
				} ?>" hidden>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Selected item', 'local' ); ?></p>

					<div class="input-field white-bg">
						<input type="text" name="order_item_name" value="<?php global $global_post_id, $global_post_name;
						if ( isset( $global_post_id ) && !empty( $global_post_id ) ) {
							echo get_the_title( $global_post_id );
						} ?>" readonly>

						<i class="material-icons white-col blue-light-bg orange-bg-hover">place</i>
					</div>
				</label>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Name', 'local' ); ?></p>

					<div class="input-field white-bg">
						<input type="text" name="order_name">

						<i class="material-icons white-col blue-light-bg orange-bg-hover">person</i>
					</div>
				</label>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Date begin', 'local' ); ?></p>

					<div class="input-field white-bg">
						<input type="text" name="order_date_begin" class="date-picker">

						<i class="material-icons white-col blue-light-bg orange-bg-hover">date_range</i>
					</div>
				</label>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Date end', 'local' ); ?></p>

					<div class="input-field white-bg">
						<input type="text" name="order_date_end" class="date-picker">

						<i class="material-icons white-col blue-light-bg orange-bg-hover">date_range</i>
					</div>
				</label>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Phone', 'local' ); ?></p>

					<div class="input-field white-bg">
						<input type="number" name="order_phone">

						<i class="material-icons white-col blue-light-bg orange-bg-hover">phone</i>
					</div>
				</label>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Email', 'local' ); ?></p>

					<div class="input-field white-bg">
						<input type="email" name="order_email">

						<i class="material-icons white-col blue-light-bg orange-bg-hover">mail_outline</i>
					</div>
				</label>

				<label class="black-col text-left margin-bottom-15">
					<p><?php _e( 'Message', 'local' ); ?></p>

					<div class="white-bg">
						<textarea type="email" name="order_message"></textarea>
					</div>
				</label>

				<button type="submit" class="btn small blue-bg white-col orange-bg-hover"><?php _e( 'Order now', 'local' ); ?></button>
				<div class="response text-center"></div>
			</form>

			<?php echo '</div>';
			echo $args[ 'after_widget' ];
		}
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = '';
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'local' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance[ 'title' ] = ( !empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';

		return $instance;
	}
} // Class wpb_widget ends here

add_action( 'widgets_init', function () {
	register_widget( 'Tell_Order_Form_Widget' );
} );