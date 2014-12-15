<?php

/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<div id="content">
	<ul class="post">
		<li><b>ARCHIVES</b> / IT'S ALL GOOD</li>
		<li>Looking for something? It's probably in here somewhere. Have a look around. Explore the archives by time or by topic. Or give the search a spin.
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
	<ul class="post">
		<li><b>TIME</b> / ARCHIVES BY MONTH</li>
			<?php wp_get_archives('type=monthly'); ?>
	</ul>
	<ul class="post">
		<li><b>TOPICS</b> / ARCHIVES BY SUBJECT</li>
			 <?php wp_list_categories('title_li='); ?>
	</ul>
</div><!-- end content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>