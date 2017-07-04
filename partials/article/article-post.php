<?php global $counter;
if ( 0 == $counter ) { ?>
<article <?php post_class( 'archive-post-item margin-bottom-60 container-fluid' ); ?>>
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
			<i class="material-icons">event_note</i><?php the_time( 'Y-m-d' ); ?></time>

		<div class="string">
			<?php echo tell_trim_excerpt( 60 ); ?>
		</div>
	</div>
</article>
<?php } else { ?>
	<article <?php post_class( 'archive-post-item margin-bottom-60 col-md-6' ); ?>>
		<div class="image margin-bottom-15">
			<a href="<?php the_permalink(); ?>">
				<?php echo tell_get_post_image( 420, 280 ); ?>
			</a>
		</div>

		<div class="text">
			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h2>

			<time datetime="<?php the_time( 'Y-m-d' ); ?>">
				<i class="material-icons">event_note</i><?php the_time( 'Y-m-d' ); ?></time>

			<div class="string">
				<?php echo tell_trim_excerpt( 40 ); ?>
			</div>
		</div>
	</article>
<?php } ?>
