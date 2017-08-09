<?php
global $post;
echo '<div class="comments-template margin-bottom-30 cf">';
$comments_count = wp_count_comments( $post->ID );
if ( !empty( $comments_count ) ) {
	echo '<h3 class="green-dark-col cf">' . __( 'Comments', 'local' ) . '<span class="right dark-col">' . $comments_count->total_comments . '</span></h3>';
} else {
	echo '<h3 class="green-dark-col cf">' . __( 'Comments', 'local' ) . '<span class="right dark-col">0' . $comments_count->total_comments . '</span></h3>';
}

if ( comments_open( $post->ID ) ):
	if ( !function_exists( 'tell_comments_list' ) ) {
		function tell_comments_list( $comment, $args, $depth ) {
			$GLOBALS[ 'comment' ] = $comment; ?>
			<div <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
				<div id="comment-<?php comment_ID(); ?>" class="cf">
					<div class="image left">
						<?php echo get_avatar( $comment, $size = '50' ); ?>
					</div>

					<div class="text">
						<div class="comment-line cf">
							<div class="left">
								<?php printf( __( '<cite>%s</cite>', 'local' ), get_comment_author_link() ) ?>
							</div>

							<div class="reply right">
								<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ) ?>
							</div>

							<?php if ( $comment->comment_approved == '0' ) : ?>
								<em><?php _e( 'Your comment is awaiting moderation.', 'local' ) ?></em>
								<br/>
							<?php endif; ?>
						</div>

						<div class="">
							<?php comment_text(); ?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}

	$args = array(
		'walker'            => null,
		'max_depth'         => '',
		'style'             => 'ul',
		'callback'          => 'tell_comments_list',
		'end-callback'      => null,
		'type'              => 'all',
		'reply_text'        => 'Reply',
		'page'              => '',
		'per_page'          => '',
		'avatar_size'       => 32,
		'reverse_top_level' => null,
		'reverse_children'  => '',
		'format'            => 'html5', // or 'xhtml' if no 'HTML5' theme support
		'short_ping'        => false,   // @since 3.6
		'echo'              => true     // boolean, default is true
	);

	echo '<div class="comments-list">';
	wp_list_comments( $args );
	echo '</div>';

	the_comments_pagination();


	$fields = array(
		'author' => '<div class="row cf"><div class="col-md-6 comment-form-author">' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" size="30" placeholder="' . __( 'Name', 'local' ) . '"></div>',
		'email'  => '<div class="col-md-6 comment-form-email">' .
			'<input id="email" name="email" type="text" value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" size="30" placeholder="' . __( 'Email', 'local' ) . '"></div></div>',
	);
	$args   = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Comment', 'local' ) . '"></textarea></div>',
		'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'local' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s" class="green-dark-col black-col-hover">%2$s</a>. <a href="%3$s" class="green-dark-col black-col-hover" title="Log out of this account">Log out?</a>', 'local' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Leave a Reply', 'local' ),
		'title_reply_to'       => __( 'Leave a Reply to %s', 'local' ),
		'cancel_reply_link'    => __( 'Cancel reply', 'local' ),
		'label_submit'         => __( 'Submit', 'local' ),
		'class_submit'         => 'submit',
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn small blue-light-bg orange-bg-hover white-col right btn-shadow" value="%4$s" />',
		'submit_field'         => '<p class="form-submit">%1$s %2$s</a>',
	);
	echo '<div class="comments-form">';
	comment_form( $args, $post->ID );
	echo '</div>';
else:
	echo '<p>' . __( 'Comments not allowed', 'local' ) . '</p>';
endif;

echo '</div>';