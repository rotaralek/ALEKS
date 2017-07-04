<?php
//Load posts
add_action( 'tell_ajax_load_posts', 'load_posts' );
add_action( 'tell_ajax_nopriv_load_posts', 'load_posts' );
function load_posts() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}

	//Values
	$post_type       = $_POST[ 'postType' ];
	$number_of_posts = $_POST[ 'numberOfPosts' ];
	$offset          = $_POST[ 'offset' ];
	$category        = $_POST[ 'category' ];
	$tags            = $_POST[ 'tags' ];
	$date            = $_POST[ 'date' ];
	$stars           = $_POST[ 'stars' ];
	$price           = $_POST[ 'price' ];
	$room_type       = $_POST[ 'roomType' ];
	$search          = $_POST[ 'search' ];
	if ( preg_match( '/,/', $post_type ) ) {
		$post_type = explode( ',', $post_type );
	}
	if ( !empty( $price ) ) {
		$price = explode( '-', $price );
	}
	$city         = $_POST[ 'city' ];
	$body_type    = $_POST[ 'bodyType' ];
	$transmission = $_POST[ 'transmission' ];

	$GLOBALS[ 'counter' ] = $offset;

	//Empty meta
	$meta_array = array(
		'relation' => 'AND',
	);

	$tax_array = array(
		'relation' => 'AND',
	);

	//Checking
	if ( !empty( $category ) ) {
		$tax_array[] = array(
			'taxonomy' => $post_type . '-country',
			'field'    => 'slug',
			'terms'    => $category
		);
	}
	if ( !empty( $tags ) ) {
		$tax_array[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => $tags
		);
	}
	if ( !empty( $city ) ) {
		$tax_array[] = array(
			'taxonomy' => $post_type . '-country',
			'field'    => 'slug',
			'terms'    => $city
		);
	}
	if ( !empty( $room_type ) ) {
		$tax_array[] = array(
			'taxonomy' => 'room-type',
			'field'    => 'slug',
			'terms'    => $room_type
		);
	}
	if ( !empty( $body_type ) ) {
		$tax_array[] = array(
			'taxonomy' => 'body-type',
			'field'    => 'slug',
			'terms'    => $body_type
		);
	}
	if ( !empty( $transmission ) ) {
		$tax_array[] = array(
			'taxonomy' => 'transmission',
			'field'    => 'slug',
			'terms'    => $transmission
		);
	}
	if ( !empty( $date ) ) {
		$meta_array[] = array(
			'key'     => 'tell_post_date',
			'value'   => $date,
			'compare' => '='
		);
	}
	if ( !empty( $stars ) ) {
		$meta_array[] = array(
			'key'     => 'tell_post_stars',
			'value'   => $stars,
			'compare' => '='
		);
	}
	if ( !empty( $price ) ) {
		$meta_array[] = array(
			'key'     => 'tell_post_price',
			'value'   => array( intval( $price[ 0 ] ), intval( $price[ 1 ] ) ),
			'compare' => 'BETWEEN',
			'type'    => 'numeric'
		);
	}

	//Query
	global $post;
	wp_reset_query();
	if ( '' != $search ) {
		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => $number_of_posts,
				'offset'         => $offset,
				'meta_query'     => $meta_array,
				'tax_query'      => $tax_array,
				's'              => $search
			)
		);
	} else {
		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => $number_of_posts,
				'offset'         => $offset,
				'meta_query'     => $meta_array,
				'tax_query'      => $tax_array
			)
		);
	}

	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		if ( 'tours' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'tours' );
		} elseif ( 'excursions' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'excursions' );
		} elseif ( 'cruises' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'cruises' );
		} elseif ( 'hotels' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'hotels' );
		} elseif ( 'rooms' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'rooms' );
		} elseif ( 'car-rentals' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'car-rentals' );
		} elseif ( 'news' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'news' );
		} elseif ( 'reviews' == $post->post_type ) {
			get_template_part( 'partials/article/article', 'reviews' );
		} else {
			get_template_part( 'partials/article/article', 'post' );
		}
		$counter++;
	endwhile; endif;
	wp_reset_query();

	exit();
}

add_action( 'tell_ajax_load_categories', 'load_categories' );
add_action( 'tell_ajax_nopriv_load_categories', 'load_categories' );
function load_categories() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}

	$post_type = $_POST[ 'postType' ]; ?>

	<nav>
		<?php $args = array(
			'type'         => $post_type,
			'child_of'     => 0,
			'parent'       => 0,
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 1,
			'hierarchical' => 1,
			'exclude'      => '',
			'include'      => '',
			'number'       => '',
			'taxonomy'     => $post_type . '-country',
			'pad_counts'   => false );

		$categories = get_categories( $args ); ?>
		<ul>
			<?php foreach ( $categories as $cat ) {
				echo '<li><a href="' . home_url() . '/' . $post_type . '-country/' . $cat->slug . '" class="black-col red-col-hover" data-post-type="' . $post_type . '" data-category="' . $cat->slug . '">' . $cat->name . '</a></li>';
			} ?>
		</ul>
	</nav>

	<?php
	exit();
}


add_action( 'tell_ajax_tell_get_country', 'tell_get_country' );
add_action( 'tell_ajax_nopriv_tell_get_country', 'tell_get_country' );
function tell_get_country() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}

	$post_type = $_POST[ 'postType' ];
	$baseLabel = $_POST[ 'baseLabel' ];

	$selectedItem = $_POST[ 'selectedItem' ];
	$idObj        = get_term_by( 'slug', $selectedItem, 'country' );
	$id           = $idObj->term_id;
	$args         = array(
		'type'         => $post_type,
		'child_of'     => 0,
		'parent'       => 0,
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 1,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => $post_type . '-country',
		'pad_counts'   => false
	);


	$categories = get_categories( $args );
	echo '<option value="" label>' . $baseLabel . '</option>';
	foreach ( $categories as $cat ) {
		echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
	}
	exit();
}

add_action( 'tell_ajax_tell_get_child_country', 'tell_get_child_country' );
add_action( 'tell_ajax_nopriv_tell_get_child_country', 'tell_get_child_country' );
function tell_get_child_country() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}

	$post_type   = $_POST[ 'postType' ];
	$baseLabel   = $_POST[ 'baseLabel' ];
	$selectValue = $_POST[ 'selectValue' ];

	$idObj = get_term_by( 'slug', $selectValue, $post_type . '-country' );
	$id    = $idObj->term_id;
	$args  = array(
		'type'         => $post_type,
		'child_of'     => 0,
		'parent'       => $id,
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 1,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => $post_type . '-country',
		'pad_counts'   => false
	);


	$categories = get_categories( $args );
	echo '<option value="" label>' . $baseLabel . '</option>';
	foreach ( $categories as $cat ) {
		echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
	}
	exit();
}

add_action( 'tell_ajax_reviews_create', 'reviews_create' );
add_action( 'tell_ajax_nopriv_reviews_create', 'reviews_create' );
function reviews_create() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}
	$all_fields = $_POST[ 'reviewFields' ];
	$text       = $all_fields[ 0 ][ 'value' ];
	$name       = $all_fields[ 1 ][ 'value' ];
	$star       = $all_fields[ 2 ][ 'value' ];
	$post_id    = $all_fields[ 3 ][ 'value' ];

	if ( '' != $name && '' != $star && '' != $text && '' != $post_id ) {
		$post_args = array(
			'post_type'    => 'reviews',
			'post_title'   => $name,
			'post_author'  => 'review',
			'post_content' => $text,
			'post_excerpt' => '',
			'post_status'  => 'publish'
		);

		// Create post
		$created_post_id = wp_insert_post( $post_args );

		update_post_meta( $created_post_id, 'tell_post_stars', $star );
		add_post_meta( $created_post_id, 'tell_reviews_posts', $post_id );

		echo '<p class="left green-light-col">' . __( 'Your review has been created. ', 'local' ) . '</p>';
	} else {
		echo '<p class="left white-col">' . __( 'Please fill in all fields.', 'local' ) . '</p>';
	}

	exit();
}

add_action( 'tell_ajax_reviews_posts', 'reviews_posts' );
add_action( 'tell_ajax_nopriv_reviews_posts', 'reviews_posts' );
function reviews_posts() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}

	$post_reviews_id = $_POST[ 'postId' ];
	$query_reviews   = new WP_Query(
		array(
			'post_type'      => 'reviews',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'tell_reviews_posts',
					'value'   => $post_reviews_id,
					'compare' => 'LIKE'
				)
			)
		)
	);
	if ( $query_reviews->have_posts() ) : while ( $query_reviews->have_posts() ) : $query_reviews->the_post(); ?>
		<div class="item margin-bottom-30 padding-bottom-30">
			<h4 class="cf">
				<?php the_title(); ?>

				<?php if ( tell_get_meta( 'reviews_stars' ) ) { ?>
					<span class="right rating">
						<?php $number_of_stars = tell_get_meta( 'reviews_stars' );
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
	<?php endwhile; endif;
	wp_reset_query();
	exit();
}

add_action( 'tell_ajax_order_submit', 'order_submit' );
add_action( 'tell_ajax_nopriv_order_submit', 'order_submit' );
function order_submit() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}
	$order_item_id    = $_POST[ 'orderItemId' ];
	$order_item_name  = $_POST[ 'orderItemName' ];
	$order_name       = $_POST[ 'orderName' ];
	$order_date_begin = $_POST[ 'orderDateBegin' ];
	$order_date_end   = $_POST[ 'orderDateEnd' ];
	$order_phone      = $_POST[ 'orderPhone' ];
	$order_email      = $_POST[ 'orderEmail' ];
	$order_message    = $_POST[ 'orderMessage' ];


	if ( '' != $order_item_id && '' != $order_item_name && '' != $order_name && '' != $order_date_begin && '' != $order_date_end && '' != $order_phone && '' != $order_email && '' != $order_message ) {
		$message = '<p><b>' . __( 'Selected item:', 'local' ) . '</b> ' . $order_item_name . '</p>';
		$message .= '<p><b>' . __( 'Selected item Link:', 'local' ) . '</b> <a href="' . get_the_permalink( $order_item_id ) . '">' . get_the_permalink( $order_item_id ) . '</a></p>';
		$message .= '<p><b>' . __( 'Name:', 'local' ) . '</b> ' . $order_name . '</p>';
		$message .= '<p><b>' . __( 'Date begin:', 'local' ) . '</b> ' . $order_date_begin . '</p>';
		$message .= '<p><b>' . __( 'Date end:', 'local' ) . '</b> ' . $order_date_end . '</p>';
		$message .= '<p><b>' . __( 'Phone:', 'local' ) . '</b> ' . $order_phone . '</p>';
		$message .= '<p><b>' . __( 'Email:', 'local' ) . '</b> ' . $order_email . '</p>';
		$message .= '<p><b>' . __( 'Message:', 'local' ) . '</b> ' . $order_message . '</p>';

		//php mailer variables
		$to      = get_option( 'admin_email' );
		$subject = $order_name . ' sent a message from ' . get_bloginfo( 'name' );
		$headers = 'From: ' . $order_email . ' Reply-To: ' . $order_email . "\r\n";
		$headers .= "CC: " . get_option( 'admin_email' ) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		if ( !filter_var( $order_email, FILTER_VALIDATE_EMAIL ) === false ) {
			$sent = mail( $to, $subject, $message, $headers );
			if ( $sent ) {
				echo '<p class="green-light-col">' . __( 'Your order has been sent.', 'local' ) . '</p>';
			} else {
				echo '<p class="red-col">' . __( 'Something went wrong, try again later.', 'local' ) . '</p>';
			}
		} else {
			echo '<p class="red-col">' . __( 'Wrong Email.', 'local' ) . '</p>';
		}
	} else {
		echo '<p class="red-col">' . __( 'Please fill in all fields.', 'local' ) . '</p>';
	}
	exit();
}

//Colors
add_action( 'tell_ajax_change_red_col', 'change_red_col' );
add_action( 'tell_ajax_nopriv_change_red_col', 'change_red_col' );
add_action( 'tell_ajax_nopriv_change_red_col', 'change_red_col' );
function change_red_col() {
	$color = $_POST[ 'color' ];

	if ( '' != $color ) {
		SetCookie( 'change_red_col', '#' . $color, time() + 60 * 60 * 24 * 30, '/' );
	}
}

add_action( 'tell_ajax_change_blue_col', 'change_blue_col' );
add_action( 'tell_ajax_nopriv_change_blue_col', 'change_blue_col' );
function change_blue_col() {
	$color = $_POST[ 'color' ];

	if ( '' != $color ) {
		SetCookie( 'change_blue_col', '#' . $color, time() + 60 * 60 * 24 * 30, '/' );
	}
}

add_action( 'tell_ajax_change_blue_light_col', 'change_blue_light_col' );
add_action( 'tell_ajax_nopriv_change_blue_light_col', 'change_blue_light_col' );
function change_blue_light_col() {
	$color = $_POST[ 'color' ];

	if ( '' != $color ) {
		SetCookie( 'change_blue_light_col', '#' . $color, time() + 60 * 60 * 24 * 30, '/' );
	}
}

add_action( 'tell_ajax_change_yellow_col', 'change_yellow_col' );
add_action( 'tell_ajax_nopriv_change_yellow_col', 'change_yellow_col' );
function change_yellow_col() {
	$color = $_POST[ 'color' ];

	if ( '' != $color ) {
		SetCookie( 'change_yellow_col', '#' . $color, time() + 60 * 60 * 24 * 30, '/' );
	}
}

add_action( 'tell_ajax_change_orange_col', 'change_orange_col' );
add_action( 'tell_ajax_nopriv_change_orange_col', 'change_orange_col' );
function change_orange_col() {
	$color = $_POST[ 'color' ];

	if ( '' != $color ) {
		SetCookie( 'change_orange_col', '#' . $color, time() + 60 * 60 * 24 * 30, '/' );
	}
}

add_action( 'tell_ajax_contact_form_submit', 'contact_form_submit' );
add_action( 'tell_ajax_nopriv_contact_form_submit', 'contact_form_submit' );
function contact_form_submit() {
	$nonce = $_POST[ 'nonce' ];
	if ( !wp_verify_nonce( $nonce, 'ajax_admin-nonce' ) ) {
		exit( 'Stop!' );
	}
	//print_r(json_encode($_FILES));
	$all_fields = $_POST[ 'allFields' ];

	if ( '' != $all_fields[ 0 ][ 'value' ] && '' != $all_fields[ 1 ][ 'value' ] && '' != $all_fields[ 2 ][ 'value' ] ) {

		$name  = $all_fields[ 0 ][ 'value' ];
		$email = $all_fields[ 1 ][ 'value' ];
		$email = str_replace( '%40', '@', $email );
		$text  = $all_fields[ 2 ][ 'value' ];

		$message = '<p><b>' . __( 'Name:', 'local' ) . '</b> ' . $name . '</p>';
		$message .= '<p><b>' . __( 'Email:', 'local' ) . '</b> ' . $email . '</p>';
		$message .= '<p><b>' . __( 'Message:', 'local' ) . '</b> ' . $text . '</p>';

		//php mailer variables
		$to      = get_option( 'admin_email' );
		$subject = $name . ' sent a message from ' . get_bloginfo( 'name' );
		$headers = 'From: ' . $email . ' Reply-To: ' . $email . "\r\n";
		$headers .= "CC: " . $to . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) === false ) {
			$sent = mail( $to, $subject, $message, $headers );
			if ( $sent ) {
				echo '<p class="left green-light-col"><i class="ti-check"></i> ' . __( 'Your message has been sent.', 'local' ) . '</p>';
			} else {
				echo '<p class="left red-col"><i class="ti-close"></i> ' . __( 'Your message can\'t been sent.', 'local' ) . '</p>';
			}
		} else {
			echo '<p class="left red-col"><i class="ti-close"></i> ' . __( 'Wrong Email.', 'local' ) . '</p>';
		}
	} else {
		echo '<p class="left red-col"><i class="ti-close"></i> ' . __( 'Please fill in all fields.', 'local' ) . '</p>';
	}
	exit();
}