

<?php


/*

Template Name: Archives

*/

?>



<?php get_header(); ?>

			

<?php get_sidebar(); ?>	



<? the_post(); ?>

<h1><?php the_title() ?></h1>

<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

<ul class="arrows"><?php get_archives( 'postbypost', '45', 'custom', '<li>', '</li>'); ?></ul>   



<p><?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?></p>



<?php get_footer(); ?>