<?php
/*
  * Template name: Template Contact
  * */
get_header(); ?>

	<section class="container">
		<div class="heading">
			<h1><?php wp_title( '', true ); ?></h1>
		</div>

		<?php ob_start();

		echo 'Some text';

		$content = ob_get_contents();
		ob_end_clean();

		//Show or hide sidebar function
		tell_sidebar_trigger( $content ); ?>
	</section>

<?php get_footer(); ?>
