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
	$taxonomy        = $_POST[ 'taxonomy' ];
	$category        = $_POST[ 'category' ];
	$tags            = $_POST[ 'tags' ];
	$search          = $_POST[ 'search' ];
	$price           = $_POST[ 'price' ];
	$gender          = $_POST[ 'gender' ];
	$order_by        = $_POST[ 'orderBy' ];
	$user_id         = $_POST[ 'userId' ];
	if ( preg_match( '/,/', $post_type ) ) {
		$post_type = explode( ',', $post_type );
	}
	if ( preg_match( '/,/', $taxonomy ) ) {
		$taxonomy = explode( ',', $taxonomy );
	}
	if ( preg_match( '/,/', $category ) ) {
		$category = explode( ',', $category );
	}
	if ( preg_match( '/-/', $price ) ) {
		$price = explode( '-', $price );
	}

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
		if ( !is_array( $category ) ) {
			$tax_array = array(
				'relation' => 'OR',
			);
		}

		if ( is_array( $taxonomy ) ) {
			foreach ( $taxonomy as $tax ) {
				$tax_array[] = array(
					'taxonomy' => $tax,
					'field'    => 'id',
					'terms'    => $category
				);
			}
		} else {
			$tax_array[] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'id',
				'terms'    => $category
			);
		}
	}
	if ( !empty( $tags ) ) {
		$tax_array[] = array(
			'taxonomy' => 'post_tag',
			'field'    => 'slug',
			'terms'    => $tags
		);
	}
	if ( !empty( $price ) ) {
		$meta_array[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'tell_experts_minimal_price',
				'value'   => array( intval( $price[ 0 ] ), intval( $price[ 1 ] ) ),
				'compare' => 'BETWEEN',
				'type'    => 'numeric'
			),
			array(
				'key'     => 'tell_experts_maximal_price',
				'value'   => array( intval( $price[ 0 ] ), intval( $price[ 1 ] ) ),
				'compare' => 'BETWEEN',
				'type'    => 'numeric'
			),
			array(
				'relation' => 'AND',
				array(
					'key'     => 'tell_experts_minimal_price',
					'value'   => intval( $price[ 0 ] ),
					'compare' => '<=',
					'type'    => 'numeric'
				),
				array(
					'key'     => 'tell_experts_maximal_price',
					'value'   => intval( $price[ 1 ] ),
					'compare' => '>=',
					'type'    => 'numeric'
				)
			)
		);
	}

	if ( !empty( $gender ) ) {
		$meta_array[] = array(
			array(
				'key'     => 'tell_experts_gender',
				'value'   => $gender,
				'compare' => '='
			)
		);
	}

	if ( !empty( $user_id ) ) {
		$meta_array[] = array(
			'key'   => 'tell_users_id',
			'value' => $user_id
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
	} elseif ( '' != $order_by ) {
		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'posts_per_page' => $number_of_posts,
				'offset'         => $offset,
				'meta_query'     => $meta_array,
				'tax_query'      => $tax_array,
				'orderby'        => 'meta_value_num',
				'meta_key'       => 'tell_views',
				'order'          => 'DESC'
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
		if ( 'experts' == $post->post_type ) {
			get_template_part( 'partials/article/experts' );
		} elseif ( 'conference' == $post->post_type ) {
			get_template_part( 'partials/article/conference' );
		} elseif ( 'news' == $post->post_type ) {
			get_template_part( 'partials/article/news' );
		} elseif ( 'video' == $post->post_type ) {
			get_template_part( 'partials/article/video' );
		} else {
			get_template_part( 'partials/article/post' );
		}
	endwhile; endif;
	wp_reset_query();

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

//Login form
add_action( 'tell_ajax_login_form', 'login_form' );
add_action( 'tell_ajax_nopriv_login_form', 'login_form' );
function login_form() { ?>
	<form action="/wp-login.php" method="POST" class="cf login-form">
		<h1 class="margin-bottom-15"><?php _e( 'Login', 'local' ); ?></h1>

		<input type="text" name="log" placeholder="<?php _e( 'Login', 'local' ); ?>" maxlength="30" class="margin-bottom-15">
		<input type="password" name="pwd" placeholder="<?php _e( 'Password', 'local' ); ?>" maxlength="30" class="margin-bottom-15">
		<button type="submit" class="btn normal blue-bg white-col blue-light-bg-hover right"><?php _e( 'Login', 'local' ); ?></button>
	</form>
	<?php
	exit();
}

//Registration form
add_action( 'tell_ajax_registration_form', 'registration_form' );
add_action( 'tell_ajax_nopriv_registration_form', 'registration_form' );
function registration_form() { ?>
	<form action="/wp-login.php?action=register" method="POST" class="cf registration-form">
		<h1 class="margin-bottom-15"><?php _e( 'Registration', 'local' ); ?></h1>

		<div class="registration-items">
			<div class="slide-box cf">
				<div class="item item-1 left active">
					<div class="form-field margin-bottom-15">
						<input type="text" name="first_name" placeholder="<?php _e( 'First name', 'local' ); ?> *" maxlength="30" required>
					</div>

					<div class="form-field margin-bottom-15">
						<input type="text" name="middle_name" placeholder="<?php _e( 'Middle name', 'local' ); ?>" maxlength="30">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="text" name="last_name" placeholder="<?php _e( 'Last name', 'local' ); ?>" maxlength="30">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="text" name="birthday" placeholder="<?php _e( 'Birthday', 'local' ); ?> *" maxlength="30" required class="date-picker">
					</div>

					<div class="form-field margin-bottom-15">
						<label>
							<input type="radio" name="gender" value="male" required>
							<span><?php _e( 'Male', 'local' ); ?> *</span>
						</label>

						<label>
							<input type="radio" name="gender" value="female" required>
							<span><?php _e( 'Female', 'local' ); ?> *</span>
						</label>
					</div>
				</div>

				<div class="item item-2 left">
					<div class="form-field margin-bottom-15">
						<input type="text" name="login" placeholder="<?php _e( 'Login', 'local' ); ?> *" maxlength="30" required>
					</div>

					<div class="form-field margin-bottom-15">
						<input type="password" name="password" placeholder="<?php _e( 'Password', 'local' ); ?> *" maxlength="30" required>
					</div>

					<div class="form-field margin-bottom-15">
						<input type="password" name="repeat_password" placeholder="<?php _e( 'Repeat password', 'local' ); ?> *" maxlength="30" required>
					</div>
				</div>

				<div class="item item-3 left">
					<div class="form-field margin-bottom-15">
						<input type="email" name="email" placeholder="<?php _e( 'Email', 'local' ); ?> *" maxlength="30" required>
					</div>

					<div class="form-field margin-bottom-15">
						<input type="tel" name="phone" placeholder="<?php _e( 'Phone', 'local' ); ?>" maxlength="60">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="text" name="address" placeholder="<?php _e( 'Address', 'local' ); ?>" maxlength="30">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="site" placeholder="<?php _e( 'Site', 'local' ); ?>" maxlength="30">
					</div>
				</div>

				<div class="item item-4 left">
					<div class="form-field margin-bottom-15">
						<input type="url" name="google_plus" placeholder="<?php _e( 'Google+ profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="twitter" placeholder="<?php _e( 'Twitter profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="facebook" placeholder="<?php _e( 'Facebook profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="ok" placeholder="<?php _e( 'Ok profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="vk" placeholder="<?php _e( 'Vk profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="pinterest" placeholder="<?php _e( 'Pinterest profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="instagram" placeholder="<?php _e( 'Instagram profile url', 'local' ); ?>" maxlength="100">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="url" name="youtube" placeholder="<?php _e( 'Youtube profile url', 'local' ); ?>" maxlength="100">
					</div>
				</div>

				<div class="item item-5 left">
					<div class="form-field margin-bottom-15">
						<textarea name="education" placeholder="<?php _e( 'Education', 'local' ); ?>" maxlength="10000"></textarea>
					</div>

					<div class="form-field margin-bottom-15">
						<textarea name="work_experience" placeholder="<?php _e( 'Work experience', 'local' ); ?>" maxlength="10000"></textarea>
					</div>
				</div>

				<div class="item item-6 left">
					<div class="form-field margin-bottom-15">
						<input type="number" name="min_price" placeholder="<?php _e( 'Minimum service price', 'local' ); ?>" maxlength="30">
					</div>

					<div class="form-field margin-bottom-15">
						<input type="number" name="max_price" placeholder="<?php _e( 'Maximum service price', 'local' ); ?>" maxlength="30">
					</div>

					<div class="form-field margin-bottom-15">
						<select name="currency_price">
							<option value="mdl" selected>MDL</option>
							<option value="usd">USD</option>
							<option value="eur">EUR</option>
						</select>
					</div>
				</div>

				<div class="item item-7 left">
					<div class="form-field margin-bottom-15">
						<input type="text" name="profession" placeholder="<?php _e( 'Profession', 'local' ); ?> *" required>
						<input type="hidden" name="profession_term_id">

						<div class="options white-bg card-shadow hidden">
							<div class="exit"></div>

							<?php $args = array(
								'type'         => 'experts',
								'child_of'     => 0,
								'parent'       => 0,
								'orderby'      => 'name',
								'order'        => 'ASC',
								'hide_empty'   => 0,
								'hierarchical' => 1,
								'exclude'      => '',
								'include'      => '',
								'number'       => '',
								'taxonomy'     => 'professions',
								'pad_counts'   => false );

							$categories = get_categories( $args ); ?>

							<ul>
								<?php foreach ( $categories as $category ) {
									echo '<li><a href="' . home_url() . '/professions/' . $category->slug . '" data-term-id="' . $category->term_id . '" class="black-col red-col-hover">' . $category->name . '</a>';

									$inner_cat = $category->term_id;
									$args_in   = array(
										'type'         => 'experts',
										'child_of'     => 0,
										'parent'       => $inner_cat,
										'orderby'      => 'name',
										'order'        => 'ASC',
										'hide_empty'   => 0,
										'hierarchical' => 1,
										'exclude'      => '',
										'include'      => '',
										'number'       => '',
										'taxonomy'     => 'professions',
										'pad_counts'   => false
									);

									$categories_in = get_categories( $args_in );

									if ( !empty( $categories_in ) ) {
										echo '<ul>';

										foreach ( $categories_in as $category_in ) {
											echo '<li>';

											echo '<a href="' . esc_url( home_url() ) . '/professions/' . $category_in->slug . '" data-term-id="' . $category_in->term_id . '" class="blue-col">' . $category_in->name . '</a>';

											echo '</li>';
										}

										echo '</ul>';
									}
									echo '</li>';
								} ?>
							</ul>
						</div>
					</div>

					<div class="expert-professions-form"></div>
				</div>
			</div>
		</div>

		<button type="button" class="btn normal blue-bg white-col blue-light-bg-hover left back hidden" data-counter="1"><?php _e( 'Back', 'local' ); ?></button>
		<button type="button" class="btn normal blue-bg white-col blue-light-bg-hover right next" data-counter="1"><?php _e( 'Next', 'local' ); ?></button>
		<button type="submit" class="btn normal blue-bg white-col blue-light-bg-hover right submit hidden"><?php _e( 'Register', 'local' ); ?></button>

		<div class="response clear text-center"></div>
	</form>
	<?php
	exit();
}

add_action( 'tell_ajax_registration', 'registration' );
add_action( 'tell_ajax_nopriv_registration', 'registration' );
function registration() {
	$all_fields = $_POST[ 'allFields' ];

	function response( $reload, $counter, $string ) {
		$data              = array();
		$data[ 'reload' ]  = $reload;
		$data[ 'counter' ] = $counter;
		if ( 1 == $reload ) {
			$data[ 'string' ] = '<p class="blue-col padding-top-30">' . $string . '</p>';
		} else {
			$data[ 'string' ] = '<p class="red-col padding-top-30">' . $string . '</p>';
		}

		echo json_encode( $data );
	}

	if ( !is_array( $all_fields ) || empty( $all_fields ) ) {
		exit();
	}

	foreach ( $all_fields as $field ) {
		${$field[ 'name' ]} = $field[ 'value' ];
	}

	//Creating new user
	if ( username_exists( $login ) ) {

		response( 0, 2, __( 'A user with this login already exists', 'local' ) );

		exit();
	}

	if ( $password != $repeat_password ) {
		response( 0, 2, __( 'Passwords do not match', 'local' ) );

		exit();
	}

	if ( !is_email( $email ) ) {
		response( 0, 3, __( 'Wrong Email', 'local' ) );

		exit();
	}

	if ( email_exists( $email ) ) {
		response( 0, 3, __( 'A user with this email already exists', 'local' ) );

		exit();
	}

	$user_data = array(
		'first_name' => $first_name,
		'last_name'  => $last_name,
		'user_login' => $login,
		'user_pass'  => $password,
		'user_email' => $email,
		'role'       => 'author'
	);

	$user_id = wp_insert_user( $user_data );

	//Creating new user profile page
	$title = $first_name;
	if ( '' == $middle_name ) {
		$title .= ' ' . $middle_name;
	}
	if ( '' == $last_name ) {
		$title .= ' ' . $last_name;
	}
	$post_args = array(
		'post_type'   => 'experts',
		'post_title'  => $title,
		'post_name'   => $login,
		'post_status' => 'publish',
		'post_date'   => date( 'Y-m-d' ) . ' ' . date( 'H:i' ) . ':00',
		'post_author' => $user_id
	);

	// Create post
	$created_post_id = wp_insert_post( $post_args );

	//Add meta boxes
	update_post_meta( $created_post_id, 'tell_users_id', $user_id );
	update_post_meta( $created_post_id, 'tell_experts_first_name', $first_name );
	update_post_meta( $created_post_id, 'tell_experts_middle_name', $middle_name );
	update_post_meta( $created_post_id, 'tell_experts_last_name', $last_name );
	update_post_meta( $created_post_id, 'tell_experts_birthday_date', $birthday );
	update_post_meta( $created_post_id, 'tell_experts_gender', $gender );
	update_post_meta( $created_post_id, 'tell_experts_contacts_number', $phone );
	update_post_meta( $created_post_id, 'tell_experts_contacts_site', $site );
	update_post_meta( $created_post_id, 'tell_experts_contacts_address', $address );
	update_post_meta( $created_post_id, 'tell_experts_social_google_plus', $google_plus );
	update_post_meta( $created_post_id, 'tell_experts_social_twitter', $twitter );
	update_post_meta( $created_post_id, 'tell_experts_social_facebook', $facebook );
	update_post_meta( $created_post_id, 'tell_experts_social_ok', $ok );
	update_post_meta( $created_post_id, 'tell_experts_social_vk', $vk );
	update_post_meta( $created_post_id, 'tell_experts_social_pinterest', $pinterest );
	update_post_meta( $created_post_id, 'tell_experts_social_instagram', $instagram );
	update_post_meta( $created_post_id, 'tell_experts_social_youtube', $youtube );
	update_post_meta( $created_post_id, 'tell_experts_education_text', $education );
	update_post_meta( $created_post_id, 'tell_experts_work_experience_text', $work_experience );
	update_post_meta( $created_post_id, 'tell_experts_minimal_price', $min_price );
	update_post_meta( $created_post_id, 'tell_experts_maximal_price', $max_price );
	update_post_meta( $created_post_id, 'tell_experts_currency_price', $currency_price );
	update_post_meta( $created_post_id, 'tell_expert_meta', array( 'expert_professions_select' => $profession_term_id ) );

	$category = get_term( $profession_term_id, 'professions' );
	if ( $category ) {
		wp_set_post_terms( $created_post_id, array( $category->parent, $_POST[ 'profession_term_id' ] ), 'professions' );
	} else {
		wp_set_post_terms( $created_post_id, $_POST[ 'profession_term_id' ], 'professions' );
	}

	//Send mail to user
	$message = '<p>' . __( 'Registration completed successfully.', 'local' ) . '</p>';
	$message .= '<p>' . __( 'Login', 'local' ) . ': ' . $login . '</p>';
	$message .= '<p>' . __( 'Password', 'local' ) . ': ' . $password . '</p>';

	//php mailer variables
	$from    = get_option( 'admin_email' );
	$to      = $email;
	$subject = __( 'Email sent from ', 'local' ) . get_bloginfo( 'name' );
	$headers = 'From: ' . $from . ' Reply-To: ' . $from . "\r\n";
	$headers .= "CC: " . $to . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$sent = mail( $to, $subject, $message, $headers );
	if ( !$sent ) {
		response( 0, 3, __( 'Internal error', 'local' ) );

		exit();
	}


	if ( $created_post_id ) {
		response( 1, 7, __( 'Registration completed successfully! Check your email.', 'local' ) );
	}

	exit();
}