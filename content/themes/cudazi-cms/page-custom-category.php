<?php

/*
Template Name: Custom Category
*/
?>
<?php get_header(); ?>
	<?php if(get_columns($post->ID) == 1){ ?>
		<div class="grid_12">
	<?php }else{ ?>
		<div class="grid_8">
	<?php } ?>
	
	
	<div class="post">
    	<!--// updated 6.20.10 -->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php the_content(custom_read_more()); ?>
		<?php endwhile; endif; ?>
        <!--// updated 6.20.10 -->
	</div>
	
	<?php 
		$categories = get_post_meta($post->ID, "categories", true);
		if($categories) { $param = "cat=".$categories; }else{ $param = ""; } 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
		query_posts($param . "&paged=" . $paged);
		global $more; $more = 0;
	?>
	
<?php if (have_posts()) : ?>
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
			<?php the_content(custom_read_more()); ?>
			<hr />
		</div>
	<?php endwhile; ?>
	<div class="postnavigation"><span class="older"><?php next_posts_link('Older Entries') ?></span>&nbsp;&nbsp;<span class="newer"><?php previous_posts_link('Newer Entries') ?></span></div>
	<?php else : ?>
		<h2>No Posts Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>
	<?php endif; ?>

	<?php wp_reset_query(); ?>
	<?php edit_post_link('Edit this page', '<p><small>', '</small></p>'); ?>
	</div>
	
	<?php if(get_columns($post->ID) == 1){ ?>
		<!-- Second Column Hidden -->
	<?php }else{ ?>
		<div class="grid_4">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-all') ) : ?><?php endif; ?>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-blog') ) : ?><?php endif; ?>
		</div>
	<?php } ?>
	
<?php get_footer(); ?>