<?php

/*

This file contains of all functions needed in theme.
For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API

*/

// Enable support of post formats, add image sizes for thumbnails

function amani_theme_setup() {

	global $amani;

	// Add default posts and comments RSS feed links to head.
	
	add_theme_support('automatic-feed-links');

	// Define Additional WordPress Options Theme Supports
	add_theme_support('title-tag');
	add_theme_support('html5', array('gallery'));
	add_theme_support('post-formats', array('link', 'video', 'gallery', 'image', 'audio', 'quote', 'status', 'chat'));
	add_theme_support('align-wide');
	add_theme_support('gutenberg');
	add_theme_support('responsive-embeds');
	add_theme_support('post-thumbnails');
	add_theme_support('editor-styles');

	// Theme Navigation
	register_nav_menus(
		array(
			'main-nav' => esc_html__('Main Menu', 'amani'),
			'secondary-nav' => esc_html__('Secondary Menu', 'amani'),
			'footer-nav' => esc_html__('Footer Menu', 'amani'),
			'responsive-nav' => esc_html__('Responsive Menu', 'amani')
		)
	);

	$colors = amani_api_color_scheme();

	$editor_palette = array(
		array(
			'name' => esc_html__('White', 'amani'),
			'slug' => 'white',
			'color' => '#fff',
		),
		array(
			'name' => esc_html__('Black', 'amani'),
			'slug' => 'black',
			'color' => '#111',
		),
		array(
			'name' => esc_html__('Gray', 'amani'),
			'slug' => 'gray',
			'color' => '#f8f8f7',
		),
	);

	$color_num = 0;

	foreach ($colors as $color) {
		$color_num++;
		array_push($editor_palette, array(
			'name' => esc_html__('Color '.$color_num, 'amani'),
			'slug' => 'color'.$color_num,
			'color' => $color,
		));
	}

	add_theme_support('editor-color-palette', $editor_palette);

	// Inside Post Image Size
	add_image_size('amani_main', 2560, 5000, false);
}
add_action('after_setup_theme', 'amani_theme_setup');

// All Scripts

function amani_script_enqueuer() {
	global $amani;

	// Main JavaScript
	wp_register_script('amani_site', get_template_directory_uri().'/js/site.js', array('jquery', 'imagesloaded'), true);
	
	// Api for Customizer
	$amani_js = '';
	if(is_customize_preview()) {
		for ($cc=0; $cc < $amani['color_num']; $cc++) {
			foreach ($amani['color_places'] as $key => $value) {
				if(!empty($amani['css_colors'][$cc][$key])) {
					$amani_js .= 'var amani_css_'.$cc.'_'.$key.' = ['.amani_css_list_js($amani['css_colors'][$cc][$key]).'];';
				}
			}
		}
	}

	wp_add_inline_script('amani_site', $amani_js);
	wp_enqueue_script('amani_site');

	wp_enqueue_style('amani_css', get_template_directory_uri() . "/css/style.css", array());

}
add_action('wp_enqueue_scripts', 'amani_script_enqueuer');

// Enable sidebars

function amani_sidebar_init() {
	register_sidebar(array(
		'id' => 'sidebar',
		'name' => esc_html__('Sidebar', 'amani'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'sidebar-mixer',
		'name' => esc_html__('Masonry Widgets', 'amani'),
		'before_widget' => '<div class="grid-item grid-item-widget"><section id="%1$s" class="widget grid-item-content %2$s">',
		'after_widget' => '</section></div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'id' => 'footer',
		'name' => esc_html__('Footer', 'amani'),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));
}
add_action('widgets_init', 'amani_sidebar_init');

// Get Default Post for Loop

function amani_the_article($article_class=false) {
	global $post;

	$additional_class = 'grid-item-content ';
	$additional_class .= $article_class;
	if(has_post_format('link') && has_excerpt()) {
		$post_link = wp_strip_all_tags(get_the_excerpt());
	} else {
		$post_link = get_permalink($post->ID);
	}
	
	?>
	<div class='grid-item'>
		<article id="post-<?php the_ID(); ?>" <?php post_class($additional_class); ?>>
			<?php
			if(has_post_thumbnail($post)) {
				$post_format = '';
				$post_format = get_post_format($post->ID);
				$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
				$post_thumb = $post_thumb[0];
				?>
				<div class='post-image-wrap'>
					<a href="<?php echo esc_url($post_link); ?>">
						<div class='post-image-cover' style='background-image: url(<?php echo esc_url($post_thumb); ?>);'></div>
						<div class='post-image'>
							<?php the_post_thumbnail('large'); ?>
						</div>
						<?php get_template_part('meta-min'); ?>
						<?php if(get_post_format($post->ID) == 'audio') {
							echo '<div class="audio-bars"><div class="audio-bar"></div><div class="audio-bar"></div><div class="audio-bar"></div><div class="audio-bar"></div><div class="audio-bar"></div></div>';
						} ?>
					</a>
				</div>
			<?php } ?>
			<div class='post-wrap'>
				<?php get_template_part('meta-category'); ?>
				<h2 class='post-title'>
					<a href="<?php echo esc_url($post_link); ?>" rel="bookmark"><?php echo esc_html($post->post_title); ?></a>
				</h2>
				<div class='excerpt'><?php the_excerpt(); ?></div>
				<?php get_template_part('meta'); ?>
			</div>
		</article>
	</div>
	<?php
}

// The Featured

function amani_the_featured($featured_category, $featured_class, $featured_number=4) {
	global $post;
	if($featured_category != 0) {
		$featured_posts = '';
		$featured_posts = query_posts(array(
			'posts_per_page' => $featured_number,
			'post_type' => array('post', 'page'),
			'cat' => $featured_category
		));

		$iterate_featured = 0;

		if(have_posts()) {
			// Featured posts list
			echo '<div class="featured-posts '.$featured_class.'">';
				while (have_posts()) {
					$iterate_featured++;
					the_post();
					amani_the_article();
				}
			echo '</div>';
		}

		wp_reset_query();
	}
}

// Header Post Thumbnail

function amani_header_thumb($size='amani_main') {
	global $post_id;
	$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
	if($post_thumb[0]) {
		$post_thumb = esc_url($post_thumb[0]);
	}
	$amani_post_thumb = ''; 
	if(is_singular()) {
		$amani_post_thumb = $post_thumb;
		if($amani_post_thumb) {
			$amani_post_thumb = 'background-image: url('.$amani_post_thumb.');';
		}
	}
	return $amani_post_thumb;
}

// Featured Users

function amani_featured_users($featured_users) {
	$featured_users_cnt = 0;
	if(is_array($featured_users)) {
		foreach ($featured_users as $key => $user_one) {
			if($user_one != '' && $user_one != 0) {
				if($featured_users_cnt == 0) {
					// Creating container if first user is set
					echo "<div class='header-wrap footer-wrap author-bio'><div class='people'>";
				}
				?>
					<div class='person'>
						<div>
							<a href="<?php echo get_author_posts_url($user_one); ?>"><div class='picture' style='background-image: url(<?php echo get_avatar_url($user_one, array('size' => '300')); ?>);'></div></a>
						</div>
						<div class='text'>
							<h3 class='name'><a href="<?php echo get_author_posts_url($user_one); ?>"><?php echo esc_html(get_the_author_meta('display_name', $user_one)); ?></a></h3>
							<p><?php echo esc_html(get_the_author_meta('description', $user_one)); ?></p>
							<?php echo amani_social_images($user_one); ?>
						</div>
					</div>
				<?php
				$featured_users_cnt++;
				if($featured_users_cnt == count($featured_users)) {
					echo "</div></div>";
				}
			} /* end if user */
		} /* end foreach */
	} /* end ifisset */
}

// Social Links

function amani_social_images($user_id=0) {
	global $amani;
	$amani_social_images = '';
	$amani_cnt = 0;
	
	foreach($amani['social'] as $amani_social_name => $color) {

		if(strpos($amani_social_name, "-")) {
			$amani_social_title = substr($amani_social_name, 0, strpos($amani_social_name, "-"));
		} else {
			$amani_social_title = $amani_social_name;
		}

		if($amani_social_title == 'envelope') {
			$amani_social_title = 'email';
		} else {
			$amani_social_title = $amani_social_title;
		}

		if($user_id == 0) {
			$amani_social_url = amani_get_option($amani_social_title);
		} else {
			if(function_exists('bekento_get_author_meta')) {
				$amani_social_url = bekento_get_author_meta($amani_social_title, $user_id);
			} else {
				$amani_social_url = '';
			}
		}

		if($amani_social_url) {

			if($amani_cnt == 0) {
				$amani_social_images .= "<div class='social-wrap'>";
			}

			$amani_cnt++;

			if($amani_social_name == 'envelope' || $amani_social_name == 'rss-square') {
				$fasfab = 'fas';
			} else {
				$fasfab = 'fab';
			}
			$amani_social_images .= "<a href='".esc_url($amani_social_url)."' title='".ucfirst($amani_social_title)."' class='".$amani_social_title."' style='color: ".$color."'><i class='".$fasfab." fa-".$amani_social_name."'></i></a>";
		}
	}
	if($amani_cnt > 0) {
		$amani_social_images .= '</div>';
	}
	return $amani_social_images;
}

// Single Instagram Widget Invocation

function amani_single_instagram_widget($amani_instagram, $position='footer') {
	if(function_exists('wpiw_widget')) {
		if($amani_instagram != '') { ?>
			<div class='<?php echo esc_attr($position); ?>-instagram'>
				<div class='wide-instagram-feed wide-instagram-feed-<?php echo esc_attr($position); ?>'>

					<?php 
						$args = array(
							'username' => $amani_instagram,
							'size' => 'small',
							'number' => 10,
							'target' => '_blank',
							'link' => ''
						);
						the_widget('null_instagram_widget', $args);
					?>

					<div class='follow'><a href="https://instagram.com/<?php echo esc_attr($amani_instagram); ?>"><?php echo '@'.esc_html($amani_instagram); ?></a></div>

				</div>
			</div>
		<?php }
	}
}

// Set Excerpt Style

function amani_new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'amani_new_excerpt_more');

// Set Excerpt Length

function amani_custom_excerpt_length($length) {
	return 25;
}
add_filter('excerpt_length', 'amani_custom_excerpt_length', 999);

// IE11 Fixing Responsive Gallery Width

function amani_remove_img_width_height($html) {
	$html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
	return $html;
}
add_filter('wp_get_attachment_link', 'amani_remove_img_width_height', 10, 1);

// Adding Theme Translation support

function amani_translation_setup() {
	load_theme_textdomain('amani', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'amani_translation_setup');

// Remove Recent Comments styling

function amani_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'amani_remove_recent_comments_style');

// Comment Reply JS

function amani_enqueue_comment_reply() {
	// on single blog post pages with comments open and threaded comments
	if (is_singular() && comments_open() && get_option('thread_comments')) { 
		// enqueue the javascript that performs in-link comment reply fanciness
		wp_enqueue_script('comment-reply'); 
	}
}
add_action('wp_enqueue_scripts', 'amani_enqueue_comment_reply');

// Fix HTML validation error

function amani_add_nofollow_cat($text) {
	$text = str_replace('rel="category tag"', "", $text); return $text;
}
add_filter('the_category', 'amani_add_nofollow_cat');

// Add Theme Support

function amani_add_support() {
	add_theme_support("custom-header");
	add_theme_support("custom-background");
	get_the_post_thumbnail(null, $size);
}

// Customizer JavaScript transport postmessage handler

function amani_customizer_live_preview() {
	global $amani;
	wp_enqueue_script('amani-customizer',	get_template_directory_uri() . '/js/customizer.js', array('customize-preview', 'jquery'), '1.0', true);

	$customizer_data = '';

	$colors = amani_api_color_scheme();
	$gradient = esc_attr(amani_get_option('gradient', $amani['gradient']));
	$body_bg = esc_attr(amani_get_option('body_bg', $amani['body_bg']));

	$customizer_data .= 'var amani_theme_background = "'.$body_bg.'";';
	$customizer_data .= 'var amani_theme_gradient = "'.$gradient.'";';
	$customizer_data .= 'var amani_theme_color = [];';
	$color_count = 0;
	if(is_array($colors)) {
		foreach ($colors as $value) {
			$customizer_data .= 'amani_theme_color['.$color_count.'] = "'.$value.'";';
			$color_count++;
		}
	}

	wp_add_inline_script('amani-customizer', $customizer_data);
}
add_action('customize_preview_init', 'amani_customizer_live_preview');

// Add body class if featured image exists

function amani_body_class() {
	global $amani, $post;

	if (is_singular()) {
		if(has_post_thumbnail() || is_attachment()) {
			$classes[] = 'has-featured';
		} else {
			$classes[] = 'no-featured';
		}
	}

	$gradient = amani_get_option('gradient', $amani['gradient']);
	if($gradient != 'none') {
		$classes[] = 'has-gradient';
	}

	$body_bg = esc_html(amani_get_option('body_bg', $amani['body_bg']));
	$content_bg = esc_html(amani_get_option('content_bg', $amani['content_bg']));
	if($body_bg == $content_bg) {
		$classes[] = 'body-content-same-color';
	}

	$classes[] = 'b-'.esc_attr(amani_get_option('body_bg_coloring', $amani['body_bg_coloring']));
	$classes[] = 'c-'.esc_attr(amani_get_option('content_bg_coloring', $amani['content_bg_coloring']));

	if(is_active_sidebar('woocommerce') || is_active_sidebar('sidebar')) {
		$classes[] = 'sidebar_position-'.esc_attr(amani_get_option('sidebar_position', $amani['sidebar_position']));
	} else {
		$classes[] = 'sidebar_position-hidden';
	}

	$classes[] = 'style_set-'.esc_attr(amani_get_option('style_set', $amani['style_set']));
	$classes[] = 'blog_layout-'.esc_attr(amani_get_option('blog_layout', $amani['blog_layout']));
	$classes[] = 'header_layout-'.esc_attr(amani_get_option('header_layout', $amani['header_layout']));
	$classes[] = 'top_featured_layout-'.esc_attr(amani_get_option('top_featured_layout', $amani['top_featured_layout']));

	$checkboxes = array('social_share', 'infinite_scroll', 'colored_categories');

	foreach ($checkboxes as $value) {
		$set_opt = '';
		$set_opt = amani_get_option($value, $amani[$value]);
		if($set_opt == 1) {
			$classes[] = $value;
		}
	}

	$ret_classes = '';

	foreach ($classes as $value) {
		$ret_classes .= $value.' ';
	}

	return $ret_classes;
}

// Previous / Next navigation in Archive

function amani_content_nav() {
	the_posts_pagination(array(
		'mid_size'	=> 2,
		'prev_text' => '&larr; '.esc_html__('Previous', 'amani'),
		'next_text' => esc_html__('Next', 'amani').' &rarr;',
	));
}

function amani_copyright() {
	$current_theme = wp_get_theme();
	$empty_footer = '&copy; '.date('Y').' '.ucfirst(get_bloginfo('name')) . '. '.esc_html__('Made with', 'amani').' <i class="fas fa-heart"></i> '.esc_html__('by', 'amani').' <a href="'.$current_theme->get('AuthorURI').'">'.$current_theme->get('Author').'</a>';
	$copyright = amani_get_option('footer_text', $empty_footer);
	if($copyright == '') {
		$copyright = $empty_footer;
	}
	return $copyright;
}

// Excluding Featured category from the_category

function amani_exclude_home($query) {
	global $amani;
	if($query->is_main_query() && $query->is_home()) {
		if(amani_get_option('exclude_categories', 0)) {
			$excluded_cats = '';
			foreach ($amani['featured_locations'] as $value) {
				$excluded_cats .= '-';
				$excluded_cats .= (int) amani_get_option($value);
				$excluded_cats .= ' ';
			}
			$query->set('cat', $excluded_cats);
		}
	}
}
add_action('pre_get_posts', 'amani_exclude_home');

// Excluding Featured category from the_category

function amani_exclude_featured_cat($cats) {
	global $amani;
	// Not on admin pages
	if(!is_admin()) {
		if(amani_get_option('hide_categories_meta', 0)) {
			// checking if set
			foreach ($amani['featured_locations'] as $value) {
				$excluded_cats = (int) amani_get_option($value);
				if($excluded_cats) {
					foreach ($cats as $i=>$cat){
						if($cat->cat_ID == $excluded_cats) {
							unset($cats[$i]);
						}
					}
				}
			}
		}
	}
	return $cats;
}
add_filter('get_the_categories', 'amani_exclude_featured_cat');

// Colors for styles.php	

function amani_css_list($arr, $hover='') {
	global $amani;
	$ret = '';
	foreach($arr as $key) {
		$body_coloring = amani_get_option('body_bg_coloring', $amani['body_bg_coloring']);
		$content_coloring = amani_get_option('content_bg_coloring', $amani['content_bg_coloring']);
		$ret .= '.b-'.$body_coloring.''.$key.$hover.', ';
		$ret .= '.c-'.$content_coloring.''.$key.$hover.', ';
	}
	return substr($ret, 0, -2); // Removing last comma ;)
}

// Colors for Customizer API

function amani_css_list_js($arr) {
	global $amani;
	$ret = '';
	foreach($arr as $key) {
		foreach ($amani['colorings'] as $value) {
			$ret .= "'.b-".$value."".$key."', ";
			$ret .= "'.c-".$value."".$key."', ";
		}
	}
	return substr($ret, 0, -2); // Removing last comma ;)
}

// Social Networks for Plugin API

function amani_social_networks() {
	global $amani;
	return $amani['social'];
}

// Colors for Category Color Plugin

function amani_api_color_scheme() {
	global $amani;
	if(isset($amani['colors'])) {
		$colors = $amani['colors'];
	} else {
		$color_scheme = amani_get_option('color_scheme', $amani['color_scheme']);
		if($color_scheme != 'custom') {
			$colors = explode(' ', $color_scheme);
		} else {
			$colors[0] = esc_html(amani_get_option('color1', $amani['color1']));
			$colors[1] = esc_html(amani_get_option('color2', $amani['color2']));
		}
		$amani['colors'] = $colors;
	}
	return $colors;
}

// Category Color

function amani_category_color($category) {
	global $amani;

	$color = '';

	if(function_exists('bekento_category_color')) {
		$color = bekento_category_color($category);
	}
	if($color) {
		$color = 'background-color: '.$color.';';
	} else {
		$color = '';
	}

	return $color;
}

// Large numbers can sometimes break the layout

function amani_min_number($num) {

	if($num>1000000000) {
		return round(($num/1000000000),1).'B';
	}
	else if($num>1000000) {
		return round(($num/1000000),1).'M';
	}

	return number_format($num);
}

// Logo Image / Text

function amani_theme_logo() {

	global $amani;

	$logo = '';
	$logo .= "<div class='logo-wrap'>";

		$amani_logo_img = '';
		$amani_logo = esc_url(amani_get_option('logo'));
		if($amani_logo || is_customize_preview()) {
			if(esc_attr(amani_get_option('retina', 1))) {
				$amani_logo_img = '<img srcset="'.$amani_logo.' 2x" alt="'.get_bloginfo('name').'" />';
			} else {
				$amani_logo_img = '<img src="'.$amani_logo.'" alt="'.get_bloginfo('name').'" />';
			}
			$logo .= "<div class='logo logo-image'>";
			$logo .= "<a href='".esc_url(home_url('/'))."'>".$amani_logo_img."</a>";
			$logo .= "</div>";
		}

		$amani_logo_text = '<span>'.get_bloginfo('name').'</span>';
		$amani_lead_text = esc_html(amani_get_option('lead_text'));
		if(!$amani_lead_text) {
			$amani_lead_text = get_bloginfo('description');
		}
		
		$logo .= "<div class='logo logo-text'>";
		$logo .= "<a href='".esc_url(home_url('/'))."'>".$amani_logo_text."</a>";
		$logo .= "</div>";
		$logo .= "<div class='lead'>".$amani_lead_text."</div>";

	$logo .= "</div>";

	return $logo;
}

// Remove WooCommerce Styling (We have our own!)

function remove_woocommerce() {
	if(class_exists('WooCommerce')) {
		add_filter('woocommerce_enqueue_styles', '__return_empty_array');
	}
}

// Deregister Simple Twitter Tweets style as it ruins the layout sometimes and we have our own styles for this plugin

function amani_deregister_stt() {
	wp_deregister_style('PI_stt_front');
}
add_action('wp_enqueue_scripts', 'amani_deregister_stt', 50);