<div class='post-meta'>

	<div>
		<span class='post-author'>
			<span class="vcard author"><span class="fn"><?php the_author_posts_link(); ?></span></span>
		</span>
		<span class='post-date'>
			<span class="date updated published"><?php echo '<a href="'.esc_url(get_permalink()).'" title="' . get_the_title().'" rel="bookmark"><time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().' '.get_the_time().'</time></a>'; ?></span>
		</span>
		<span class='post-date-min'>
			<?php echo '<a href="'.esc_url(get_permalink()).'" title="' . get_the_title().'" rel="bookmark"><time datetime="'.get_the_time('Y-m-d').'">'.get_the_date().'</time></a>'; ?>
		</span>
	</div>

</div><!-- .post-meta -->