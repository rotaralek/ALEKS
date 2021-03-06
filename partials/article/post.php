<article <?php post_class( 'archive-post-item margin-bottom-30' ); ?>>
	<div class="image margin-bottom-15">
		<a href="<?php the_permalink(); ?>">
			<?php echo tell_get_post_image( 870, 435 ); ?>
		</a>
	</div>

	<div class="text">
		<h2>
			<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
		</h2>

		<time datetime="<?php the_time( 'Y-m-d' ); ?>">
			<i class="material-icons">event_note</i><?php the_time( 'Y-m-d' ); ?>
		</time>

		<div class="description">
			<?php echo tell_trim_excerpt( 60 ); ?>
		</div>

		<div class="tags">
			<?php the_tags( '' ); ?>
		</div>
	</div>
</article>
