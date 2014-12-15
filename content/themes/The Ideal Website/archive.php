<?php
 get_header(); ?>





		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

<?php /* If this is a category archive */ if (is_category()) { ?>				

		'<?php echo single_cat_title(); ?>' Category</em></h1>

		

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>

		<?php the_time('F jS, Y'); ?></em></h1>
		

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>

		<?php the_time('F, Y'); ?></em></h1>

			

	  <?php /* If this is a search */ } elseif (is_search()) { ?>

		Search Results</em></h1>

		

	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>

		Author Archive</em></h1>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

		Blog Archives</em></h1>

		<?php } ?>



		<?php while (have_posts()) : the_post(); ?>

		<div class="post">

				<h1 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>

				<small><?php the_time('l, F jS, Y') ?></small>



				<div class="entry">

					<?php the_content() ?>

				</div>

		

			<!--	<p class="postmetadata">Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p> 

-->

			</div>

	

		<?php endwhile; ?>

		<p>

			<?php next_posts_link('&laquo; Previous Entries') ?>   <?php previous_posts_link('Next Entries &raquo;') ?>

		</p>

	

	<?php else : ?>

		<h2 class="center">Not Found</h2>

		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>




<?php get_sidebar(); ?>	

<?php get_footer(); ?>