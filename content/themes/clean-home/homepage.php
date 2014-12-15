<?php

/*
Template Name: No-Sidebar
*/
?>

<?php get_header(); ?>

	<div id="content-home">
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
		
		<div class="post">
			<?php the_content('Read the rest of this entry &raquo;'); ?>
		</div>
		
		
		<?php endwhile; ?>

		

	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>

	</div>

<?php get_footer(); ?>