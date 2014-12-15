<?php
 get_header(); ?>
<div id="content">
	<ul class="post">
		<li><b>FOUR OH FOUR</b> / FILE NOT FOUND</li>
		<li>Things change. What you're looking for has probably never existed, or has been moved, deleted or *gasp* lost. While you're here, though, <a href="<?php echo get_option('home'); ?>/">why not have a look around?</a>
		</li>
	</ul>
	<ul class="post">
		<li><b>FIND</b> / SEARCH</li>
		<li>
			<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
				<input type="text" class="search_input" value="Type and hit return..." name="s" id="s" onfocus="if (this.value == 'Type and hit return...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type and hit return...';}" />
				<input type="hidden" id="searchsubmit" value="Search" />
			</form>
		</li>
	</ul>

<?php if ( function_exists('akpc_most_popular')) :?>
	<ul class="featured">
		<li><b>FEATURED</b> / FAVORITE POSTS</li>
  	<?php akpc_most_popular(); ?>
	</ul>  	      
<?php endif; ?>
</div><!-- end content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>