<?php
 get_header(); ?>
<div id="content">

		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
	<ul class="post">
		<li><b>ARCHIVE</b> / <?php echo single_cat_title(); ?></li>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<ul class="post">
			<li><b>ARCHIVE</b> / <?php the_time('F jS, Y'); ?></li>

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<ul class="post">
				<li><b>ARCHIVE</b> / <?php the_time('F, Y'); ?></li>
		
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<ul class="post">
					<li><b>ARCHIVE</b> / <?php the_time('Y'); ?></li>
		
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
					<ul class="post">
						<li><b>ARCHIVE</b> / AUTHOR ARCHIVE</li>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<ul class="post">
							<li><b>ARCHIVE</b> / BLOG ARCHIVE</li>
							
		<?php /* If this is a  archive */ } else { ?>
						<ul class="post">
							<li><b>ARCHIVE</b> / TAG ARCHIVE</li>

		<?php } ?>

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
						<p class="post"><?php next_posts_link('&laquo; Previous Entries') ?></p>
						<p class="post"><?php previous_posts_link('Next Entries &raquo;') ?></p>
	<?php else : ?>
						<h2 class="center">Not Found</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>