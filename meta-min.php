<div class='post-meta-min'>
	<?php if(function_exists('pvc_get_post_views')) {
		$views_num = intval(pvc_get_post_views(get_the_ID()));
		if($views_num > 0) {
			?>
			<span class='views'>
				<i class="far fa-eye"></i> <?php echo amani_min_number(intval($views_num)); ?>
			</span>
			<?php
		}
	} ?>

	<?php if(get_comments_number() > 0) { ?>
		<span class='comments-count'>
			<i class="far fa-comment"></i> <?php comments_number('0', '1', '%'); ?>
		</span>
	<?php } ?>


	<?php if(function_exists('bekento_get_mtr')) { ?>
		<span class='minutes-read'>
			<i class="far fa-clock"></i> <?php echo esc_html(bekento_get_mtr(get_the_ID())); ?> <?php echo esc_html_e('min', 'amani'); ?>
		</span>
	<?php } ?>
</div>