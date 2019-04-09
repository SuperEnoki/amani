<?php get_header(); ?>

<div class='content'>
	<div class='empty-cat post'>
		<h4><?php esc_html_e("Error 404: Page not found", 'amani'); ?></h4>
		<div class='fourofour'><?php esc_html_e('404', 'amani'); ?></div>

		<p><a href='<?php echo esc_url(home_url('/')); ?>' class='button default-button-small'><?php esc_html_e('Return to Home page', 'amani'); ?></a></p>

	</div>
</div><!-- .content -->

<?php get_footer(); ?>