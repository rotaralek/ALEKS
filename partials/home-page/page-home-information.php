<?php if ( tell_get_meta( 'page_home_information_display' ) != 'hide' ): ?>
	<section class="page-home-information grey-light-bg">
		<div class="container">
			<div class="heading text-center margin-bottom-30">
				<h2 class="margin-bottom-30"><span><?php echo tell_get_meta( 'page_home_information_title' ); ?></span></h2>
				<p class="margin-bottom-30"><?php echo tell_get_meta( 'page_home_information_description' ); ?></p>
				<hr class="blue-light-bg">
			</div>

			<div class="row flex-box">
				<?php if ( tell_get_meta( 'page_home_partners_item_1_title' ) ) { ?>
					<article class="col-md-4 col-sm-6 margin-bottom-30 text-center blue-light-col-hover">
						<i class="material-icons margin-bottom-15"><?php echo tell_get_meta( 'page_home_partners_item_1_icon' ); ?></i>
						<h3><?php echo tell_get_meta( 'page_home_partners_item_1_title' ); ?></h3>
						<p><?php echo tell_get_meta( 'page_home_partners_item_1_text' ); ?></p>
					</article>
				<?php } ?>

				<?php if ( tell_get_meta( 'page_home_partners_item_2_title' ) ) { ?>
					<article class="col-md-4 col-sm-6 margin-bottom-30 text-center blue-light-col-hover">
						<i class="material-icons margin-bottom-15"><?php echo tell_get_meta( 'page_home_partners_item_2_icon' ); ?></i>
						<h3><?php echo tell_get_meta( 'page_home_partners_item_2_title' ); ?></h3>
						<p><?php echo tell_get_meta( 'page_home_partners_item_2_text' ); ?></p>
					</article>
				<?php } ?>

				<?php if ( tell_get_meta( 'page_home_partners_item_3_title' ) ) { ?>
					<article class="col-md-4 col-sm-6 margin-bottom-30 text-center blue-light-col-hover">
						<i class="material-icons margin-bottom-15"><?php echo tell_get_meta( 'page_home_partners_item_3_icon' ); ?></i>
						<h3><?php echo tell_get_meta( 'page_home_partners_item_3_title' ); ?></h3>
						<p><?php echo tell_get_meta( 'page_home_partners_item_3_text' ); ?></p>
					</article>
				<?php } ?>

				<?php if ( tell_get_meta( 'page_home_partners_item_4_title' ) ) { ?>
					<article class="col-md-4 col-sm-6 margin-bottom-30 text-center blue-light-col-hover">
						<i class="material-icons margin-bottom-15"><?php echo tell_get_meta( 'page_home_partners_item_4_icon' ); ?></i>
						<h3><?php echo tell_get_meta( 'page_home_partners_item_4_title' ); ?></h3>
						<p><?php echo tell_get_meta( 'page_home_partners_item_4_text' ); ?></p>
					</article>
				<?php } ?>

				<?php if ( tell_get_meta( 'page_home_partners_item_5_title' ) ) { ?>
					<article class="col-md-4 col-sm-6 margin-bottom-30 text-center blue-light-col-hover">
						<i class="material-icons margin-bottom-15"><?php echo tell_get_meta( 'page_home_partners_item_5_icon' ); ?></i>
						<h3><?php echo tell_get_meta( 'page_home_partners_item_5_title' ); ?></h3>
						<p><?php echo tell_get_meta( 'page_home_partners_item_5_text' ); ?></p>
					</article>
				<?php } ?>

				<?php if ( tell_get_meta( 'page_home_partners_item_6_title' ) ) { ?>
					<article class="col-md-4 col-sm-6 margin-bottom-30 text-center blue-light-col-hover">
						<i class="material-icons margin-bottom-15"><?php echo tell_get_meta( 'page_home_partners_item_6_icon' ); ?></i>
						<h3><?php echo tell_get_meta( 'page_home_partners_item_6_title' ); ?></h3>
						<p><?php echo tell_get_meta( 'page_home_partners_item_6_text' ); ?></p>
					</article>
				<?php } ?>
			</div>
		</div>
	</section>
<?php endif; ?>