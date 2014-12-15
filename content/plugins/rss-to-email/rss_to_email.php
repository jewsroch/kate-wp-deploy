<?php

/*
Plugin Name: RSS to Email
Plugin URI: http://rss2email.me/wordpress
Description: This plugin generates a widget that allows visitors to easily subscribe via email to blog updates using the RSS2Email.me service
Version: 0.2
Author: MinneApp, LLC
Author URI: http://www.minneapp.com
*/


/* -------- RSS to Email Widget Code  --------*/
add_action("plugins_loaded", "rssToEmail_init");
function rssToEmail_init() {
  wp_register_sidebar_widget('widget_rssToEmail', 'RSS to Email', 'widget_rssToEmail');
}

function widget_rssToEmail($args) {
  extract($args);
  echo $before_widget;
  echo $before_title;?>RSS to Email<?php echo $after_title;
  rssToEmailHtml();
  echo $after_widget;
}

function rssToEmailHtml() {
  if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
  $rssfeed = get_bloginfo("rss_url");
  echo "<a href='http://rss2email.me/referrer_subscribe?rss=".$rssfeed."' ".
    "title='RSS to Email' ".
    "target='_blank'>".
    "<img src='".WP_PLUGIN_URL."/rss-to-email/images/rss_to_email_button.png' ".
    "name='rss_to_email_button' ".
    "title='RSS to Email' alt='RSS to Email' ".
    "onmouseover=\"document.rss_to_email_button.src='".WP_PLUGIN_URL."/rss-to-email/images/rss_to_email.png'\" ".
    "onmouseout=\"document.rss_to_email_button.src='".WP_PLUGIN_URL."/rss-to-email/images/rss_to_email_button.png'\" ".
    "style=\"".get_option('rssToEmail_style')."\" />".
    "</a>";
	
}



/* -------- RSS to Email Administration -------- */
add_action('admin_menu', 'rssToEmail_menu');

function rssToEmail_menu() {	
	add_options_page('Display RSS to Email Options', 'RSS to Email', 'administrator', __FILE__, 'rssToEmail_options_page');
}

function rssToEmail_options_page() {
	include ('rssToEmail-options.php');
}




/* -------- RSS to Email Insert In Meta Widget -------- */
/* Thanks to "Customize Meta Widget" @ http://jehy.ru/wp-plugins.en.html */
add_action('widgets_init', 'rssToEmail_replace_meta_widget');
function rssToEmail_replace_meta_widget() {
  if ( get_option('rssToEmail_metaWidget') == "true" ) {
    unregister_sidebar_widget ('meta');
    $widget_ops = array('classname' => 'widget_meta', 'description' => __( "Log in/out, admin, feed and WordPress links") );
    wp_register_sidebar_widget('meta', __('Meta'), 'rssToEmail_wp_widget_meta_modified', $widget_ops);
  }
}

function rssToEmail_wp_widget_meta_modified($args) {
  $rssfeed = get_bloginfo("rss2_url");
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __('Meta') : apply_filters('widget_title', $options['title']);
  ?>
  <?php echo $before_widget; ?>
  <?php echo $before_title . $title . $after_title;
  ?>
  <ul>
  <?php wp_register();?>
  <li><?php wp_loginout(); ?></li>
  <li><a href="http://rss2email.me/referrer_subscribe?rss=<?php echo $rssfeed; ?>" title="RSS to Email" target="_blank">RSS to Email</a></li>
  <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo attribute_escape(__('Syndicate this site using RSS 2.0')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
  <li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo attribute_escape(__('The latest comments to all posts in RSS')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
  <?php wp_meta(); ?>
  </ul>
  <?php
  echo $after_widget; 
}
?>