<?php
/*
  * Template name: Template Contact
  * */
get_header( '2' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="top-page-header cf margin-bottom-60" style="background-image: url('<?php echo tell_get_post_image_src( 1920, 400 ); ?>');">
		<h1 class="white-col"><?php wp_title( '', true ); ?></h1>
	</div>

	<div class="container template-contact">
		<div class="row cf">
			<div class="col-md-6 margin-bottom-60">
				<div class="content-style">
					<?php the_content(); ?>
				</div>
			</div>

			<div class="col-md-6 margin-bottom-60">
				<div class="contact-info margin-bottom-30">
					<dl class="cf">
						<?php if ( tell_get_meta( 'template_contact_address' ) ) { ?>
							<dt class="address left clear">
								<i class="material-icons blue-col">place</i>
								<b><?php _e( 'Address', 'local' ); ?>:</b>
							</dt>

							<dd class="left">
								<span><?php echo tell_get_meta( 'template_contact_country' ); ?></span>
								<span><?php echo tell_get_meta( 'template_contact_address' ); ?></span>
							</dd>
						<?php } ?>

						<?php if ( tell_get_meta( 'template_contact_phone' ) ) { ?>
							<dt class="address left clear">
								<i class="material-icons blue-col">phone</i>
								<b><?php _e( 'Phone', 'local' ); ?>:</b>
							</dt>

							<dd class="left"><?php echo tell_get_meta( 'template_contact_phone' ); ?></dd>
						<?php } ?>

						<?php if ( tell_get_meta( 'template_contact_email' ) ) { ?>
							<dt class="address left clear">
								<i class="material-icons blue-col">email</i>
								<b><?php _e( 'E-mail', 'local' ); ?>:</b>
							</dt>

							<dd class="left"><?php echo tell_get_meta( 'template_contact_email' ); ?></dd>
						<?php } ?>
					</dl>
				</div>

				<div class="contact-form cf">
					<h3 class="margin-bottom-15"><?php echo tell_get_meta( 'template_contact_form_title' ); ?></h3>

					<p class="margin-bottom-30"><?php echo tell_get_meta( 'template_contact_form_text' ); ?></p>

					<form method="post" action="<?php the_permalink(); ?>" class="cf row contact-form-send">
						<div class="col-md-6 margin-bottom-15">
							<input name="message_name" type="text" placeholder="<?php _e( 'Name', 'local' ); ?>" maxlength="100" required class="input-field">
						</div>

						<div class="col-md-6 margin-bottom-15">
							<input name="message_email" type="email" placeholder="<?php _e( 'E-mail', 'local' ); ?>" maxlength="100" required class="input-field">
						</div>

						<div class="container-fluid margin-bottom-15">
							<textarea name="message_text" placeholder="<?php _e( 'Text of the letter', 'local' ); ?>" required class="full"></textarea>
						</div>

						<div class="container-fluid cf">
							<div class="left respond"></div>

							<button type="submit" class="btn small white-col blue-bg red-bg-hover right btn-shadow"><?php _e( 'Send a letter', 'local' ) ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="template-contact">
		<div class="contact-map">
			<?php if ( tell_get_meta( 'template_contact_address' ) != '' ) {
				$address = tell_get_meta( 'template_contact_address' );
				echo do_shortcode( '[tell_map address="' . $address . '" width="100%" height="500px"]' );
			} ?>
		</div>
	</div>
<?php endwhile; endif;
wp_reset_query(); ?>

<?php get_footer(); ?>