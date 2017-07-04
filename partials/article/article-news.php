<?php global $counter;
if ( 0 == $counter ) { ?>
	<article <?php post_class( 'archive-news-item margin-bottom-30' ); ?>>
		<div class="image margin-bottom-15">
			<a href="<?php the_permalink(); ?>">
				<?php echo tell_get_post_image( 870, 450 ); ?>
			</a>
		</div>

		<div class="text">
			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h2>

			<time datetime="<?php the_time( 'Y-m-d' ); ?>">
				<i class="material-icons">event_note</i><?php the_time( 'Y-m-d' ); ?></time>

			<div class="description">
				<?php echo tell_trim_excerpt( 70 ); ?>
			</div>
		</div>
	</article>
<?php } else { ?>
	<article <?php post_class( 'archive-news-item flex-box cf margin-bottom-30' ); ?>>
		<div class="col-sm-2 col-xs-3 image margin-bottom-15">
			<a href="<?php the_permalink(); ?>" class="row">
				<?php echo tell_get_post_image( 145, 145 ); ?>
			</a>
		</div>

		<div class="col-sm-10 col-xs-9 text">
			<h2>
				<a href="<?php the_permalink(); ?>" class="black-col blue-col-hover"><?php the_title(); ?></a>
			</h2>

			<time datetime="<?php the_time( 'Y-m-d' ); ?>">
				<i class="material-icons">event_note</i><?php the_time( 'Y-m-d' ); ?></time>

			<div class="description">
				<?php echo tell_trim_excerpt( 60 ); ?>
			</div>
		</div>
	</article>
<?php } ?>