<?php
 get_header(); ?>
<div id="content" class="widecolumn">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
				
			<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div><!-- end entry --><br/><br/>
	</div><!-- end post -->
	<ul class="post">
		<li><b>META</b> / ABOUT THIS POST</li>
		<li>This entry was posted
						<?php /* This is commented, because it requires a little adjusting sometimes.
							You'll need to download this plugin, and follow the instructions:
							http://binarybonsai.com/archives/2004/08/17/time-since-plugin/ */
							/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
			on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
			and is filed under <?php the_category(', ') ?>. <?php if (function_exists('the_tags') ) : ?>
<?php the_tags(); ?>.
<?php endif; ?>
			You can follow any responses to this entry through the <?php comments_rss_link('RSS 2.0'); ?> feed.

						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
			You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(true); ?>" rel="trackback">trackback</a> from your own site.

						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
			Responses are currently closed, but you can <a href="<?php trackback_url(true); ?> " rel="trackback">trackback</a> from your own site.

						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
			You can skip to the end and leave a response. Pinging is currently not allowed.

						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
			Both comments and pings are currently closed.

						<?php } edit_post_link('Edit this entry.','',''); ?>
		</li>
	</ul><br/><br/>
	<ul class="post">
		<li><b>PAGES</b> / FORWARD OR BACK?</li>
		<li><?php previous_post_link('Previous: %link','%title') ?></li>
		<li><?php next_post_link('Next: %link','%title') ?></li>
	</ul><br/><br/>
					
				<?php if ( function_exists('related_posts')) :?>
	<ul class="post">
		<li><b>RELATED</b> / YOU MIGHT FIND THESE INTERESTING</li>
		<?php related_posts(); ?>
	</ul>
<?php endif; ?>			
			
	<?php comments_template(); ?>

	<?php endwhile; else: ?>
	<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>
</div><!-- end content -->	
<?php get_sidebar(); ?>
<?php get_footer(); ?>