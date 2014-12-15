<?php
 get_header(); ?>
<div id="content">

	<?php if (have_posts()) : ?>
	<ul class="post">
		<li><b>FRESH</b> / LATEST POSTS</li>
	<?php while (have_posts()) : the_post(); ?>
		<li id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?>
		
		<?php if ( function_exists('the_excerpt_reloaded')) :?>
				<span>
<?php the_excerpt_reloaded(15, '', 'excerpt', FALSE, '[more]', FALSE, 1, TRUE); ?>
				</span>
<?php endif; ?>
			</a>
		</li>		
		<?php endwhile; ?>
	</ul>

		<?php else : ?>
	<h2 class="center">Not Found</h2>
	<p class="center">Sorry, but you are looking for something that isn't here.</p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
		
<?php if ( function_exists('akpc_most_popular')) :?>
	<ul class="post">
		<li><b>FEATURED</b> /  POPULAR POSTS</li>
	  	<?php akpc_most_popular(); ?>
	</ul>  	
<?php endif; ?>

<?php if (function_exists('bdp_comments'))  :?>
	<ul class="post">
		<li><b>FOLLOW</b> /  COMMENTS</li>

<?php bdp_comments($listHowMany='5'); ?>
	</ul>	
<?php endif; ?>
</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>