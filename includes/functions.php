<?php
//Meta box init
foreach ( glob( dirname( __FILE__ ) . '/metaboxes/*.php' ) as $file ) {
	require_once( $file );
}

/**
 * Get meta
 */
function tell_get_meta( $field_id, $args = array(), $post_id = null ) {
	return rwmb_meta( 'tell_' . $field_id, $args, $post_id );
}

/**
 * Get Option
 */
function tell_get_option( $field_id, $included_parameter = null ) {
	global $theme_options;
	if ( isset( $theme_options[ $field_id ] ) && !empty( $theme_options[ $field_id ] ) ) {
		if ( !empty( $field_id ) && $included_parameter != null ) {
			return $theme_options[ $field_id ][ $included_parameter ];
		} else {
			return $theme_options[ $field_id ];
		}
	}
}


/*
 * Add theme support thumbnail
 */
add_theme_support( 'post-thumbnails' );

/*
 * TGM Script code
 */
add_action( 'tgmpa_register', 'tell_theme_register_required_plugins' );
function tell_theme_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'Shortcodes Ultimate',
			'slug'     => 'shortcodes-ultimate',
			'required' => false,
		),
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
		array(
			'name'     => 'BuddyPress',
			'slug'     => 'buddypress',
			'required' => false,
		),
		array(
			'name'     => 'bbPress',
			'slug'     => 'bbpress',
			'required' => false,
		),
	);
	$config  = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

/*
 * Share
 */
function tell_get_share( $type = 'fb', $permalink = false, $title = false, $content = false, $image = false ) {
	global $post;
	if ( !$permalink ) {
		$permalink = get_permalink();
	}
	if ( !$title ) {
		$title = esc_attr( get_the_title() );
	}
	if ( !$content ) {
		$content = esc_attr( strip_tags( tell_trim_excerpt( 40 ) ) );
	}
	if ( has_post_thumbnail( $post->ID ) ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		$image = $thumb[ '0' ] . '?';
	} else {
		$image = '';
	}
	switch ( $type ) {
		case 'fb':
			return esc_url( 'http://www.facebook.com/sharer/sharer.php?u=' . $permalink . '&title=' . $title . '&description=' . $content . '&image=' . $image );
			break;
		case 'twi':
			return esc_url( 'http://twitter.com/share?url=' . $permalink . '&title=' . $title . '&description=' . $content . '&image=' . $image );
			break;
		case 'goglp':
			return esc_url( 'https://plus.google.com/share?url=' . $permalink . '&title=' . $title . '&description=' . $content . '&image=' . $image );
			break;
		case 'ok':
			return esc_url( 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' . $permalink );
			break;
		case 'pin':
			return esc_url( 'http://pinterest.com/pin/create/button/?url=' . $permalink . '&media=' . $image . "&description=" . $content );
			break;
		case 'vk':
			return esc_url( 'http://vkontakte.ru/share.php?url=' . $permalink . '&title=' . $title . '&image=' . $image . "&description=" . $content );
			break;
		case 'ln':
			return esc_url( 'https://www.linkedin.com/shareArticle?mini=true&url=' . $permalink . '&title=' . $title . '&summary=' . $content . '&source=' . $permalink );
			break;
		case 'pn':
			return esc_url( 'http://pinterest.com/pin/create/button/?url=' . $permalink . '&media=' . $image . '&description=' . $title );
			break;
		default:
			return '';
	}
}

/*
 *Excerpt the content
 */
function tell_trim_excerpt( $length ) {
	global $post;
	$explicit_excerpt = $post->post_excerpt;
	if ( '' == $explicit_excerpt ) {
		$text = get_the_content( '' );
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]>', $text );
	} else {
		$text = apply_filters( 'the_content', $explicit_excerpt );
	}
	$text           = strip_shortcodes( $text ); // optional
	$text           = strip_tags( $text );
	$excerpt_length = $length;
	$words          = explode( ' ', $text, $excerpt_length + 1 );
	if ( count( $words ) > $excerpt_length ) {
		array_pop( $words );
		array_push( $words, '' );
		$words[] = '...';
		$text    = implode( ' ', $words );
		$text    = apply_filters( 'the_excerpt', $text );
	}

	return $text;
}

/*
 * Image resize
 */
function tell_get_image( $url, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	//Lazy load attributes
	$lazy_load_attributes = 'data-original';
	if ( 'not_use' == tell_get_option( 'opt-lazy-load-init' ) ) {
		$lazy_load_attributes = 'src';
	}

	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( '' == $image_size ) {
			$image_size = $url;
		}
		if ( false == $crop ) {
			$base_image_size = getimagesize( $image_size );
			if ( false == $upscale ) {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '"  alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			} else {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			}
		} else {
			$base_image_size = getimagesize( $image_size );
			if ( false == $upscale ) {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			} else {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			}
		}
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="">';
		}
	}
}

function tell_get_image_src( $url, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( '' == $image_size ) {
			$image_size = $url;
		}

		return $image_size;
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return $image_size;
		}
	}
}

function tell_get_post_image( $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	global $post;

	//Lazy load attributes
	$lazy_load_attributes = 'data-original';
	if ( 'not_use' == tell_get_option( 'opt-lazy-load-init' ) ) {
		$lazy_load_attributes = 'src';
	}

	$image_id   = get_post_thumbnail_id( $post->ID );
	$url        = wp_get_attachment_url( $image_id );
	$img_srcset = wp_get_attachment_image_srcset( $image_id );
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( false == $upscale ) {
			$image_size = $url;
		}
		if ( '' == $image_size ) {
			$image_size = $url;
		}
		if ( false == $crop ) {
			$base_image_size = getimagesize( $image_size );
			if ( false == $upscale ) {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			} else {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			}
		} else {
			$base_image_size = getimagesize( $image_size );
			if ( false == $upscale ) {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			} else {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			}
		}
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
		}
	}
	exit();
}

function tell_get_post_image_by_post_id( $post_id, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	global $post;

	//Lazy load attributes
	$lazy_load_attributes = 'data-original';
	if ( 'not_use' == tell_get_option( 'opt-lazy-load-init' ) ) {
		$lazy_load_attributes = 'src';
	}

	$image_id   = get_post_thumbnail_id( $post_id );
	$url        = wp_get_attachment_url( $image_id );
	$img_srcset = wp_get_attachment_image_srcset( $image_id );
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( false == $upscale ) {
			$image_size = $url;
		}
		if ( '' == $image_size ) {
			$image_size = $url;
		}
		if ( false == $crop ) {
			$base_image_size = getimagesize( $image_size );
			if ( false == $upscale ) {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '"  alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			} else {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			}
		} else {
			$base_image_size = getimagesize( $image_size );
			if ( false == $upscale ) {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			} else {
				return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
			}
		}
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
		}
	}
}

function tell_get_post_image_src( $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	global $post;
	$image_id = get_post_thumbnail_id( $post->ID );
	$url      = wp_get_attachment_url( $image_id );
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( '' == $image_size ) {
			$image_size = $url;
		}

		return $image_size;
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return $image_size;
		}
	}
}

function tell_get_attachment_image( $attachment_id = null, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	//Lazy load attributes
	$lazy_load_attributes = 'data-original';
	if ( 'not_use' == tell_get_option( 'opt-lazy-load-init' ) ) {
		$lazy_load_attributes = 'src';
	}

	$url = wp_get_attachment_url( $attachment_id );
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( '' == $image_size ) {
			$image_size = $url;
		}
		if ( false == $crop ) {
			$base_image_size = getimagesize( $image_size );

			return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $base_image_size[ 0 ] . '" height="' . $base_image_size[ 1 ] . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
		} else {
			return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
		}
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return '<img ' . $lazy_load_attributes . '="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" title="' . get_the_title() . '">';
		}
	}
}

function tell_get_attachment_src( $attachment_id = null, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	$url = wp_get_attachment_url( $attachment_id );
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( '' == $image_size ) {
			$image_size = $url;
		}
		$image_size = esc_url( $image_size );

		return $image_size;
	} else {
		$url = tell_get_option( 'opt-thumbnail' );
		if ( isset( $url[ 'url' ] ) ) {
			$image_size = aq_resize( $url[ 'url' ], $width, $height, $crop, $single, $upscale );

			return $image_size;
		}
	}
}

function tell_get_attachment_image_dir( $attachment_id = null, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	$url = wp_get_attachment_url( $attachment_id );
	if ( !empty( $url ) ) {
		$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
		if ( '' == $image_size ) {
			$image_size = $url;
		}

		$path = parse_url( $image_size, PHP_URL_PATH );

		return $_SERVER[ 'DOCUMENT_ROOT' ] . $path;
	} else {
		return;
	}
}

function tell_get_post_thumbnail( $post_id, $image_size ) {
	if ( get_the_post_thumbnail( $post_id, $image_size ) ) {
		return get_the_post_thumbnail( $post_id, $image_size );
	}
}

/*
 * Get menu list
 */
function tell_get_menu_list() {
	$menus       = wp_get_nav_menus( array( 'orderby' => 'name' ) );
	$option_menu = array();
	foreach ( $menus as $menu ) {
		$option_menu[ $menu->term_id ] = $menu->name;
	}

	return $option_menu;
}

//Get add number of views
function tell_views_update( $meta_box_id = 'post_views', $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	$old_value = tell_get_meta( $meta_box_id );
	$new_value = $old_value + 1;
	update_post_meta( $post_id, 'tell_' . $meta_box_id, $new_value, $old_value );
}

//Font awesome icons
function icons() {
	$icons = array(
		"3d_rotation"                                 => "3d_rotation",
		"access_alarm"                                => "access_alarm",
		"access_alarms"                               => "access_alarms",
		"access_time"                                 => "access_time",
		"accessibility"                               => "accessibility",
		"account_balance"                             => "account_balance",
		"account_balance_wallet"                      => "account_balance_wallet",
		"account_box"                                 => "account_box",
		"account_circle"                              => "account_circle",
		"adb"                                         => "adb",
		"add"                                         => "add",
		"add_alarm"                                   => "add_alarm",
		"add_alert"                                   => "add_alert",
		"add_box"                                     => "add_box",
		"add_circle"                                  => "add_circle",
		"add_circle_outline"                          => "add_circle_outline",
		"add_shopping_cart"                           => "add_shopping_cart",
		"add_to_photos"                               => "add_to_photos",
		"adjust"                                      => "adjust",
		"airline_seat_flat"                           => "airline_seat_flat",
		"airline_seat_flat_angled"                    => "airline_seat_flat_angled",
		"airline_seat_individual_suite"               => "airline_seat_individual_suite",
		"airline_seat_legroom_extra"                  => "airline_seat_legroom_extra",
		"airline_seat_legroom_normal"                 => "airline_seat_legroom_normal",
		"airline_seat_legroom_reduced"                => "airline_seat_legroom_reduced",
		"airline_seat_recline_extra"                  => "airline_seat_recline_extra",
		"airline_seat_recline_normal"                 => "airline_seat_recline_normal",
		"airplanemode_active"                         => "airplanemode_active",
		"airplanemode_inactive"                       => "airplanemode_inactive",
		"airplay"                                     => "airplay",
		"alarm"                                       => "alarm",
		"alarm_add"                                   => "alarm_add",
		"alarm_off"                                   => "alarm_off",
		"alarm_on"                                    => "alarm_on",
		"album"                                       => "album",
		"android"                                     => "android",
		"announcement"                                => "announcement",
		"apps"                                        => "apps",
		"archive"                                     => "archive",
		"arrow_back"                                  => "arrow_back",
		"arrow_drop_down"                             => "arrow_drop_down",
		"arrow_drop_down_circle"                      => "arrow_drop_down_circle",
		"arrow_drop_up"                               => "arrow_drop_up",
		"arrow_forward"                               => "arrow_forward",
		"aspect_ratio"                                => "aspect_ratio",
		"assessment"                                  => "assessment",
		"assignment"                                  => "assignment",
		"assignment_ind"                              => "assignment_ind",
		"assignment_late"                             => "assignment_late",
		"assignment_return"                           => "assignment_return",
		"assignment_returned"                         => "assignment_returned",
		"assignment_turned_in"                        => "assignment_turned_in",
		"assistant"                                   => "assistant",
		"assistant_photo"                             => "assistant_photo",
		"attach_file"                                 => "attach_file",
		"attach_money"                                => "attach_money",
		"attachment"                                  => "attachment",
		"audiotrack"                                  => "audiotrack",
		"autorenew"                                   => "autorenew",
		"av_timer"                                    => "av_timer",
		"backspace"                                   => "backspace",
		"backup"                                      => "backup",
		"battery_alert"                               => "battery_alert",
		"battery_charging_full"                       => "battery_charging_full",
		"battery_full"                                => "battery_full",
		"battery_std"                                 => "battery_std",
		"battery_unknown"                             => "battery_unknown",
		"beenhere"                                    => "beenhere",
		"block"                                       => "block",
		"bluetooth"                                   => "bluetooth",
		"bluetooth_audio"                             => "bluetooth_audio",
		"bluetooth_connected"                         => "bluetooth_connected",
		"bluetooth_disabled"                          => "bluetooth_disabled",
		"bluetooth_searching"                         => "bluetooth_searching",
		"blur_circular"                               => "blur_circular",
		"blur_linear"                                 => "blur_linear",
		"blur_off"                                    => "blur_off",
		"blur_on"                                     => "blur_on",
		"book"                                        => "book",
		"bookmark"                                    => "bookmark",
		"bookmark_border"                             => "bookmark_border",
		"border_all"                                  => "border_all",
		"border_bottom"                               => "border_bottom",
		"border_clear"                                => "border_clear",
		"border_color"                                => "border_color",
		"border_horizontal"                           => "border_horizontal",
		"border_inner"                                => "border_inner",
		"border_left"                                 => "border_left",
		"border_outer"                                => "border_outer",
		"border_right"                                => "border_right",
		"border_style"                                => "border_style",
		"border_top"                                  => "border_top",
		"border_vertical"                             => "border_vertical",
		"brightness_1"                                => "brightness_1",
		"brightness_2"                                => "brightness_2",
		"brightness_3"                                => "brightness_3",
		"brightness_4"                                => "brightness_4",
		"brightness_5"                                => "brightness_5",
		"brightness_6"                                => "brightness_6",
		"brightness_7"                                => "brightness_7",
		"brightness_auto"                             => "brightness_auto",
		"brightness_high"                             => "brightness_high",
		"brightness_low"                              => "brightness_low",
		"brightness_medium"                           => "brightness_medium",
		"broken_image"                                => "broken_image",
		"brush"                                       => "brush",
		"bug_report"                                  => "bug_report",
		"build"                                       => "build",
		"business"                                    => "business",
		"cached"                                      => "cached",
		"cake"                                        => "cake",
		"call"                                        => "call",
		"call_end"                                    => "call_end",
		"call_made"                                   => "call_made",
		"call_merge"                                  => "call_merge",
		"call_missed"                                 => "call_missed",
		"call_received"                               => "call_received",
		"call_split"                                  => "call_split",
		"camera"                                      => "camera",
		"camera_alt"                                  => "camera_alt",
		"camera_enhance"                              => "camera_enhance",
		"camera_front"                                => "camera_front",
		"camera_rear"                                 => "camera_rear",
		"camera_roll"                                 => "camera_roll",
		"cancel"                                      => "cancel",
		"card_giftcard"                               => "card_giftcard",
		"card_membership"                             => "card_membership",
		"card_travel"                                 => "card_travel",
		"cast"                                        => "cast",
		"cast_connected"                              => "cast_connected",
		"center_focus_strong"                         => "center_focus_strong",
		"center_focus_weak"                           => "center_focus_weak",
		"change_history"                              => "change_history",
		"chat"                                        => "chat",
		"chat_bubble"                                 => "chat_bubble",
		"chat_bubble_outline"                         => "chat_bubble_outline",
		"check"                                       => "check",
		"check_box"                                   => "check_box",
		"check_box_outline_blank"                     => "check_box_outline_blank",
		"check_circle"                                => "check_circle",
		"chevron_left"                                => "chevron_left",
		"chevron_right"                               => "chevron_right",
		"chrome_reader_mode"                          => "chrome_reader_mode",
		"class"                                       => "class",
		"clear"                                       => "clear",
		"clear_all"                                   => "clear_all",
		"close"                                       => "close",
		"closed_caption"                              => "closed_caption",
		"cloud"                                       => "cloud",
		"cloud_circle"                                => "cloud_circle",
		"cloud_done"                                  => "cloud_done",
		"cloud_download"                              => "cloud_download",
		"cloud_off"                                   => "cloud_off",
		"cloud_queue"                                 => "cloud_queue",
		"cloud_upload"                                => "cloud_upload",
		"code"                                        => "code",
		"collections"                                 => "collections",
		"collections_bookmark"                        => "collections_bookmark",
		"color_lens"                                  => "color_lens",
		"colorize"                                    => "colorize",
		"comment"                                     => "comment",
		"compare"                                     => "compare",
		"computer"                                    => "computer",
		"confirmation_number"                         => "confirmation_number",
		"contact_phone"                               => "contact_phone",
		"contacts"                                    => "contacts",
		"content_copy"                                => "content_copy",
		"content_cut"                                 => "content_cut",
		"content_paste"                               => "content_paste",
		"control_point"                               => "control_point",
		"control_point_duplicate"                     => "control_point_duplicate",
		"create"                                      => "create",
		"credit_card"                                 => "credit_card",
		"crop"                                        => "crop",
		"crop_16_9"                                   => "crop_16_9",
		"crop_3_2"                                    => "crop_3_2",
		"crop_5_4"                                    => "crop_5_4",
		"crop_7_5"                                    => "crop_7_5",
		"crop_din"                                    => "crop_din",
		"crop_free"                                   => "crop_free",
		"crop_landscape"                              => "crop_landscape",
		"crop_original"                               => "crop_original",
		"crop_portrait"                               => "crop_portrait",
		"crop_square"                                 => "crop_square",
		"dashboard"                                   => "dashboard",
		"data_usage"                                  => "data_usage",
		"dehaze"                                      => "dehaze",
		"delete"                                      => "delete",
		"description"                                 => "description",
		"desktop_mac"                                 => "desktop_mac",
		"desktop_windows"                             => "desktop_windows",
		"details"                                     => "details",
		"developer_board"                             => "developer_board",
		"developer_mode"                              => "developer_mode",
		"device_hub"                                  => "device_hub",
		"devices"                                     => "devices",
		"dialer_sip"                                  => "dialer_sip",
		"dialpad"                                     => "dialpad",
		"directions"                                  => "directions",
		"directions_bike"                             => "directions_bike",
		"directions_boat"                             => "directions_boat",
		"directions_bus"                              => "directions_bus",
		"directions_car"                              => "directions_car",
		"directions_railway"                          => "directions_railway",
		"directions_run"                              => "directions_run",
		"directions_subway"                           => "directions_subway",
		"directions_transit"                          => "directions_transit",
		"directions_walk"                             => "directions_walk",
		"disc_full"                                   => "disc_full",
		"dns"                                         => "dns",
		"do_not_disturb"                              => "do_not_disturb",
		"do_not_disturb_alt"                          => "do_not_disturb_alt",
		"dock"                                        => "dock",
		"domain"                                      => "domain",
		"done"                                        => "done",
		"done_all"                                    => "done_all",
		"drafts"                                      => "drafts",
		"drive_eta"                                   => "drive_eta",
		"dvr"                                         => "dvr",
		"edit"                                        => "edit",
		"eject"                                       => "eject",
		"email"                                       => "email",
		"equalizer"                                   => "equalizer",
		"error"                                       => "error",
		"error_outline"                               => "error_outline",
		"event"                                       => "event",
		"event_available"                             => "event_available",
		"event_busy"                                  => "event_busy",
		"event_note"                                  => "event_note",
		"event_seat"                                  => "event_seat",
		"exit_to_app"                                 => "exit_to_app",
		"expand_less"                                 => "expand_less",
		"expand_more"                                 => "expand_more",
		"explicit"                                    => "explicit",
		"explore"                                     => "explore",
		"exposure"                                    => "exposure",
		"exposure_neg_1"                              => "exposure_neg_1",
		"exposure_neg_2"                              => "exposure_neg_2",
		"exposure_plus_1"                             => "exposure_plus_1",
		"exposure_plus_2"                             => "exposure_plus_2",
		"exposure_zero"                               => "exposure_zero",
		"extension"                                   => "extension",
		"face"                                        => "face",
		"fast_forward"                                => "fast_forward",
		"fast_rewind"                                 => "fast_rewind",
		"favorite"                                    => "favorite",
		"favorite_border"                             => "favorite_border",
		"feedback"                                    => "feedback",
		"file_download"                               => "file_download",
		"file_upload"                                 => "file_upload",
		"filter"                                      => "filter",
		"filter_1"                                    => "filter_1",
		"filter_2"                                    => "filter_2",
		"filter_3"                                    => "filter_3",
		"filter_4"                                    => "filter_4",
		"filter_5"                                    => "filter_5",
		"filter_6"                                    => "filter_6",
		"filter_7"                                    => "filter_7",
		"filter_8"                                    => "filter_8",
		"filter_9"                                    => "filter_9",
		"filter_9_plus"                               => "filter_9_plus",
		"filter_b_and_w"                              => "filter_b_and_w",
		"filter_center_focus"                         => "filter_center_focus",
		"filter_drama"                                => "filter_drama",
		"filter_frames"                               => "filter_frames",
		"filter_hdr"                                  => "filter_hdr",
		"filter_list"                                 => "filter_list",
		"filter_none"                                 => "filter_none",
		"filter_tilt_shift"                           => "filter_tilt_shift",
		"filter_vintage"                              => "filter_vintage",
		"find_in_page"                                => "find_in_page",
		"find_replace"                                => "find_replace",
		"flag"                                        => "flag",
		"flare"                                       => "flare",
		"flash_auto"                                  => "flash_auto",
		"flash_off"                                   => "flash_off",
		"flash_on"                                    => "flash_on",
		"flight"                                      => "flight",
		"flight_land"                                 => "flight_land",
		"flight_takeoff"                              => "flight_takeoff",
		"flip"                                        => "flip",
		"flip_to_back"                                => "flip_to_back",
		"flip_to_front"                               => "flip_to_front",
		"folder"                                      => "folder",
		"folder_open"                                 => "folder_open",
		"folder_shared"                               => "folder_shared",
		"folder_special"                              => "folder_special",
		"font_download"                               => "font_download",
		"format_align_center"                         => "format_align_center",
		"format_align_justify"                        => "format_align_justify",
		"format_align_left"                           => "format_align_left",
		"format_align_right"                          => "format_align_right",
		"format_bold"                                 => "format_bold",
		"format_clear"                                => "format_clear",
		"format_color_fill"                           => "format_color_fill",
		"format_color_reset"                          => "format_color_reset",
		"format_color_text"                           => "format_color_text",
		"format_indent_decrease"                      => "format_indent_decrease",
		"format_indent_increase"                      => "format_indent_increase",
		"format_italic"                               => "format_italic",
		"format_line_spacing"                         => "format_line_spacing",
		"format_list_bulleted"                        => "format_list_bulleted",
		"format_list_numbered"                        => "format_list_numbered",
		"format_paint"                                => "format_paint",
		"format_quote"                                => "format_quote",
		"format_size"                                 => "format_size",
		"format_strikethrough"                        => "format_strikethrough",
		"format_textdirection_l_to_r"                 => "format_textdirection_l_to_r",
		"format_textdirection_r_to_l"                 => "format_textdirection_r_to_l",
		"format_underlined"                           => "format_underlined",
		"forum"                                       => "forum",
		"forward"                                     => "forward",
		"forward_10"                                  => "forward_10",
		"forward_30"                                  => "forward_30",
		"forward_5"                                   => "forward_5",
		"fullscreen"                                  => "fullscreen",
		"fullscreen_exit"                             => "fullscreen_exit",
		"functions"                                   => "functions",
		"gamepad"                                     => "gamepad",
		"games"                                       => "games",
		"gesture"                                     => "gesture",
		"get_app"                                     => "get_app",
		"gif"                                         => "gif",
		"gps_fixed"                                   => "gps_fixed",
		"gps_not_fixed"                               => "gps_not_fixed",
		"gps_off"                                     => "gps_off",
		"grade"                                       => "grade",
		"gradient"                                    => "gradient",
		"grain"                                       => "grain",
		"graphic_eq"                                  => "graphic_eq",
		"grid_off"                                    => "grid_off",
		"grid_on"                                     => "grid_on",
		"group"                                       => "group",
		"group_add"                                   => "group_add",
		"group_work"                                  => "group_work",
		"hd"                                          => "hd",
		"hdr_off"                                     => "hdr_off",
		"hdr_on"                                      => "hdr_on",
		"hdr_strong"                                  => "hdr_strong",
		"hdr_weak"                                    => "hdr_weak",
		"headset"                                     => "headset",
		"headset_mic"                                 => "headset_mic",
		"healing"                                     => "healing",
		"hearing"                                     => "hearing",
		"help"                                        => "help",
		"help_outline"                                => "help_outline",
		"high_quality"                                => "high_quality",
		"highlight_off"                               => "highlight_off",
		"history"                                     => "history",
		"home"                                        => "home",
		"hotel"                                       => "hotel",
		"hourglass_empty"                             => "hourglass_empty",
		"hourglass_full"                              => "hourglass_full",
		"http"                                        => "http",
		"https"                                       => "https",
		"image"                                       => "image",
		"image_aspect_ratio"                          => "image_aspect_ratio",
		"import_export"                               => "import_export",
		"inbox"                                       => "inbox",
		"indeterminate_check_box"                     => "indeterminate_check_box",
		"info"                                        => "info",
		"info_outline"                                => "info_outline",
		"input"                                       => "input",
		"insert_chart"                                => "insert_chart",
		"insert_comment"                              => "insert_comment",
		"insert_drive_file"                           => "insert_drive_file",
		"insert_emoticon"                             => "insert_emoticon",
		"insert_invitation"                           => "insert_invitation",
		"insert_link"                                 => "insert_link",
		"insert_photo"                                => "insert_photo",
		"invert_colors"                               => "invert_colors",
		"invert_colors_off"                           => "invert_colors_off",
		"iso"                                         => "iso",
		"keyboard"                                    => "keyboard",
		"keyboard_arrow_down"                         => "keyboard_arrow_down",
		"keyboard_arrow_left"                         => "keyboard_arrow_left",
		"keyboard_arrow_right"                        => "keyboard_arrow_right",
		"keyboard_arrow_up"                           => "keyboard_arrow_up",
		"keyboard_backspace"                          => "keyboard_backspace",
		"keyboard_capslock"                           => "keyboard_capslock",
		"keyboard_hide"                               => "keyboard_hide",
		"keyboard_return"                             => "keyboard_return",
		"keyboard_tab"                                => "keyboard_tab",
		"keyboard_voice"                              => "keyboard_voice",
		"label"                                       => "label",
		"label_outline"                               => "label_outline",
		"landscape"                                   => "landscape",
		"language"                                    => "language",
		"laptop"                                      => "laptop",
		"laptop_chromebook"                           => "laptop_chromebook",
		"laptop_mac"                                  => "laptop_mac",
		"laptop_windows"                              => "laptop_windows",
		"launch"                                      => "launch",
		"layers"                                      => "layers",
		"layers_clear"                                => "layers_clear",
		"leak_add"                                    => "leak_add",
		"leak_remove"                                 => "leak_remove",
		"lens"                                        => "lens",
		"library_add"                                 => "library_add",
		"library_books"                               => "library_books",
		"library_music"                               => "library_music",
		"link"                                        => "link",
		"list"                                        => "list",
		"live_help"                                   => "live_help",
		"live_tv"                                     => "live_tv",
		"local_activity"                              => "local_activity",
		"local_airport"                               => "local_airport",
		"local_atm"                                   => "local_atm",
		"local_bar"                                   => "local_bar",
		"local_cafe"                                  => "local_cafe",
		"local_car_wash"                              => "local_car_wash",
		"local_convenience_store"                     => "local_convenience_store",
		"local_dining"                                => "local_dining",
		"local_drink"                                 => "local_drink",
		"local_florist"                               => "local_florist",
		"local_gas_station"                           => "local_gas_station",
		"local_grocery_store"                         => "local_grocery_store",
		"local_hospital"                              => "local_hospital",
		"local_hotel"                                 => "local_hotel",
		"local_laundry_service"                       => "local_laundry_service",
		"local_library"                               => "local_library",
		"local_mall"                                  => "local_mall",
		"local_movies"                                => "local_movies",
		"local_offer"                                 => "local_offer",
		"local_parking"                               => "local_parking",
		"local_pharmacy"                              => "local_pharmacy",
		"local_phone"                                 => "local_phone",
		"local_pizza"                                 => "local_pizza",
		"local_play"                                  => "local_play",
		"local_post_office"                           => "local_post_office",
		"local_printshop"                             => "local_printshop",
		"local_see"                                   => "local_see",
		"local_shipping"                              => "local_shipping",
		"local_taxi"                                  => "local_taxi",
		"location_city"                               => "location_city",
		"location_disabled"                           => "location_disabled",
		"location_off"                                => "location_off",
		"location_on"                                 => "location_on",
		"location_searching"                          => "location_searching",
		"lock"                                        => "lock",
		"lock_open"                                   => "lock_open",
		"lock_outline"                                => "lock_outline",
		"looks"                                       => "looks",
		"looks_3"                                     => "looks_3",
		"looks_4"                                     => "looks_4",
		"looks_5"                                     => "looks_5",
		"looks_6"                                     => "looks_6",
		"looks_one"                                   => "looks_one",
		"looks_two"                                   => "looks_two",
		"loop"                                        => "loop",
		"loupe"                                       => "loupe",
		"loyalty"                                     => "loyalty",
		"mail"                                        => "mail",
		"map"                                         => "map",
		"markunread"                                  => "markunread",
		"markunread_mailbox"                          => "markunread_mailbox",
		"memory"                                      => "memory",
		"menu"                                        => "menu",
		"merge_type"                                  => "merge_type",
		"message"                                     => "message",
		"mic"                                         => "mic",
		"mic_none"                                    => "mic_none",
		"mic_off"                                     => "mic_off",
		"mms"                                         => "mms",
		"mode_comment"                                => "mode_comment",
		"mode_edit"                                   => "mode_edit",
		"money_off"                                   => "money_off",
		"monochrome_photos"                           => "monochrome_photos",
		"mood"                                        => "mood",
		"mood_bad"                                    => "mood_bad",
		"more"                                        => "more",
		"more_horiz"                                  => "more_horiz",
		"more_vert"                                   => "more_vert",
		"mouse"                                       => "mouse",
		"movie"                                       => "movie",
		"movie_creation"                              => "movie_creation",
		"music_note"                                  => "music_note",
		"my_location"                                 => "my_location",
		"nature"                                      => "nature",
		"nature_people"                               => "nature_people",
		"navigate_before"                             => "navigate_before",
		"navigate_next"                               => "navigate_next",
		"navigation"                                  => "navigation",
		"network_cell"                                => "network_cell",
		"network_locked"                              => "network_locked",
		"network_wifi"                                => "network_wifi",
		"new_releases"                                => "new_releases",
		"nfc"                                         => "nfc",
		"no_sim"                                      => "no_sim",
		"not_interested"                              => "not_interested",
		"note_add"                                    => "note_add",
		"notifications"                               => "notifications",
		"notifications_active"                        => "notifications_active",
		"notifications_none"                          => "notifications_none",
		"notifications_off"                           => "notifications_off",
		"notifications_paused"                        => "notifications_paused",
		"offline_pin"                                 => "offline_pin",
		"ondemand_video"                              => "ondemand_video",
		"open_in_browser"                             => "open_in_browser",
		"open_in_new"                                 => "open_in_new",
		"open_with"                                   => "open_with",
		"pages"                                       => "pages",
		"pageview"                                    => "pageview",
		"palette"                                     => "palette",
		"panorama"                                    => "panorama",
		"panorama_fish_eye"                           => "panorama_fish_eye",
		"panorama_horizontal"                         => "panorama_horizontal",
		"panorama_vertical"                           => "panorama_vertical",
		"panorama_wide_angle"                         => "panorama_wide_angle",
		"party_mode"                                  => "party_mode",
		"pause"                                       => "pause",
		"pause_circle_filled"                         => "pause_circle_filled",
		"pause_circle_outline"                        => "pause_circle_outline",
		"payment"                                     => "payment",
		"people"                                      => "people",
		"people_outline"                              => "people_outline",
		"perm_camera_mic"                             => "perm_camera_mic",
		"perm_contact_calendar"                       => "perm_contact_calendar",
		"perm_data_setting"                           => "perm_data_setting",
		"perm_device_information"                     => "perm_device_information",
		"perm_identity"                               => "perm_identity",
		"perm_media"                                  => "perm_media",
		"perm_phone_msg"                              => "perm_phone_msg",
		"perm_scan_wifi"                              => "perm_scan_wifi",
		"person"                                      => "person",
		"person_add"                                  => "person_add",
		"person_outline"                              => "person_outline",
		"person_pin"                                  => "person_pin",
		"personal_video"                              => "personal_video",
		"phone"                                       => "phone",
		"phone_android"                               => "phone_android",
		"phone_bluetooth_speaker"                     => "phone_bluetooth_speaker",
		"phone_forwarded"                             => "phone_forwarded",
		"phone_in_talk"                               => "phone_in_talk",
		"phone_iphone"                                => "phone_iphone",
		"phone_locked"                                => "phone_locked",
		"phone_missed"                                => "phone_missed",
		"phone_paused"                                => "phone_paused",
		"phonelink"                                   => "phonelink",
		"phonelink_erase"                             => "phonelink_erase",
		"phonelink_lock"                              => "phonelink_lock",
		"phonelink_off"                               => "phonelink_off",
		"phonelink_ring"                              => "phonelink_ring",
		"phonelink_setup"                             => "phonelink_setup",
		"photo"                                       => "photo",
		"photo_album"                                 => "photo_album",
		"photo_camera"                                => "photo_camera",
		"photo_library"                               => "photo_library",
		"photo_size_select_actual"                    => "photo_size_select_actual",
		"photo_size_select_large"                     => "photo_size_select_large",
		"photo_size_select_small"                     => "photo_size_select_small",
		"picture_as_pdf"                              => "picture_as_pdf",
		"picture_in_picture"                          => "picture_in_picture",
		"pin_drop"                                    => "pin_drop",
		"place"                                       => "place",
		"play_arrow"                                  => "play_arrow",
		"play_circle_filled"                          => "play_circle_filled",
		"play_circle_outline"                         => "play_circle_outline",
		"play_for_work"                               => "play_for_work",
		"playlist_add"                                => "playlist_add",
		"plus_one"                                    => "plus_one",
		"poll"                                        => "poll",
		"polymer"                                     => "polymer",
		"portable_wifi_off"                           => "portable_wifi_off",
		"portrait"                                    => "portrait",
		"power"                                       => "power",
		"power_input"                                 => "power_input",
		"power_settings_new"                          => "power_settings_new",
		"present_to_all"                              => "present_to_all",
		"print"                                       => "print",
		"public"                                      => "public",
		"publish"                                     => "publish",
		"query_builder"                               => "query_builder",
		"question_answer"                             => "question_answer",
		"queue"                                       => "queue",
		"queue_music"                                 => "queue_music",
		"radio"                                       => "radio",
		"radio_button_checked"                        => "radio_button_checked",
		"radio_button_unchecked"                      => "radio_button_unchecked",
		"rate_review"                                 => "rate_review",
		"receipt"                                     => "receipt",
		"recent_actors"                               => "recent_actors",
		"redeem"                                      => "redeem",
		"redo"                                        => "redo",
		"refresh"                                     => "refresh",
		"remove"                                      => "remove",
		"remove_circle"                               => "remove_circle",
		"remove_circle_outline"                       => "remove_circle_outline",
		"remove_red_eye"                              => "remove_red_eye",
		"reorder"                                     => "reorder",
		"repeat"                                      => "repeat",
		"repeat_one"                                  => "repeat_one",
		"replay"                                      => "replay",
		"replay_10"                                   => "replay_10",
		"replay_30"                                   => "replay_30",
		"replay_5"                                    => "replay_5",
		"reply"                                       => "reply",
		"reply_all"                                   => "reply_all",
		"report"                                      => "report",
		"report_problem"                              => "report_problem",
		"restaurant_menu"                             => "restaurant_menu",
		"restore"                                     => "restore",
		"ring_volume"                                 => "ring_volume",
		"room"                                        => "room",
		"rotate_90_degrees_ccw"                       => "rotate_90_degrees_ccw",
		"rotate_left"                                 => "rotate_left",
		"rotate_right"                                => "rotate_right",
		"router"                                      => "router",
		"satellite"                                   => "satellite",
		"save"                                        => "save",
		"scanner"                                     => "scanner",
		"schedule"                                    => "schedule",
		"school"                                      => "school",
		"screen_lock_landscape"                       => "screen_lock_landscape",
		"screen_lock_portrait"                        => "screen_lock_portrait",
		"screen_lock_rotation"                        => "screen_lock_rotation",
		"screen_rotation"                             => "screen_rotation",
		"sd_card"                                     => "sd_card",
		"sd_storage"                                  => "sd_storage",
		"search"                                      => "search",
		"security"                                    => "security",
		"select_all"                                  => "select_all",
		"send"                                        => "send",
		"settings"                                    => "settings",
		"settings_applications"                       => "settings_applications",
		"settings_backup_restore"                     => "settings_backup_restore",
		"settings_bluetooth"                          => "settings_bluetooth",
		"settings_brightness"                         => "settings_brightness",
		"settings_cell"                               => "settings_cell",
		"settings_ethernet"                           => "settings_ethernet",
		"settings_input_antenna"                      => "settings_input_antenna",
		"settings_input_component"                    => "settings_input_component",
		"settings_input_composite"                    => "settings_input_composite",
		"settings_input_hdmi"                         => "settings_input_hdmi",
		"settings_input_svideo"                       => "settings_input_svideo",
		"settings_overscan"                           => "settings_overscan",
		"settings_phone"                              => "settings_phone",
		"settings_power"                              => "settings_power",
		"settings_remote"                             => "settings_remote",
		"settings_system_daydream"                    => "settings_system_daydream",
		"settings_voice"                              => "settings_voice",
		"share"                                       => "share",
		"shop"                                        => "shop",
		"shop_two"                                    => "shop_two",
		"shopping_basket"                             => "shopping_basket",
		"shopping_cart"                               => "shopping_cart",
		"shuffle"                                     => "shuffle",
		"signal_cellular_4_bar"                       => "signal_cellular_4_bar",
		"signal_cellular_connected_no_internet_4_bar" => "signal_cellular_connected_no_internet_4_bar",
		"signal_cellular_no_sim"                      => "signal_cellular_no_sim",
		"signal_cellular_null"                        => "signal_cellular_null",
		"signal_cellular_off"                         => "signal_cellular_off",
		"signal_wifi_4_bar"                           => "signal_wifi_4_bar",
		"signal_wifi_4_bar_lock"                      => "signal_wifi_4_bar_lock",
		"signal_wifi_off"                             => "signal_wifi_off",
		"sim_card"                                    => "sim_card",
		"sim_card_alert"                              => "sim_card_alert",
		"skip_next"                                   => "skip_next",
		"skip_previous"                               => "skip_previous",
		"slideshow"                                   => "slideshow",
		"smartphone"                                  => "smartphone",
		"sms"                                         => "sms",
		"sms_failed"                                  => "sms_failed",
		"snooze"                                      => "snooze",
		"sort"                                        => "sort",
		"sort_by_alpha"                               => "sort_by_alpha",
		"space_bar"                                   => "space_bar",
		"speaker"                                     => "speaker",
		"speaker_group"                               => "speaker_group",
		"speaker_notes"                               => "speaker_notes",
		"speaker_phone"                               => "speaker_phone",
		"spellcheck"                                  => "spellcheck",
		"star"                                        => "star",
		"star_border"                                 => "star_border",
		"star_half"                                   => "star_half",
		"stars"                                       => "stars",
		"stay_current_landscape"                      => "stay_current_landscape",
		"stay_current_portrait"                       => "stay_current_portrait",
		"stay_primary_landscape"                      => "stay_primary_landscape",
		"stay_primary_portrait"                       => "stay_primary_portrait",
		"stop"                                        => "stop",
		"storage"                                     => "storage",
		"store"                                       => "store",
		"store_mall_directory"                        => "store_mall_directory",
		"straighten"                                  => "straighten",
		"strikethrough_s"                             => "strikethrough_s",
		"style"                                       => "style",
		"subject"                                     => "subject",
		"subtitles"                                   => "subtitles",
		"supervisor_account"                          => "supervisor_account",
		"surround_sound"                              => "surround_sound",
		"swap_calls"                                  => "swap_calls",
		"swap_horiz"                                  => "swap_horiz",
		"swap_vert"                                   => "swap_vert",
		"swap_vertical_circle"                        => "swap_vertical_circle",
		"switch_camera"                               => "switch_camera",
		"switch_video"                                => "switch_video",
		"sync"                                        => "sync",
		"sync_disabled"                               => "sync_disabled",
		"sync_problem"                                => "sync_problem",
		"system_update"                               => "system_update",
		"system_update_alt"                           => "system_update_alt",
		"tab"                                         => "tab",
		"tab_unselected"                              => "tab_unselected",
		"tablet"                                      => "tablet",
		"tablet_android"                              => "tablet_android",
		"tablet_mac"                                  => "tablet_mac",
		"tag_faces"                                   => "tag_faces",
		"tap_and_play"                                => "tap_and_play",
		"terrain"                                     => "terrain",
		"text_format"                                 => "text_format",
		"textsms"                                     => "textsms",
		"texture"                                     => "texture",
		"theaters"                                    => "theaters",
		"thumb_down"                                  => "thumb_down",
		"thumb_up"                                    => "thumb_up",
		"thumbs_up_down"                              => "thumbs_up_down",
		"time_to_leave"                               => "time_to_leave",
		"timelapse"                                   => "timelapse",
		"timer"                                       => "timer",
		"timer_10"                                    => "timer_10",
		"timer_3"                                     => "timer_3",
		"timer_off"                                   => "timer_off",
		"toc"                                         => "toc",
		"today"                                       => "today",
		"toll"                                        => "toll",
		"tonality"                                    => "tonality",
		"toys"                                        => "toys",
		"track_changes"                               => "track_changes",
		"traffic"                                     => "traffic",
		"transform"                                   => "transform",
		"translate"                                   => "translate",
		"trending_down"                               => "trending_down",
		"trending_flat"                               => "trending_flat",
		"trending_up"                                 => "trending_up",
		"tune"                                        => "tune",
		"turned_in"                                   => "turned_in",
		"turned_in_not"                               => "turned_in_not",
		"tv"                                          => "tv",
		"undo"                                        => "undo",
		"unfold_less"                                 => "unfold_less",
		"unfold_more"                                 => "unfold_more",
		"usb"                                         => "usb",
		"verified_user"                               => "verified_user",
		"vertical_align_bottom"                       => "vertical_align_bottom",
		"vertical_align_center"                       => "vertical_align_center",
		"vertical_align_top"                          => "vertical_align_top",
		"vibration"                                   => "vibration",
		"video_library"                               => "video_library",
		"videocam"                                    => "videocam",
		"videocam_off"                                => "videocam_off",
		"view_agenda"                                 => "view_agenda",
		"view_array"                                  => "view_array",
		"view_carousel"                               => "view_carousel",
		"view_column"                                 => "view_column",
		"view_comfy"                                  => "view_comfy",
		"view_compact"                                => "view_compact",
		"view_day"                                    => "view_day",
		"view_headline"                               => "view_headline",
		"view_list"                                   => "view_list",
		"view_module"                                 => "view_module",
		"view_quilt"                                  => "view_quilt",
		"view_stream"                                 => "view_stream",
		"view_week"                                   => "view_week",
		"vignette"                                    => "vignette",
		"visibility"                                  => "visibility",
		"visibility_off"                              => "visibility_off",
		"voice_chat"                                  => "voice_chat",
		"voicemail"                                   => "voicemail",
		"volume_down"                                 => "volume_down",
		"volume_mute"                                 => "volume_mute",
		"volume_off"                                  => "volume_off",
		"volume_up"                                   => "volume_up",
		"vpn_key"                                     => "vpn_key",
		"vpn_lock"                                    => "vpn_lock",
		"wallpaper"                                   => "wallpaper",
		"warning"                                     => "warning",
		"watch"                                       => "watch",
		"wb_auto"                                     => "wb_auto",
		"wb_cloudy"                                   => "wb_cloudy",
		"wb_incandescent"                             => "wb_incandescent",
		"wb_iridescent"                               => "wb_iridescent",
		"wb_sunny"                                    => "wb_sunny",
		"wc"                                          => "wc",
		"web"                                         => "web",
		"whatshot"                                    => "whatshot",
		"widgets"                                     => "widgets",
		"wifi"                                        => "wifi",
		"wifi_lock"                                   => "wifi_lock",
		"wifi_tethering"                              => "wifi_tethering",
		"work"                                        => "work",
		"wrap_text"                                   => "wrap_text",
		"youtube_searched_for"                        => "youtube_searched_for",
		"zoom_in"                                     => "zoom_in",
		"zoom_out"                                    => "zoom_out",
	);

	return $icons;
}

//Pagination
function tell_get_pagination() {
	global $wp_query, $wp_rewrite;
	$wp_query->query_vars[ 'paged' ] > 1 ? $current = $wp_query->query_vars[ 'paged' ] : $current = 1;

	$pagination = array(
		'base'      => @add_query_arg( 'page', '%#%' ),
		'format'    => '',
		'total'     => $wp_query->max_num_pages,
		'current'   => $current,
		'show_all'  => false,
		'type'      => 'list',
		'next_text' => '<i class="material-icons">navigate_next</i>',
		'prev_text' => '<i class="material-icons">navigate_before</i>'
	);

	if ( $wp_rewrite->using_permalinks() )
		$pagination[ 'base' ] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

	if ( !empty( $wp_query->query_vars[ 's' ] ) )
		$pagination[ 'add_args' ] = array( 's' => get_query_var( 's' ) );

	return '<div class="pagination clear">' . paginate_links( $pagination ) . '</div>';
}

function tell_get_custom_pagination( $query_name ) {
	if ( empty( $query_name ) ) {
		return;
	}
	global $wp_rewrite;
	$query_name->query_vars[ 'paged' ] > 1 ? $current = $query_name->query_vars[ 'paged' ] : $current = 1;

	$pagination = array(
		'base'      => @add_query_arg( 'page', '%#%' ),
		'format'    => '',
		'total'     => $query_name->max_num_pages,
		'current'   => $current,
		'show_all'  => false,
		'type'      => 'list',
		'next_text' => '<i class="material-icons">chevron_right</i>',
		'prev_text' => '<i class="material-icons">chevron_left</i>'
	);

	if ( $wp_rewrite->using_permalinks() ) {
		$pagination[ 'base' ] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
	}

	if ( !empty( $query_name->query_vars[ 's' ] ) )
		$pagination[ 'add_args' ] = array(
			's' => get_query_var( 's' )
		);

	return '<div class="pagination clear">' . paginate_links( $pagination ) . '</div>';
}

//Breadcrumbs
function tell_get_breadcrumbs() {
	$text[ 'home' ]     = __( 'Home', 'local' );
	$text[ 'category' ] = __( 'Archive', 'local' ) . ' "%s"';
	$text[ 'search' ]   = __( 'Search local', 'local' ) . ' "%s"';
	$text[ 'tag' ]      = __( 'Tag', 'local' ) . ' "%s"';
	$text[ 'author' ]   = __( 'Author', 'local' ) . ' %s';
	$text[ '404' ]      = __( 'Error 404', 'local' );
	$text[ 'page' ]     = __( 'Page', 'local' ) . ' %s';
	$text[ 'cpage' ]    = __( 'Comments', 'local' ) . '%s';

	$wrap_before    = '<div class="breadcrumbs right">';
	$wrap_after     = '</div>';
	$sep            = ' <i class="material-icons">chevron_right</i> ';
	$sep_before     = '<span class="sep">';
	$sep_after      = '</span>';
	$show_home_link = 1;
	$show_on_home   = 0;
	$show_current   = 1;
	$before         = '<span class="current">';
	$after          = '</span>';

	global $post;
	$home_link      = home_url( '/' );
	$link_before    = '<div class="home">';
	$link_after     = '</div>';
	$link_attr      = ' itemprop="url"';
	$link_in_before = '<span itemprop="title">';
	$link_in_after  = '</span>';
	$link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
	$frontpage_id   = get_option( 'page_on_front' );
	if ( isset( $post->post_parent ) ) {
		$parent_id = $post->post_parent;
	} else {
		$parent_id = '';
	}
	$sep = ' ' . $sep_before . $sep . $sep_after . ' ';

	if ( is_home() || is_front_page() ) {

		if ( $show_on_home )
			echo $wrap_before . '<a href="' . $home_link . '">' . $text[ 'home' ] . '</a>' . $wrap_after;

	} else {

		echo $wrap_before;
		if ( $show_home_link )
			echo sprintf( $link, $home_link, $text[ 'home' ] );

		if ( is_category() ) {
			$cat = get_category( get_query_var( 'cat' ), false );
			if ( $cat->parent != 0 ) {
				$cats = get_category_parents( $cat->parent, true, $sep );
				$cats = preg_replace( "#^(.+)$sep$#", "$1", $cats );
				$cats = preg_replace( '#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats );
				if ( $show_home_link )
					echo $sep;
				echo $cats;
			}
			if ( get_query_var( 'paged' ) ) {
				$cat = $cat->cat_ID;
				echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ) ) . $sep . $before . sprintf( $text[ 'page' ], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current )
					echo $sep . $before . sprintf( $text[ 'category' ], single_cat_title( '', false ) ) . $after;
			}

		} elseif ( is_search() ) {
			if ( have_posts() ) {
				if ( $show_home_link && $show_current )
					echo $sep;
				if ( $show_current )
					echo $before . sprintf( $text[ 'search' ], get_search_query() ) . $after;
			} else {
				if ( $show_home_link )
					echo $sep;
				echo $before . sprintf( $text[ 'search' ], get_search_query() ) . $after;
			}

		} elseif ( is_day() ) {
			if ( $show_home_link )
				echo $sep;
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $sep;
			echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) );
			if ( $show_current )
				echo $sep . $before . get_the_time( 'd' ) . $after;

		} elseif ( is_month() ) {
			if ( $show_home_link )
				echo $sep;
			echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) );
			if ( $show_current )
				echo $sep . $before . get_the_time( 'F' ) . $after;

		} elseif ( is_year() ) {
			if ( $show_home_link && $show_current )
				echo $sep;
			if ( $show_current )
				echo $before . get_the_time( 'Y' ) . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( $show_home_link )
				echo $sep;
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object( get_post_type() );
				$slug      = $post_type->rewrite;
				printf( $link, $home_link . '/' . $slug[ 'slug' ] . '/', $post_type->labels->singular_name );
				if ( $show_current )
					echo $sep . $before . esc_html( get_the_title() ) . $after;
			} else {
				$cat  = get_the_category();
				$cat  = $cat[ 0 ];
				$cats = get_category_parents( $cat, true, $sep );
				if ( !$show_current || get_query_var( 'cpage' ) )
					$cats = preg_replace( "#^(.+)$sep$#", "$1", $cats );
				$cats = preg_replace( '#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats );
				echo $cats;
				if ( get_query_var( 'cpage' ) ) {
					echo $sep . sprintf( $link, get_permalink(), get_the_title() ) . $sep . $before . sprintf( $text[ 'cpage' ], get_query_var( 'cpage' ) ) . $after;
				} else {
					if ( $show_current )
						echo $before . esc_html( get_the_title() ) . $after;
				}
			}

			// custom post type
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object( get_post_type() );
			if ( isset( $post_type ) && !empty( $post_type ) ) {
				if ( get_query_var( 'paged' ) ) {
					echo $sep . sprintf( $link, get_post_type_archive_link( $post_type->name ), $post_type->label ) . $sep . $before . sprintf( $text[ 'page' ], get_query_var( 'paged' ) ) . $after;
				} else {
					if ( $show_current )
						echo $sep . $before . $post_type->label . $after;
				}
			}

		} elseif ( is_attachment() ) {
			if ( $show_home_link )
				echo $sep;
			$parent = get_post( $parent_id );
			$cat    = get_the_category( $parent->ID );
			$cat    = $cat[ 0 ];
			if ( $cat ) {
				$cats = get_category_parents( $cat, true, $sep );
				$cats = preg_replace( '#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr . '>' . $link_in_before . '$2' . $link_in_after . '</a>' . $link_after, $cats );
				echo $cats;
			}
			printf( $link, get_permalink( $parent ), $parent->post_title );
			if ( $show_current )
				echo $sep . $before . esc_html( get_the_title() ) . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ( $show_current )
				echo $sep . $before . esc_html( get_the_title() ) . $after;

		} elseif ( is_page() && $parent_id ) {
			if ( $show_home_link )
				echo $sep;
			if ( $parent_id != $frontpage_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page = get_page( $parent_id );
					if ( $parent_id != $frontpage_id ) {
						$breadcrumbs[] = sprintf( $link, get_permalink( $page->ID ), get_the_title( $page->ID ) );
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[ $i ];
					if ( $i != count( $breadcrumbs ) - 1 )
						echo $sep;
				}
			}
			if ( $show_current )
				echo $sep . $before . esc_html( get_the_title() ) . $after;

		} elseif ( is_tag() ) {
			if ( get_query_var( 'paged' ) ) {
				$tag_id = get_queried_object_id();
				$tag    = get_tag( $tag_id );
				echo $sep . sprintf( $link, get_tag_link( $tag_id ), $tag->name ) . $sep . $before . sprintf( $text[ 'page' ], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_current )
					echo $sep . $before . sprintf( $text[ 'tag' ], single_tag_title( '', false ) ) . $after;
			}

		} elseif ( is_author() ) {
			global $author;
			$author = get_userdata( $author );
			if ( get_query_var( 'paged' ) ) {
				if ( $show_home_link )
					echo $sep;
				echo sprintf( $link, get_author_posts_url( $author->ID ), $author->display_name ) . $sep . $before . sprintf( $text[ 'page' ], get_query_var( 'paged' ) ) . $after;
			} else {
				if ( $show_home_link && $show_current )
					echo $sep;
				if ( $show_current )
					echo $before . sprintf( $text[ 'author' ], $author->display_name ) . $after;
			}

		} elseif ( is_404() ) {
			if ( $show_home_link && $show_current )
				echo $sep;
			if ( $show_current )
				echo $before . $text[ '404' ] . $after;

		} elseif ( has_post_format() && !is_singular() ) {
			if ( $show_home_link )
				echo $sep;
			echo get_post_format_string( get_post_format() );
		}

		echo $wrap_after;

	}
}

//If is mobile
function tell_is_mobile() {
	return wp_is_mobile();
}

//All posts
function all_posts() {
	if ( !is_admin() ) {
		return;
	}
	wp_reset_query();
	$all_posts   = array();
	$query_posts = new WP_Query(
		array(
			'post_type'      => array( 'tours', 'excursions', 'cruises', 'hotels', 'car-rentals', 'rooms' ),
			'posts_per_page' => -1
		)
	);
	if ( $query_posts->have_posts() ) : while ( $query_posts->have_posts() ) : $query_posts->the_post();
		global $post;
		$all_posts[ $post->ID ] = get_the_title( $post->ID );
	endwhile; endif;
	wp_reset_query();

	return $all_posts;
}

//All hotels
function all_hotels() {
	if ( !is_admin() ) {
		return;
	}
	wp_reset_query();
	$all_hotels   = array();
	$query_hotels = new WP_Query(
		array(
			'post_type'      => array( 'hotels' ),
			'posts_per_page' => -1
		)
	);
	if ( $query_hotels->have_posts() ) : while ( $query_hotels->have_posts() ) : $query_hotels->the_post();
		global $post;
		$all_hotels[ $post->ID ] = get_the_title( $post->ID );
	endwhile; endif;
	wp_reset_query();

	return $all_hotels;
}

//Revert date from YY.mm.dd to dd/mm/yy
function tell_get_date_revert( $date ) {
	if ( strpos( $date, '.' ) !== false ) {
		$date = explode( '.', $date );
	} elseif ( strpos( $date, '-' ) !== false ) {
		$date = explode( '-', $date );
	} else {
		return $date;
	}
	$date = $date[ 2 ] . '/' . $date[ 1 ] . '/' . $date[ 0 ];

	return $date;
}

//Custom post type fix in menu
add_action( 'nav_menu_css_class', 'add_current_nav_class', 10, 2 );
function add_current_nav_class( $classes, $item ) {

	// Getting the current post details
	global $post;

	// Getting the post type of the current post
	if ( isset( $post->ID ) ) {
		$current_post_type      = get_post_type_object( get_post_type( $post->ID ) );
		$current_post_type_slug = $current_post_type->rewrite[ 'slug' ];

		// Getting the URL of the menu item
		$menu_slug = strtolower( trim( $item->url ) );

		// If the menu item URL contains the current post types slug add the current-menu-item class
		if ( strpos( $menu_slug, $current_post_type_slug ) !== false ) {

			$classes[] = 'current-menu-item';

		}
	}

	// Return the corrected set of classes to be added to the menu item
	return $classes;

}

//Woocommerce
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

//Sidebar Hide / Show
function tell_sidebar_trigger( $content = NULL ) {
	//Page begin
	ob_start();

	echo '<div class="row cf">';

	if ( 'hide' != tell_get_meta( 'opt-sidebar-default' ) ) {
		echo '<div class="col-md-9">';
		echo '<div class="row cf">';
	}

	$page_start = ob_get_contents();
	ob_end_clean();

	//Page begin
	ob_start();

	if ( 'hide' != tell_get_meta( 'opt-sidebar-default' ) ) {
		echo '</div>';
		echo '</div>';

		echo '<div class="col-md-3">';
			get_sidebar();
		echo '</div>';
	}

	echo '</div>';

	$page_end = ob_get_contents();
	ob_end_clean();

	return $page_start . $content . $page_end;
}