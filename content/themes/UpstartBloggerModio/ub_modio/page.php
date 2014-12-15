<?php
 get_header(); ?>
<div id="content" class="widecolumn">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div><!-- end entry -->
	</div><!-- end post -->
		
		<?php endwhile; endif; ?><br/><br/>
			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>