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
	<p class="post"><?php next_posts_link('&laquo; Previous Entries') ?></p>
	<p class="post"><?php previous_posts_link('Next Entries &raquo;') ?></p>
	<?php else : ?>
	<ul class="post">
		<li><b>FOUR OH FOUR</b> / FILE NOT FOUND</li>
		<li>Things change. What you're looking for has probably been moved, changed, delted or *gasp* lost. While you're here, though, why not have a look around?
		</li>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
 <?php endif; ?>
</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>