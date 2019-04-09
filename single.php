<?php get_header(); ?>

<div class='content content-singular'>

	<?php if (have_posts()) while (have_posts()) : the_post(); ?>

		<?php if(has_post_thumbnail()) { ?>

		<div class='post-header-big'>

			<div class='post-header'>

				<h1 class='post-title entry-title'>
					<span><?php the_title(); ?></span>
				</h1>

				<?php get_template_part('meta'); ?>

			</div>

			<div class='singular-featured'><?php the_post_thumbnail(); ?></div>

		</div>

		<?php } ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php if(!has_post_thumbnail()) { ?>

				<div class='post-header'>

					<h1 class='post-title entry-title'>
						<?php the_title(); ?>
					</h1>

					<?php get_template_part('meta'); ?>

				</div>

			<?php } ?>

			<?php $content = get_the_content(); if($content) { ?>

				<div class='post-content'>
					<?php the_content(); ?>
				</div>

			<?php } ?>

			<div class='post-footer'>

				<?php wp_link_pages(array(
					'before' => '<div class="post-pages"><div class="page-links-title">' . esc_html__('Pages:', 'amani') . '</div>',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>',
					));
				?>

				<?php if(has_tag()) { ?>
					<div class='post-tags'>
						<?php the_tags('<div class="tagcloud">', '', '</div>'); ?>
					</div>
				<?php } ?>

				<?php
					if(!post_password_required()) {
						if(function_exists('bekento_social_share')) {
							bekento_social_share();
						}
					}
				?>
				
			</div>

			<?php $authorID = get_the_author_meta('ID');
			if(get_the_author_meta('description', $authorID)) {
				echo "<div class='archive-header'>";
				$featured_users = array($authorID);
				amani_featured_users($featured_users);
				echo "</div>";
			}
			?>

			<div class='comments-wrap'>
				<?php
					comments_template('', true);
				?>
			</div>

		</article>
		
	<?php endwhile; ?>

</div><!-- .content -->

<?php get_footer(); ?>