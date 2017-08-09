<?php
add_action( 'admin_init', 'tell_init' );
function tell_init() {
	$tell_taxonomies = get_taxonomies();
	if ( is_array( $tell_taxonomies ) ) {
		$zci_options = get_option( 'zci_options' );
		if ( empty( $zci_options[ 'excluded_taxonomies' ] ) )
			$zci_options[ 'excluded_taxonomies' ] = array();

		foreach ( $tell_taxonomies as $tell_taxonomy ) {
			if ( in_array( $tell_taxonomy, $zci_options[ 'excluded_taxonomies' ] ) )
				continue;
			add_action( $tell_taxonomy . '_add_form_fields', 'tell_add_taxonomy_field' );
			add_action( $tell_taxonomy . '_edit_form_fields', 'tell_edit_taxonomy_field' );
			add_filter( 'manage_edit-' . $tell_taxonomy . '_columns', 'tell_taxonomy_columns' );
			add_filter( 'manage_' . $tell_taxonomy . '_custom_column', 'tell_taxonomy_column', 10, 3 );
		}
	}
}

function tell_add_style() {
	echo '<style type="text/css" media="screen">
		th.column-thumb {width:60px;}
		.form-field img.taxonomy-image {border:1px solid #eee;max-width:300px;max-height:300px;}
		.inline-edit-row fieldset .thumb label span.title {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
		.column-thumb span {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
		.inline-edit-row fieldset .thumb img,.column-thumb img {width:48px;height:48px;}
	</style>';
}

// add image field in add form
function tell_add_taxonomy_field() {
	if ( get_bloginfo( 'version' ) >= 3.5 )
		wp_enqueue_media();
	else {
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'thickbox' );
	}

	echo '<div class="form-field">
		<label for="taxonomy_image">' . __( 'Image', 'local' ) . '</label>
		<input type="text" name="taxonomy_image" id="taxonomy_image" value="" />
		<br/>
		<button class="tell_upload_image_button button">' . __( 'Upload/Add image', 'local' ) . '</button>
	</div>' . tell_script();
}

// add image field in edit form
function tell_edit_taxonomy_field( $taxonomy ) {
	if ( get_bloginfo( 'version' ) >= 3.5 )
		wp_enqueue_media();
	else {
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'thickbox' );
	}

	if ( tell_taxonomy_image_url( $taxonomy->term_id, NULL, true ) == 'http://placehold.it/150x150/e9e9e9/000000' )
		$image_url = "";
	else
		$image_url = tell_taxonomy_image_url( $taxonomy->term_id, NULL, true );
	echo '<tr class="form-field">
		<th scope="row" valign="top"><label for="taxonomy_image">' . __( 'Image', 'local' ) . '</label></th>
		<td><img class="taxonomy-image" src="' . tell_taxonomy_image_url( $taxonomy->term_id, 'medium', true ) . '"/><br/><input type="text" name="taxonomy_image" id="taxonomy_image" value="' . $image_url . '" /><br />
		<button class="tell_upload_image_button button">' . __( 'Upload/Add image', 'local' ) . '</button>
		<button class="tell_remove_image_button button">' . __( 'Remove image', 'local' ) . '</button>
		</td>
	</tr>' . tell_script();
}

// upload using wordpress upload
function tell_script() {
	return '<script type="text/javascript">
	    jQuery(document).ready(function($) {
			var wordpress_ver = "' . get_bloginfo( "version" ) . '", upload_button;
			$(".tell_upload_image_button").click(function(event) {
				upload_button = $(this);
				var frame;
				if (wordpress_ver >= "3.5") {
					event.preventDefault();
					if (frame) {
						frame.open();
						return;
					}
					frame = wp.media();
					frame.on( "select", function() {
						// Grab the selected attachment.
						var attachment = frame.state().get("selection").first();
						frame.close();
						if (upload_button.parent().prev().children().hasClass("tax_list")) {
							upload_button.parent().prev().children().val(attachment.attributes.url);
							upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
						}
						else
							$("#taxonomy_image").val(attachment.attributes.url);
					});
					frame.open();
				}
				else {
					tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
					return false;
				}
			});

			$(".tell_remove_image_button").click(function() {
				$(".taxonomy-image").attr("src", "http://placehold.it/150x150/e9e9e9/000000");
				$("#taxonomy_image").val("");
				$(this).parent().siblings(".title").children("img").attr("src","http://placehold.it/150x150/e9e9e9/000000");
				$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
				return false;
			});

			if (wordpress_ver < "3.5") {
				window.send_to_editor = function(html) {
					imgurl = $("img",html).attr("src");
					if (upload_button.parent().prev().children().hasClass("tax_list")) {
						upload_button.parent().prev().children().val(imgurl);
						upload_button.parent().prev().prev().children().attr("src", imgurl);
					}
					else
						$("#taxonomy_image").val(imgurl);
					tb_remove();
				}
			}

			$(".editinline").click(function() {
			    var tax_id = $(this).parents("tr").attr("id").substr(4);
			    var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");

				if (thumb != "http://placehold.it/150x150/e9e9e9/000000") {
					$(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
				} else {
					$(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
				}

				$(".inline-edit-col .title img").attr("src",thumb);
			});
	    });
	</script>';
}

// save our taxonomy image while edit or save term
add_action( 'edit_term', 'tell_save_taxonomy_image' );
add_action( 'create_term', 'tell_save_taxonomy_image' );
function tell_save_taxonomy_image( $term_id ) {
	if ( isset( $_POST[ 'taxonomy_image' ] ) )
		update_option( 'tell_taxonomy_image' . $term_id, $_POST[ 'taxonomy_image' ], NULL );
}

// get attachment ID by image url
function tell_get_attachment_id_by_url( $image_src ) {
	global $wpdb;
	$query = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src );
	$id    = $wpdb->get_var( $query );

	return ( !empty( $id ) ) ? $id : NULL;
}

// get taxonomy image url for the given term_id (Place holder image by default)
function tell_taxonomy_image_url( $term_id = NULL, $size = 'full', $return_placeholder = false ) {
	if ( !$term_id ) {
		if ( is_category() )
			$term_id = get_query_var( 'cat' );
		elseif ( is_tax() ) {
			$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$term_id      = $current_term->term_id;
		}
	}

	$taxonomy_image_url = get_option( 'tell_taxonomy_image' . $term_id );
	if ( !empty( $taxonomy_image_url ) ) {
		$attachment_id = tell_get_attachment_id_by_url( $taxonomy_image_url );
		if ( !empty( $attachment_id ) ) {
			$taxonomy_image_url = wp_get_attachment_image_src( $attachment_id, $size );
			$taxonomy_image_url = $taxonomy_image_url[ 0 ];
		}
	}

	if ( $return_placeholder )
		return ( $taxonomy_image_url != '' ) ? $taxonomy_image_url : 'http://placehold.it/150x150/e9e9e9/000000';
	else
		return $taxonomy_image_url;
}

function tell_quick_edit_custom_box( $column_name, $screen, $name ) {
	if ( $column_name == 'thumb' )
		echo '<fieldset>
		<div class="thumb inline-edit-col">
			<label>
				<span class="title"><img src="" alt="Thumbnail"/></span>
				<span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
				<span class="input-text-wrap">
					<button class="tell_upload_image_button button">' . __( 'Upload/Add image', 'local' ) . '</button>
					<button class="tell_remove_image_button button">' . __( 'Remove image', 'local' ) . '</button>
				</span>
			</label>
		</div>
	</fieldset>';
}

/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function tell_taxonomy_columns( $columns ) {
	$new_columns            = array();
	$new_columns[ 'cb' ]    = $columns[ 'cb' ];
	$new_columns[ 'thumb' ] = __( 'Image', 'local' );

	unset( $columns[ 'cb' ] );

	return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function tell_taxonomy_column( $columns, $column, $id ) {
	if ( $column == 'thumb' )
		$columns = '<span><img src="' . tell_taxonomy_image_url( $id, 'thumbnail', true ) . '" alt="' . __( 'Thumbnail', 'local' ) . '" class="wp-post-image" /></span>';

	return $columns;
}

// Change 'insert into post' to 'use this image'
function tell_change_insert_button_text( $safe_text, $text ) {
	return str_replace( "Insert into Post", "Use this image", $text );
}

// Style the image in category list
if ( strpos( $_SERVER[ 'SCRIPT_NAME' ], 'edit-tags.php' ) > 0 ) {
	add_action( 'admin_head', 'tell_add_style' );
	add_action( 'quick_edit_custom_box', 'tell_quick_edit_custom_box', 10, 3 );
	add_filter( "attribute_escape", "tell_change_insert_button_text", 10, 2 );
}

// New menu submenu for plugin options in Settings menu
/*add_action('admin_menu', 'tell_options_menu');
function tell_options_menu() {
	add_options_page(__('Categories Images settings', 'local'), __('Categories Images', 'local'), 'manage_options', 'zci-options', 'zci_options');
	add_action('admin_init', 'tell_register_settings');
}*/

// Register plugin settings
function tell_register_settings() {
	register_setting( 'zci_options', 'zci_options', 'tell_options_validate' );
	add_settings_section( 'zci_settings', __( 'Categories Images settings', 'local' ), 'tell_section_text', 'zci-options' );
	add_settings_field( 'tell_excluded_taxonomies', __( 'Excluded Taxonomies', 'local' ), 'tell_excluded_taxonomies', 'zci-options', 'zci_settings' );
}

// Settings section description
function tell_section_text() {
	echo '<p>' . __( 'Please select the taxonomies you want to exclude it from Categories Images plugin', 'local' ) . '</p>';
}

// Excluded taxonomies checkboxs
function tell_excluded_taxonomies() {
	$options             = get_option( 'zci_options' );
	$disabled_taxonomies = array( 'nav_menu', 'link_category', 'post_format' );
	foreach ( get_taxonomies() as $tax ) : if ( in_array( $tax, $disabled_taxonomies ) )
		continue; ?>
		<input type="checkbox" name="zci_options[excluded_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked( isset( $options[ 'excluded_taxonomies' ][ $tax ] ) ); ?> /> <?php echo $tax; ?>
		<br/>
	<?php endforeach;
}

// Validating options
function tell_options_validate( $input ) {
	return $input;
}

// Plugin option page
function zci_options() {
	if ( !current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'local' ) );
	$options = get_option( 'zci_options' );
	?>
	<div class="wrap">
		<h2><?php _e( 'Categories Images', 'local' ); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( 'zci_options' ); ?><?php do_settings_sections( 'zci-options' ); ?><?php submit_button(); ?>
		</form>
	</div>
	<?php
}

// display taxonomy image for the given term_id
function tell_get_taxonomy_image( $term_id = null, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	if ( !$term_id ) {
		if ( is_category() )
			$term_id = get_query_var( 'cat' );
		elseif ( is_tax() ) {
			$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$term_id      = $current_term->term_id;
		}
	}

	$taxonomy_image_url = get_option( 'tell_taxonomy_image' . $term_id );
	if ( !empty( $taxonomy_image_url ) ) {
		$attachment_id = tell_get_attachment_id_by_url( $taxonomy_image_url );
		if ( !empty( $attachment_id ) )
			$url = wp_get_attachment_url( $attachment_id );
		if ( !empty( $url ) ) {
			$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
			if ( '' == $image_size ) {
				$image_size = $url;
			}
			$image_size = esc_url( $image_size );

			return '<img src="' . $image_size . '" width="' . $width . '" height="' . $height . '" alt="' . esc_html( get_the_title() ) . '" title="' . esc_html( get_the_title() ) . '">';
		} else {
			return '<img src="http://placehold.it/' . $width . 'x' . $height . '/e9e9e9/000000" width="' . $width . '" height="' . $height . '" alt="' . esc_html( get_the_title() ) . '" title="' . esc_html( get_the_title() ) . '">';
		}
	}
}

function tell_get_taxonomy_image_url( $term_id = null, $width = null, $height = null, $crop = true, $single = true, $upscale = true ) {
	if ( !$term_id ) {
		if ( is_category() )
			$term_id = get_query_var( 'cat' );
		elseif ( is_tax() ) {
			$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			$term_id      = $current_term->term_id;
		}
	}

	$taxonomy_image_url = get_option( 'tell_taxonomy_image' . $term_id );
	if ( !empty( $taxonomy_image_url ) ) {
		$attachment_id = tell_get_attachment_id_by_url( $taxonomy_image_url );
		if ( !empty( $attachment_id ) )
			$url = wp_get_attachment_url( $attachment_id );
		if ( !empty( $url ) ) {
			$image_size = aq_resize( $url, $width, $height, $crop, $single, $upscale );
			if ( '' == $image_size ) {
				$image_size = $url;
			}
			$image_size = esc_url( $image_size );

			return $image_size;
		} else {
			return 'http://placehold.it/' . $width . 'x' . $height . '/e9e9e9/000000';
		}
	}
}