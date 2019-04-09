<?php /* Template Name: Full-width */ ?>

<?php get_header(); ?>

<div class='content'>

	<?php while (have_posts()) : the_post(); ?>

		<?php the_content(esc_html__('Continue Reading', 'amani')); ?>

	<?php endwhile; ?>

</div><!-- .content -->

<?php get_footer(); ?>