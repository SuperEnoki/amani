<?php get_header(); ?>

<div class='content content-feed'>

	<?php

	if(have_posts()):

		$amani_posts_iterate = 0;
		$ppp = floor((int) get_option('posts_per_page') / 3);

		?>

		<div class="blog-feed">

			<?php

			while(have_posts()) : the_post();

				amani_the_article();

			endwhile; // End of have_posts();

			// Getting Masonry Sidebar

			if(esc_attr(amani_get_option('blog_layout', $amani['blog_layout'])) == 'masonry') {
				get_template_part('sidebar-mixer');
			}

			?>

		</div><!-- .blog-feed -->
	
		<?php
		
			get_sidebar();

			// Pagination
			amani_content_nav();

	else:

		// No posts available
		get_template_part('empty-cat');
		
	endif;

	?>

</div><!-- .content -->

<?php get_footer(); ?>
