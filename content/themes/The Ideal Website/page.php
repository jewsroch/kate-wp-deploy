

<?php
 get_header(); ?>

<?php get_sidebar(); ?>



    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

		<h1><?php the_title(); ?></h1>

			<div class="entrytext">

				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

	

				<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>

	

			</div>

		</div>

	  <?php endwhile; endif; ?>

	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>









<?php get_footer(); ?>