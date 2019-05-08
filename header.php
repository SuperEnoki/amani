<!doctype html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset='<?php bloginfo('charset'); ?>' />

	<meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, viewport-fit=cover' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge' />

	<link rel='pingback' href='<?php bloginfo('pingback_url'); ?>' />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class='theme-body <?php echo amani_body_class(); ?>'>

<div class='body-bg'></div>

<?php
// Header Instagram Widget
if(function_exists('wpiw_widget')) {
	if(is_front_page() ||  is_home()) {
		$amani_header_instagram = amani_get_option('header_instagram');
		amani_single_instagram_widget($amani_header_instagram, 'header');
	}
} ?>

<div class='wrapper'>

<header class='header header-main'>

	<div class='header-wrap header-essentials'>

		<?php
			echo amani_social_images();
		?>

		<nav class='theme-menu secondary-nav'>
			<?php wp_nav_menu(array('theme_location'=>'secondary-nav')); ?>
		</nav>

		<?php echo amani_theme_logo(); ?>
		<button class='responsive-menu-trigger'></button>

		<nav class='theme-menu main-nav'>
			<?php wp_nav_menu(array('theme_location'=>'main-nav')); ?>
		</nav>

		<div class='search-trigger-wrap'>
			<button class='search-trigger'><i class="fas fa-search"></i></button>
		</div>

	</div>

	<?php
	// Featured users
	if(is_front_page() || is_home()) {
		// Getting Users from Customier option
		$featured_users = amani_get_option('featured_users');
		amani_featured_users($featured_users);
	} ?>

	<?php
		// Top Featured Posts
		if(is_home() || is_front_page()) {
			if(!is_paged()) {
				$top_featured_category = (int) amani_get_option('top_featured_category');
				amani_the_featured($top_featured_category, 'header-wrap featured-top', 10);
			}
		}
	?>

</header><!-- .header-main -->

<div class='search-wrap'>
	<div>
		<?php get_search_form(); ?>
	</div>
</div>
