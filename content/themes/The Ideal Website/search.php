


<?php
 get_header(); ?>



<h2>Search Results</h2>



			<h4><?php next_posts_link('&laquo; Previous Entries') ?></h4>

			<h4><?php previous_posts_link('Next Entries &raquo;') ?></h4>

	<?php if (have_posts()) : ?>

		

		<?php while (have_posts()) : the_post(); ?>

			

			<div class="post">

				<p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></p>

				

		        

				

			</div>

	</small>

		<?php endwhile; ?>



		

			<h4><?php next_posts_link('&laquo; Previous Entries') ?></h4>

			<h4><?php previous_posts_link('Next Entries &raquo;') ?></h4>

	

	<?php else : ?>



		<h2 class="center">No posts found. Try a different search?</h2>

		<?php include (TEMPLATEPATH . '/searchform.php'); ?>



	<?php endif; ?>

		

	</div>





<?php get_footer(); ?>