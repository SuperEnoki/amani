<?php get_header(); ?>

<div class='content content-feed'>

	<?php if (have_posts()): ?>

		<div class='archive-header'>
			<h1 class='search-page'><?php esc_html_e('Search results for:', 'amani'); ?> '<?php echo get_search_query(); ?>'</h1>
		</div>

		<div class="blog-feed">

			<?php while (have_posts()) : the_post(); ?>

				<?php amani_the_article(); ?>

			<?php endwhile; ?>

		</div><!-- .blog-feed -->

		<?php amani_content_nav(); ?>
		
		<?php get_sidebar(); ?>

	<?php else: ?>

		<div class='empty-cat empty-search'>
			<h2 class='title-search-no-results'><?php esc_html_e('No search results for:', 'amani'); ?> "<?php echo get_search_query(); ?>"</h2>
			<p><?php esc_html_e('You can either search again or return to home page', 'amani'); ?></p>
			<?php get_search_form(); ?>
			<p>
				<a href='<?php echo esc_url(home_url('/')); ?>' class='button default-button-small'><?php esc_html_e('Return to Home Page', 'amani'); ?></a>
			</p>
		</div>
		
	<?php endif; ?>
	

</div><!-- .content -->
		
<?php get_footer(); ?>