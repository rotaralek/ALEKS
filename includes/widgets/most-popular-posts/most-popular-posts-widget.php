<?php

// Creating the widget
class Tell_MostPopularPosts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'tell_post_popular_posts', // Base ID
			__( 'Most popular posts (Tellus)', 'local' ), // Name
			array( 'description' => __( 'Widget displays the most viewed entries.', 'local' ) ) // Args
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		}

		if ( isset( $instance[ 'posts_number' ] ) ) {
			$posts_number = $instance[ 'posts_number' ] ? $instance[ 'posts_number' ] : '';
		}

		if ( isset( $instance[ 'posts_type' ] ) ) {
			$posts_type = $instance[ 'posts_type' ] ? $instance[ 'posts_type' ] : '';
		}

		// before and after widget arguments are defined by themes
		echo $args[ 'before_widget' ];
		if ( !empty( $title ) ) {
			echo $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		}

		echo '<div class="cf row">';

		if ( !isset( $posts_number ) && empty( $posts_number ) ) {
			$posts_number = 3;
		}

		if ( !isset( $posts_type ) && empty( $posts_type ) ) {
			$posts_type = 'post';
		}

		wp_reset_query();
		$query_most_popular_posts = new WP_Query(
			array(
				'posts_per_page' => $posts_number,
				'post_type'      => $posts_type,
				'order'          => 'ASC',
				'orderby'        => 'meta_value',
				'meta_key'       => 'tell_post_views'
			)
		);
		if ( $query_most_popular_posts->have_posts() ): while ( $query_most_popular_posts->have_posts() ) : $query_most_popular_posts->the_post(); ?>
			<div class="col-md-12 col-sm-6">
				<article <?php post_class( 'margin-bottom-30 cf' ); ?>>
					<div class="image">
						<a href="<?php the_permalink(); ?>">
							<?php echo tell_get_post_image( 270, 150 ); ?>
						</a>
					</div>

					<div class="text">
						<h4>
							<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
						</h4>

						<time datetime="<?php the_time( 'Y-m-d' ); ?>">
							<i class="material-icons">event_note</i><?php the_time( 'd m Y' ); ?></time>
					</div>
				</article>
			</div>
		<?php endwhile; endif;
		wp_reset_query();
		echo '</div>';
		echo $args[ 'after_widget' ];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		} else {
			$title = '';
		}
		if ( isset( $instance[ 'posts_number' ] ) ) {
			$posts_number = $instance[ 'posts_number' ];
		} else {
			$posts_number = '';
		}
		if ( isset( $instance[ 'posts_type' ] ) ) {
			$posts_type = $instance[ 'posts_type' ];
		} else {
			$posts_type = '';
		}
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'local' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_type' ); ?>"><?php _e( 'Post type', 'local' ); ?>
				:</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'posts_type' ); ?>" name="<?php echo $this->get_field_name( 'posts_type' ); ?>">
				<option value="post" <?php if ( 'post' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Post', 'local' ); ?></option>
				<option value="tours" <?php if ( 'tours' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Tours', 'local' ); ?></option>
				<option value="cruises" <?php if ( 'cruises' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Cruises', 'local' ); ?></option>
				<option value="hotels" <?php if ( 'hotels' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Hotels', 'local' ); ?></option>
				<option value="rooms" <?php if ( 'rooms' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Rooms', 'local' ); ?></option>
				<option value="car-rentals" <?php if ( 'car-rentals' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Car rentals', 'local' ); ?></option>
				<option value="reviews" <?php if ( 'reviews' == $posts_type ) {
					echo 'selected';
				} ?>><?php _e( 'Reviews', 'local' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php _e( 'Posts number', 'local' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" type="text" value="<?php echo esc_attr( $posts_number ); ?>">
		</p>
		<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance                   = $old_instance;
		$instance[ 'title' ]        = ( !empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
		$instance[ 'posts_number' ] = ( !empty( $new_instance[ 'posts_number' ] ) ) ? strip_tags( $new_instance[ 'posts_number' ] ) : '';
		$instance[ 'posts_type' ]   = ( !empty( $new_instance[ 'posts_type' ] ) ) ? strip_tags( $new_instance[ 'posts_type' ] ) : '';

		return $instance;
	}
} // Class wpb_widget ends here

add_action( 'widgets_init', function () {
	register_widget( 'Tell_MostPopularPosts_Widget' );
} );