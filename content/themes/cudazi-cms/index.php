<?php
 get_header(); ?>
<?php global $custom_settings; ?>
<?php if($custom_settings["default_columns"] == 1){ ?>
	<div class="grid_12">
<?php }else{ ?>
	<div class="grid_8">
<?php } ?>

<?php if (have_posts()) : ?>
	<?php if(is_search()) { echo "<p><strong>You searched for: </strong><em>" . $_GET["s"] . "</em></p>"; } ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<p><strong>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</strong></p>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<p><strong>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</strong></p>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<p><strong>Archive for <?php the_time('F jS, Y'); ?></strong></p>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<p><strong>Archive for <?php the_time('F, Y'); ?></strong></p>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<p><strong>Archive for <?php the_time('Y'); ?></strong></p>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<p><strong>Author Archive</strong></p>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<p><strong>Blog Archives</strong></p>
	<?php } ?>
	
	
	
	
	<?php while (have_posts()) : the_post(); ?>
		<div class="postdate"><small><?php the_time('F jS, Y') ?> by <?php the_author(); ?></small></div>
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<div class="postmeta">
			<span><?php the_category(', ') ?></span>
			<?php the_tags('<span>', ' ', '</span>'); ?>
			<?php comments_popup_link('<span>No Comments</span>', '<span>1 Comment</span>', '<span>% Comments</span>'); ?>
			<?php edit_post_link('Edit', '<span>', '</span>'); ?>
		</div>
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php if(!is_search()) { the_content(custom_read_more()); }else{ the_excerpt(); } ?>
			<hr />
		</div>

	<?php endwhile; ?>

	<div class="postnavigation"><span class="older"><?php next_posts_link('Older Entries') ?></span>&nbsp;&nbsp;<span class="newer"><?php previous_posts_link('Newer Entries') ?></span></div>

<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php if(is_search()) { echo "<p><strong>You searched for: </strong><em>" . $_GET["s"] . "</em></p>"; } ?>

<?php endif; ?>
</div>

<?php if($custom_settings["default_columns"] == 1){ ?>
	<!-- Second Column Hidden -->
<?php }else{ ?>
	<div class="grid_4">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-all') ) : ?><?php endif; ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-blog') ) : ?><?php endif; ?>
	</div>
<?php } ?>
<?php get_footer(); ?>