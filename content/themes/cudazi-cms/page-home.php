<?php

/*
Template Name: Home Template
*/
?>
<?php get_header(); ?>
<?php 
	// set include_cycle_plugin to true which includes
	// additional JavaScript on this page only
	$include_cycle_plugin = true;
	
	// Display slider
	display_slider(); 
?>
<div class="home-columns">
	<?php
	
		$home_display_set = false;
		// DEFAULT Home Style: Post, Post, News
		if($custom_settings["home_display_style"] == "post|post|news" || empty($custom_settings["home_display_style"]))
		{
			echo display_home_columns(2,4);
			echo display_news($custom_settings);
			$home_display_set = true;
		}
		// Home Style: News, Post, Post
		if($custom_settings["home_display_style"] == "news|post|post")
		{
			echo display_news($custom_settings);
			echo display_home_columns(2,4);
			$home_display_set = true;
		}
		// Home Style: Post, Post, Post
		if($custom_settings["home_display_style"] == "post|post|post")
		{
			echo display_home_columns(3,4);
			$home_display_set = true;
		}
		
		
		
		// Home Style: Widget, Widget, Widget
		if($custom_settings["home_display_style"] == "widget|widget|widget")
		{
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home-1') ) : endif; 
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home-2') ) : endif; 
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home-3') ) : endif; 
			$home_display_set = true;
		}
		// Home Style: Widget, Widget, News
		if($custom_settings["home_display_style"] == "widget|widget|news")
		{
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home-1') ) : endif; 
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home-2') ) : endif; 
			echo display_news($custom_settings);
			$home_display_set = true;
		}
		
		
		
		
		
		
		// Home Style: Double-wide Post, News
		
		if($custom_settings["home_display_style"] == "doublepost|news")
		{
			echo display_home_columns(1,8);
			echo display_news($custom_settings);
			$home_display_set = true;
		}
		// Home Style: News, Double-wide Post
		if($custom_settings["home_display_style"] == "news|doublepost")
		{
			echo display_news($custom_settings);
			echo display_home_columns(1,8);
			$home_display_set = true;
		}
		// Home Style: Triple-wide post
		if($custom_settings["home_display_style"] == "triplepost")
		{
			echo display_home_columns(1,12);
			$home_display_set = true;
		}
		
		if($home_display_set == false)
		{
			echo "<p class='grid_12'>Error: Home page layout not found in custom settings page.</p>";
		}
	?>
</div>
<?php get_footer(); ?>