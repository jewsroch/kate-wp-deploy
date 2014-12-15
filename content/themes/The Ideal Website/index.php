

<?php
 get_header(); ?>



<?php get_sidebar(); ?>
	
		<?php

		
			//query_posts('category_name=homepage&showposts=1'); 
			query_posts('showposts=1'); ?>
			
  			<?php while (have_posts()) : the_post(); ?>
				<div class="post" id="post-<?php the_ID(); ?>">

				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h1>

				

				<div class="entry">
					<?php 
					
					the_content('Read the rest of this entry &raquo;'); ?>
					<?php //echo $post->post_content; ?>

				</div>

				</div>


			<?php endwhile; ?>

<h1>More Entries</h1>
<ul><li><?php get_archives( 'postbypost', '15', 'custom', '</li><li>'); ?></li></ul>    


<?php get_footer(); ?>