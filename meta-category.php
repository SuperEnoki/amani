<div class='post-category'>
	<?php
	$categories = get_the_category(get_the_ID());
	foreach($categories as $category) {
		echo '<a href="'.esc_url(get_category_link($category->term_id)).'" style="'.esc_attr(amani_category_color($category->term_id)).'">'.esc_html($category->name).'</a>'.'';
	}
	?>
</div>