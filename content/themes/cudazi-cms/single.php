<?php

get_header();
?>
	<?php if(get_columns($post->ID) == 1){ ?>
		<div class="grid_12">
	<?php }else{ ?>
		<div class="grid_8">
	<?php } ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<div class="postdate"><small><?php the_time('F jS, Y') ?> by <?php the_author(); ?></small></div>
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="postmeta">
				<span><?php the_category(', ') ?></span>
				<?php the_tags('<span>', ' ', '</span>'); ?>
				<?php comments_popup_link('<span>No Comments</span>', '<span>1 Comment</span>', '<span>% Comments</span>'); ?>
				<?php edit_post_link('Edit', '<span>', '</span>'); ?>
			</div>
			
			<?php the_content('Read More...'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			<hr />
			
			<p><small>
				<?php post_comments_feed_link('Comments RSS'); ?>

				<?php if ( comments_open() && pings_open() ) {
				// Both Comments and Pings are open ?>
				You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

				<?php } elseif ( !comments_open() && pings_open() ) {
				// Only Pings are Open ?>
				Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

				<?php } elseif ( comments_open() && !pings_open() ) {
				// Comments are open, Pings are not ?>
				You can skip to the end and leave a response. Pinging is currently not allowed.

				<?php } elseif ( !comments_open() && !pings_open() ) {
				// Neither Comments, nor Pings are open ?>
				Both comments and pings are currently closed.

				<?php } edit_post_link('Edit this entry','','.'); ?>
			</small></p>
				
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

</div>

<?php if(get_columns($post->ID) == 1){ ?>
	<!-- Second Column Hidden -->
<?php }else{ ?>
	<div class="grid_4">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-all') ) : ?><?php endif; ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-post') ) : ?><?php endif; ?>
	</div>
<?php } ?>
	

<?php get_footer(); ?>