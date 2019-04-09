<?php if(is_active_sidebar('woocommerce') || is_active_sidebar('sidebar')) { ?>
	<aside class='main-sidebar sidebar'>
		<?php 
			if(class_exists('WooCommerce')) {
				if(is_woocommerce()) {
					if(is_active_sidebar('woocommerce')) {
						dynamic_sidebar('woocommerce');
					} else {
						dynamic_sidebar('sidebar');
					}
				} else {
					dynamic_sidebar('sidebar');
				}
			} else {
				dynamic_sidebar('sidebar');
			}
		?>
	</aside>
<?php } ?>