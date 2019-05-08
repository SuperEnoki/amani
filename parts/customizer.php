<?php

// Theme Customizer Options for Appearance > Customize

function amani_customize_register($wp_customize) {

	global $amani;

	// Multiple Select

	class amani_Customize_Control_Multiple_Select extends WP_Customize_Control {

		public $type = 'multiple-select';

		public function render_content() {

		if (empty($this->choices))
			return;
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
			<select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
				<?php
				foreach ($this->choices as $value => $label) {
					$selected = (in_array($value, $this->value())) ? selected(1, 1, false) : '';
					echo '<option value="'.esc_attr($value).'"'.$selected.'>'.$label.'</option>';
				}
				?>
			</select>
		</label>
		<p class="description"><?php esc_html_e('Multiple values can be selected using cmd / ctrl click. Deselect using cmd /ctrl', 'amani'); ?></p>
		<?php }
	}

	// List all google fonts

	$fonts_arr = array_combine($amani['default_fonts'], $amani['default_fonts']);
	$fonts = get_transient('amani_google_fonts');
	if($fonts === false) {
		$fonts = wp_remote_fopen('https://fonts.google.com/metadata/fonts');
		$fonts = str_replace(")]}'", "", $fonts);
		$fonts = json_decode($fonts);
		set_transient('amani_google_fonts', $fonts, 604800);
	}
	if($fonts) {
		foreach($fonts->familyMetadataList as $font) {
			$fonts_arr[$font->family] = $font->family;
		}
	}

	//	=============================
	//	= Header
	//	=============================

	$wp_customize->add_section('amani_options[header]', array(
		'title' => esc_html__('Header', 'amani'),
		'description' => esc_html__('Easily customize your website header. Detailed info in Documentation', 'amani'),
		'priority' => 20,
	));

	// Header Layout

	if($amani['header_layout'] != '') {
		$header_layouts = array_flip($amani['header_layouts']);

		$wp_customize->add_setting('amani_options[header_layout]', array(
			'default' => $amani['header_layout'],
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'transport' => 'postMessage'
		));
		$wp_customize->add_control('amani_options[header_layout]', array(
			'settings' => 'amani_options[header_layout]',
			'label' => esc_html__('Header Layout', 'amani'),
			'section' => 'amani_options[header]',
			'type' => 'select',
			'choices' => $header_layouts,
		));
	}

	// Logo Font

	$wp_customize->add_setting('amani_options[logo_font]', array(
		'default' => $amani['logo_font'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[logo_font]', array(
		'settings' => 'amani_options[logo_font]',
		'label' => esc_html__('Logo Font', 'amani'),
		'section' => 'amani_options[header]',
		'type' => 'select',
		'choices' => $fonts_arr,
	));

	// Logo Font Size

	$wp_customize->add_setting('amani_options[logo_size]', array(
		'default' => $amani['logo_size'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[logo_size]', array(
		'label' => esc_html__('Logo Font Size', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[logo_size]',
	));

	// Logo Uppercase

	$wp_customize->add_setting('amani_options[logo_uppercase]', array(
		'default' => $amani['logo_uppercase'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[logo_uppercase]', array(
		'settings' => 'amani_options[logo_uppercase]',
		'label' => esc_html__('Uppercase', 'amani'),
		'section' => 'amani_options[header]',
		'type' => 'checkbox',
	));

	// Logo Font Weight

	$wp_customize->add_setting('amani_options[logo_weight]', array(
		'default' => $amani['logo_weight'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[logo_weight]', array(
		'settings' => 'amani_options[logo_weight]',
		'label' => esc_html__('Logo Font Weight', 'amani'),
		'section' => 'amani_options[header]',
		'type' => 'select',
		'choices' => $amani['weight_list'],
	));

	// Logo Italic

	$wp_customize->add_setting('amani_options[logo_italic]', array(
		'default' => $amani['logo_italic'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[logo_italic]', array(
		'label' => esc_html__('Italic', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[logo_italic]',
		'type' => 'checkbox',
	));

	// Tagline

	$wp_customize->add_setting('amani_options[lead]', array(
		'default' => $amani['lead'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[lead]', array(
		'label' => esc_html__('Show Tagline', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[lead]',
		'type' => 'checkbox',
	));

	// Tagline Text

	$wp_customize->add_setting('amani_options[lead_text]', array(
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'transport' => 'postMessage',
		'type' => 'option',
	));

	$wp_customize->add_control('amani_options[lead_text]', array(
		'label' => esc_html__('Tagline', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[lead_text]',
		'type' => 'textarea',
	));

	// Logo Image

	$wp_customize->add_setting('amani_options[logo]', array(
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'amani_options[logo]', array(
		'label' => esc_html__('Logo Image', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[logo]',
	)));

	// Retina Logo

	$wp_customize->add_setting('amani_options[retina]', array(
		'default' => true,
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[retina]', array(
		'label' => esc_html__('Retina Logo', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[retina]',
		'type' => 'checkbox',
	));
	
	// Show People in Header Users Select

	$blogusers = array(0 => 'None');
	$blogusers_raw = get_users([
		'role__in' => ['author', 'editor', 'administrator'],
	]);
	foreach ($blogusers_raw as $user) {
		$blogusers[$user->ID] = $user->user_login;
	}

	$wp_customize->add_setting('amani_options[featured_users]', array(
		'default' => '',
		'sanitize_callback' => 'esc_sql',
		'capability' => 'edit_theme_options',
		'type' => 'option'
	));
	$wp_customize->add_control(new amani_Customize_Control_Multiple_Select($wp_customize, 'amani_options[featured_users]', array(
		'settings' => 'amani_options[featured_users]',
		'label' => esc_html__('Featured Users', 'amani'),
		'section' => 'amani_options[header]', // Enter the name of your own section
		'type' => 'multiple-select', // The $type in our class
		'choices' => $blogusers // Your choices
		)
	));
	
	// Header Instagram Username

	$wp_customize->add_setting('amani_options[header_instagram]', array(
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option'
	));
	$wp_customize->add_control('amani_options[header_instagram]', array(
		'label' => esc_html__('Instagram Username', 'amani'),
		'section' => 'amani_options[header]',
		'settings' => 'amani_options[header_instagram]',
	));

	//	=============================
	//	= Content
	//	=============================

	$wp_customize->add_section('amani_options[content]', array(
		'title' => esc_html__('Content', 'amani'),
		'description' => esc_html__('Customize your content styling. Detailed info in Documentation', 'amani'),
		'priority' => 30,
	));


	if($amani['style_set'] != '') {
		foreach ($amani['style_sets'] as $key => $value) {
			$style_sets[$key] = $key;
		}

		// Style Sets

		$wp_customize->add_setting('amani_options[style_set]', array(
			'default' => $amani['style_set'],
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'type' => 'option'
		));
		$wp_customize->add_control('amani_options[style_set]', array(
			'settings' => 'amani_options[style_set]',
			'label' => esc_html__('Style Set', 'amani'),
			'section' => 'amani_options[content]',
			'type' => 'select',
			'choices' => $style_sets,
		));
	}

	// Color Schemes

	$color_schemes = array_flip($amani['color_schemes']);
	$wp_customize->add_setting('amani_options[color_scheme]', array(
		'default' => $amani['color_scheme'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[color_scheme]', array(
		'settings' => 'amani_options[color_scheme]',
		'label' => esc_html__('Accent Color Scheme', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $color_schemes,
	));

	// Accent Color

	$wp_customize->add_setting('amani_options[color1]', array(
		'default' => $amani['color1'],
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'amani_options[color1]', array(
		'label' => esc_html__('Primary Accent Color', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[color1]',
	)));

	// 2nd Color

	$wp_customize->add_setting('amani_options[color2]', array(
		'default' => $amani['color2'],
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'amani_options[color2]', array(
		'label' => esc_html__('Secondary Color (Set as primary color if not needed)', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[color2]',
	)));

	// Colored Categories

	$wp_customize->add_setting('amani_options[colored_categories]', array(
		'default' => $amani['colored_categories'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[colored_categories]', array(
		'label' => esc_html__('Enable Colored Categories', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[colored_categories]',
		'type' => 'checkbox',
	));

	// Headings Font

	$wp_customize->add_setting('amani_options[heading_font]', array(
		'default' => $amani['heading_font'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[heading_font]', array(
		'settings' => 'amani_options[heading_font]',
		'label' => esc_html__('Headings Font', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $fonts_arr,
	));

	// Headings Uppercase

	$wp_customize->add_setting('amani_options[heading_uppercase]', array(
		'default' => $amani['heading_uppercase'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[heading_uppercase]', array(
		'settings' => 'amani_options[heading_uppercase]',
		'label' => esc_html__('Uppercase', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'checkbox',
	));

	// Headings Font Weight

	$wp_customize->add_setting('amani_options[heading_weight]', array(
		'default' => $amani['heading_weight'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[heading_weight]', array(
		'settings' => 'amani_options[heading_weight]',
		'label' => esc_html__('Headings Font Weight', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $amani['weight_list'],
	));

	// Headings Italic

	$wp_customize->add_setting('amani_options[heading_italic]', array(
		'default' => $amani['heading_italic'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[heading_italic]', array(
		'settings' => 'amani_options[heading_italic]',
		'label' => esc_html__('Italic', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'checkbox',
	));

	// Post Title Font Size

	$wp_customize->add_setting('amani_options[heading_size]', array(
		'default' => $amani['heading_size'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[heading_size]', array(
		'label' => esc_html__('Post Title Font Size', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[heading_size]',
	));

	// Body Font

	$wp_customize->add_setting('amani_options[body_font]', array(
		'default' => $amani['body_font'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[body_font]', array(
		'settings' => 'amani_options[body_font]',
		'label' => esc_html__('Body Font', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $fonts_arr,
	));

	// Body Gradient

	$gradients = array_flip($amani['gradients']);

	$wp_customize->add_setting('amani_options[gradient]', array(
		'default' => $amani['gradient'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[gradient]', array(
		'settings' => 'amani_options[gradient]',
		'label' => esc_html__('Body Gradient', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $gradients,
	));

	$colorings = array_flip($amani['colorings']);

	// Body Background

	$wp_customize->add_setting('amani_options[body_bg]', array(
		'default' => $amani['body_bg'],
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'amani_options[body_bg]', array(
		'label' => esc_html__('Body Background', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[body_bg]',
	)));

	$wp_customize->add_setting('amani_options[body_bg_coloring]', array(
		'default' => $amani['body_bg_coloring'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[body_bg_coloring]', array(
		'settings' => 'amani_options[body_bg_coloring]',
		'label' => esc_html__('Body Background Theme', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $colorings,
	));

	// Content Background

	$wp_customize->add_setting('amani_options[content_bg]', array(
		'default' => $amani['content_bg'],
		'sanitize_callback' => 'sanitize_hex_color',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'amani_options[content_bg]', array(
		'label' => esc_html__('Content Background', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[content_bg]',
	)));

	$wp_customize->add_setting('amani_options[content_bg_coloring]', array(
		'default' => $amani['content_bg_coloring'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[content_bg_coloring]', array(
		'settings' => 'amani_options[content_bg_coloring]',
		'label' => esc_html__('Content Background Theme', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $colorings,
	));

	// Top Featured Layouts

	if($amani['top_featured_layout'] != '') {
		$top_featured_layouts = array_flip($amani['top_featured_layouts']);

		$wp_customize->add_setting('amani_options[top_featured_layout]', array(
			'default' => $amani['top_featured_layout'],
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'transport' => 'postMessage'
		));
		$wp_customize->add_control('amani_options[top_featured_layout]', array(
			'settings' => 'amani_options[top_featured_layout]',
			'label' => esc_html__('Top Featured Layout', 'amani'),
			'section' => 'amani_options[content]',
			'type' => 'select',
			'choices' => $top_featured_layouts,
		));
	}

	// Sidebar Position

	if($amani['sidebar_position'] != '') {
		$sidebar_positions = array_flip($amani['sidebar_positions']);

		$wp_customize->add_setting('amani_options[sidebar_position]', array(
			'default' => $amani['sidebar_position'],
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'transport' => 'postMessage'
		));
		$wp_customize->add_control('amani_options[sidebar_position]', array(
			'settings' => 'amani_options[sidebar_position]',
			'label' => esc_html__('Sidebar Position', 'amani'),
			'section' => 'amani_options[content]',
			'type' => 'select',
			'choices' => $sidebar_positions,
		));
	}

	// Blog Layout

	if($amani['blog_layout'] != '') {
		$blog_layouts = array_flip($amani['blog_layouts']);

		$wp_customize->add_setting('amani_options[blog_layout]', array(
			'default' => $amani['blog_layout'],
			'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
			'type' => 'option',
			'transport' => 'postMessage'
		));
		$wp_customize->add_control('amani_options[blog_layout]', array(
			'settings' => 'amani_options[blog_layout]',
			'label' => esc_html__('Blog Layout', 'amani'),
			'section' => 'amani_options[content]',
			'type' => 'select',
			'choices' => $blog_layouts,
		));
	}

	// Social Share

	$wp_customize->add_setting('amani_options[social_share]', array(
		'default' => $amani['social_share'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[social_share]', array(
		'label' => esc_html__('Show Social Share Under Post', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[social_share]',
		'type' => 'checkbox',
	));

	// Infinite Scroll

	$wp_customize->add_setting('amani_options[infinite_scroll]', array(
		'default' => $amani['infinite_scroll'],
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[infinite_scroll]', array(
		'label' => esc_html__('Infinite Scroll', 'amani'),
		'section' => 'amani_options[content]',
		'settings' => 'amani_options[infinite_scroll]',
		'type' => 'checkbox',
	));

	// Featured Categories

	$blogcats = array(0 => 'Hidden');
	$blogcats_raw = get_categories();
	foreach ($blogcats_raw as $blogcat) {
		$blogcats[$blogcat->cat_ID] = $blogcat->name;
	}

	$wp_customize->add_setting('amani_options[top_featured_category]', array(
		'default' => 0,
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option'
	));
	$wp_customize->add_control('amani_options[top_featured_category]', array(
		'settings' => 'amani_options[top_featured_category]',
		'label' => esc_html__('Top Featured Category', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'select',
		'choices' => $blogcats,
	));

	$wp_customize->add_setting('amani_options[exclude_categories]', array(
		'default' => 0,
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[exclude_categories]', array(
		'settings' => 'amani_options[exclude_categories]',
		'label' => esc_html__('Exclude Featured Categories from Home Page', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('amani_options[hide_categories_meta]', array(
		'default' => 0,
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[hide_categories_meta]', array(
		'settings' => 'amani_options[hide_categories_meta]',
		'label' => esc_html__('Hide Featured Categories from Meta', 'amani'),
		'section' => 'amani_options[content]',
		'type' => 'checkbox',
	));

	//	=============================
	//	= Footer
	//	=============================

	$wp_customize->add_section('amani_options[footer]', array(
		'title' => esc_html__('Footer', 'amani'),
		'description' => esc_html__('Easily customize your website footer. Detailed info in Documentation', 'amani'),
		'priority' => 40,
	));

	// Show People in Footer

	$wp_customize->add_setting('amani_options[featured_users_footer]', array(
		'sanitize_callback' => 'esc_sql',
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option'
	));
	$wp_customize->add_control(new amani_Customize_Control_Multiple_Select($wp_customize, 'amani_options[featured_users_footer]', array(
		'settings' => 'amani_options[featured_users_footer]',
		'label' => esc_html__('Featured Users', 'amani'),
		'section'  => 'amani_options[footer]', // Enter the name of your own section
		'type'     => 'multiple-select', // The $type in our class
		'choices'  => $blogusers // Your choices
		)
	));

	// Copyright Text

	$wp_customize->add_setting('amani_options[footer_text]', array(
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('amani_options[footer_text]', array(
		'label' => esc_html__('Copyright Text', 'amani'),
		'section' => 'amani_options[footer]',
		'settings' => 'amani_options[footer_text]',
		'type' => 'textarea',
	));

	// Footer Instagram Username

	$wp_customize->add_setting('amani_options[footer_instagram]', array(
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
		'type' => 'option'
	));
	$wp_customize->add_control('amani_options[footer_instagram]', array(
		'label' => esc_html__('Instagram Username', 'amani'),
		'section' => 'amani_options[footer]',
		'settings' => 'amani_options[footer_instagram]',
	));

	//	=============================
	//	= Font Charsets
	//	=============================

	$wp_customize->add_section('amani_options[typography]', array(
		'title' => esc_html__('Font Charsets', 'amani'),
		'description' => esc_html__('Chustomize character sets for selected fonts', 'amani'),
		'priority' => 41,
	));

	// Charsets

	$wp_customize->add_setting('amani_options[font_char_latin_ext]', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[font_char_latin_ext]', array(
		'settings' => 'amani_options[font_char_latin_ext]',
		'label' => esc_html__('Latin Extended', 'amani'),
		'section' => 'amani_options[typography]',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('amani_options[font_char_cyrillic]', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[font_char_cyrillic]', array(
		'settings' => 'amani_options[font_char_cyrillic]',
		'label' => esc_html__('Cyrillic', 'amani'),
		'section' => 'amani_options[typography]',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('amani_options[font_char_cyrillic_ext]', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[font_char_cyrillic_ext]', array(
		'settings' => 'amani_options[font_char_cyrillic_ext]',
		'label' => esc_html__('Cyrillic Extended', 'amani'),
		'section' => 'amani_options[typography]',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('amani_options[font_char_greek]', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[font_char_greek]', array(
		'settings' => 'amani_options[font_char_greek]',
		'label' => esc_html__('Greek', 'amani'),
		'section' => 'amani_options[typography]',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('amani_options[font_char_greek_ext]', array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
	));
	$wp_customize->add_control('amani_options[font_char_greek_ext]', array(
		'settings' => 'amani_options[font_char_greek_ext]',
		'label' => esc_html__('Greek Extended', 'amani'),
		'section' => 'amani_options[typography]',
		'type' => 'checkbox',
	));

	//	=============================
	//	= Social
	//	=============================

	$wp_customize->add_section('amani_options[social]', array(
		'title' => esc_html__('Social Networks', 'amani'),
		'description' => esc_html__('In this section you can set up social networks. Liks should be with full url e.g. https://www.instagram.com/doyoutravel/', 'amani'),
		'priority' => 50,
	));

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

		$wp_customize->add_setting('amani_options['.$amani_social_title.']', array(
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
			'type' => 'option',
		));
		$wp_customize->add_control('amani_options['.$amani_social_title.']', array(
			'label' => ucwords($amani_social_title),
			'section' => 'amani_options[social]',
			'settings' => 'amani_options['.$amani_social_title.']',
		));
	}
}
add_action('customize_register', 'amani_customize_register');