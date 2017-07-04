<?php
/*
  * Template name: Template Visual Composer
  * */
get_header( '2' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="visual-composer-template cf">
		<?php the_content(); ?>
	</div>
<?php endwhile; endif;
wp_reset_query(); ?>

<?php get_footer(); ?>