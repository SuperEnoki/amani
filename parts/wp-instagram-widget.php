<?php 

// Instagram Helper

echo '<li class="' . esc_attr($liclass) . '">
	<a href="' . esc_url($item['link']) . '" target="' . esc_attr($target) . '"	class="' . esc_attr($aclass) . '"><img src="' . esc_url($item[$size]) . '"	alt="' . wp_trim_words(esc_attr($item['description']), 20) . '" class="' . esc_attr($imgclass) . '"/></a>
	<div class="instagram-meta">
		<span><i class="far fa-heart"></i> ' . amani_min_number(esc_attr($item['likes'])) . '</span>
		<span><i class="far fa-comment"></i> ' . amani_min_number(esc_attr($item['comments'])) . '</span>
	</div>
</li>';

?>