<?php

get_header(); ?>
	<?php if(get_columns($post->ID) == 1){ ?>
		<div class="grid_12">
	<?php }else{ ?>
		<div class="grid_8">
	<?php } ?>
	
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post">
				<h2><?php the_title(); ?></h2>
				<div><?php the_content(custom_read_more()); ?></div>
			</div>
			<div class="postnavigation"><?php wp_link_pages(array('before' => '<p>Pages: ', 'after' => '</p>', 'next_or_number' => 'number')); ?></div>
			<?php edit_post_link('Edit this entry', '<p><small>', '</small></p>'); ?>
		<?php endwhile; else: ?>
			<p>Page not found.</p>
		<?php endif; ?>
	</div>
	
	<?php if(get_columns($post->ID) == 1){ ?>
		<!-- Second Column Hidden -->
	<?php }else{ ?>
		<div class="grid_4">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-all') ) : ?><?php endif; ?>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-page') ) : ?><?php endif; ?>
		</div>
	<?php } ?>
	
<?php get_footer(); ?>