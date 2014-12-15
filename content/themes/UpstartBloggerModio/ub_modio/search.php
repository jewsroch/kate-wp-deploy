<?php
 get_header(); ?>
<div id="content">
	<ul class="post">
		<li><b>SEARCH</b> / LOOK WHAT WE FOUND</li>

<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
		<li id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
				
					<?php
					if ( function_exists('the_excerpt_reloaded')) {
the_excerpt_reloaded(15, '', 'excerpt', FALSE, '[more]', FALSE, 1, TRUE);
}
	else {
	the_excerpt();
	}
?>
			<p class="postmetadata">Posted on <?php the_time('M d.y') ?> to <?php the_category(', ') ?> &nbsp; <?php comments_popup_link('Add a Comment', '1 Comment', '% Comments'); ?> &nbsp;&nbsp;<?php edit_post_link('Edit', '', ''); ?>
			</p>
		</li>


		<?php endwhile; ?>
	</ul>
	<ul class="post">
		<li><b>TRY</b> / AGAIN?</li>
		<li>
			<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
				<input type="text" class="search_input" value="Type and hit enter..." name="s" id="s" onfocus="if (this.value == 'Type and hit enter...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type and hit enter...';}" />
				<input type="hidden" id="searchsubmit" value="Search" />
			</form>
		</li>
	</ul><br/><br/>
	<p class="post"><?php next_posts_link('&laquo; Previous Entries') ?></p>
	<p class="post"><?php previous_posts_link('Next Entries &raquo;') ?></p>
	<?php else : ?>
	<li>Hmm. Nothing. That's not what either one of us expected.</li>
	</ul>
	<ul class="post">
		<li><b>TRY</b> / AGAIN?</li>
		<li>
			<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
				<input type="text" class="search_input" value="Type and hit enter..." name="s" id="s" onfocus="if (this.value == 'Type and hit enter...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type and hit enter...';}" />
				<input type="hidden" id="searchsubmit" value="Search" />
			</form>
		</li>
	</ul><br/><br/>

	<?php endif; ?>
</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>