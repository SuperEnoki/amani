<?php get_header(); ?>

<div class='content content-singular'>

	<?php if (have_posts()) while (have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<div class='post-header'>
				<h1 class='post-title entry-title'>
					<span><?php the_title(); ?></span>
				</h1>
			</div>

			<div class='post-content'>
				<?php the_content(esc_html__('Continue Reading', 'amani')); ?>
			</div>

			<div class='comments-wrap'>
				<?php
				if(comments_open()) {
					comments_template('', true);
				}
				?>
			</div>
			
		</article>
		
	<?php endwhile; ?>

</div><!-- .content -->

<?php get_footer(); ?>