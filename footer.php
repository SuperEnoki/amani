</div><!-- .wrapper -->

<?php

// Related posts

if(is_singular('post')) {
	echo '<div class="featured-bottom">';
	echo '<h3 class="related-post-title">'.esc_html__('Continue reading...', 'amani').'</h3>';
	$next_post = get_next_post();
	$prev_post = get_previous_post();
	if($next_post) {
		$post = get_post($next_post);
		amani_the_article();
	}
	if($prev_post) {
		$post = get_post($prev_post);
		amani_the_article();
	}
	echo '</div>';
}

// Getting Footer instagram

if(function_exists('wpiw_widget')) {
	$amani_footer_instagram = amani_get_option('footer_instagram');
	amani_single_instagram_widget($amani_footer_instagram);
}

?>

<footer class='footer-main'>

	<?php
	// Featured Users
	$featured_users = amani_get_option('featured_users_footer');
	amani_featured_users($featured_users);
	?>

	<?php /* If footer sidebar has at least one widget */

	if(is_active_sidebar('footer')) { ?>
		
		<div class='footer-wrap sidebar'>
			
			<?php dynamic_sidebar('footer'); ?>

		</div>

	<?php } ?>

	<?php /* If footer menu set we will show it */

	if(has_nav_menu('footer-nav')) {	?>
		<nav class='footer-wrap theme-menu footer-nav'>
			<?php
				wp_nav_menu(array('theme_location'=>'footer-nav'));
			?>
		</nav>
	<?php	} ?>

	<div class='footer-wrap copyright'>

		<div class='copyright-text'>
			<?php	echo amani_copyright();	?>
		</div>
		 
	</div>

</footer>

<aside class='responsive-wrap'>

	<nav class='responsive-nav'>
		<button class='search-trigger'><i class="fas fa-search"></i></button>
		<?php if(has_nav_menu('responsive-nav')) {
			wp_nav_menu(array('theme_location'=>'responsive-nav'));
		} else {
			wp_nav_menu(array('theme_location'=>'main-nav'));
		} ?>
		<?php echo amani_social_images(); ?>
	</nav>

</aside>

</div><!-- .theme-body -->

<?php wp_footer(); ?>
</body>

</html>