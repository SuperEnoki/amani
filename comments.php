<?php
if (post_password_required()) {
	return;
}
?>

<div class='comments'>

	<?php if(have_comments()) : ?>

	<a name='comments'></a>

	<h3><?php comments_number(); ?></h3>

	<ol class='list-comments'>
		<?php wp_list_comments(array('avatar_size' => 256, 'short_ping'  => true)); ?>
	</ol>

	<nav class='navigation'>
		<?php paginate_comments_links(); ?>
	</nav>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
	?>
	
	<div class='comments-closed'><?php esc_html_e('Comments are closed', 'amani'); ?></div>
	
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->