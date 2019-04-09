<?php get_header(); ?>

<div class='content content-feed'>

	<?php if (have_posts()): ?>

		<?php if(is_author()) { ?>

			<?php $authorID = get_the_author_meta('ID');
			if(get_the_author_meta('description', $authorID)) {
				echo "<div class='archive-header'>";
				$featured_users = array($authorID);
				amani_featured_users($featured_users);
				echo "</div>";
			}
			?>

		<?php } else { ?>

			<div class='archive-header'>
				<h1>
					<?php if(is_category()) {
						single_cat_title();
					} else {
						the_archive_title();
					} ?>
				</h1>
	
				<div class='category-description'>
					<?php echo term_description(); ?>
				</div>
			</div>

		<?php } ?>


		<div class="blog-feed">

			<?php while (have_posts()) : the_post(); ?>

				<?php amani_the_article(); ?>

			<?php endwhile; ?>

		</div><!-- .blog-feed -->
		
		<?php get_sidebar(); ?>

		<?php amani_content_nav(); ?>

	<?php else: ?>

		<?php get_template_part('empty-cat'); ?>

	<?php endif; ?>

</div><!-- .content -->
		
<?php get_footer(); ?>