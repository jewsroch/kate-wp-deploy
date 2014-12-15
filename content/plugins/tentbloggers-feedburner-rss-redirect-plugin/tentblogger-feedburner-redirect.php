<?php
/*
Plugin Name: TentBlogger FeedBurner RSS Redirect
Plugin URI: http://tentblogger.com/feedburner-plugin/
Description: This simple (yet effective) plugin redirects the your blog's feed to FeedBurner!
Version: 2.4
Author: TentBlogger
Author URI: http://tentblogger.com
License:

    Copyright 2011 - 2012 TentBlogger (info@tentblogger.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class TentBlogger_FeedBurner {
	 
	/*--------------------------------------------*
	 * Constructors and Filters
	 *---------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {
	
		if(function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('tentblogger-feedburner', false, dirname(plugin_basename(__FILE__)) . '/lang');
		} // end if
		
		if(function_exists('add_action')) {
			add_action('admin_menu', array($this, 'admin'));
			add_action('template_redirect', array($this, 'redirect'));
		} // end if

	} // end constructor
	
	/*--------------------------------------------*
	 * Public Functions
	 *---------------------------------------------*/
	
	/**
	 * Adds the administration menu item to the WordPress administration menu.
	 */
	public function admin() {
		if(function_exists('add_menu_page')) {
			$this->load_file('tentblogger-feedburner-styles', '/tentbloggers-feedburner-rss-redirect-plugin/css/tentblogger-feedburner-admin.css');
      if(!$this->my_menu_exists('tentblogger-handle')) {
        add_menu_page('TentBlogger', 'TentBlogger', 'administrator', 'tentblogger-handle', array($this, 'display'));
      }
      add_submenu_page('tentblogger-handle', 'TentBlogger', 'FeedBurner', 'administrator', 'tentblogger-feedburner-handle', array($this, 'display'));
		} // end if
	} // end admin
	
	/**
	 * Includes the actual plugin administration panel.
	 */
	public function display() {
		if(is_admin()) {
			$is_updated = $this->configuration();
			include_once('tentblogger-feedburner-redirect-dashboard.php');
		} // end if
	} // end display
	
	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/	
	
	/**
	 * Processes and stores the configuration options for the post feed and comment feed
	 * redirection via the dashboard.
	 */
	function configuration() {

		$options = get_option('tentblogger-feedburner');
	
		/* Verify the options are set. If not, initialize them. */
		if(!isset($options['tentblogger-feedburner-feed-url'])) {
			$options['tentblogger-feedburner-feed-url'] = null;
		} // end if
	
		if(!isset($options['tentblogger-comment-feed-url'])) {
			$options['tentblogger-comment-feed-url'] = null;
		} // end if
	
		/* If the user has submitted changes, update the options. */
		$is_updated = false;
		if(isset($_POST['submit'])) {
			
			check_admin_referer('tentblogger-feedburner', 'tentblogger-feedburner-admin');
		
			$rss_feed_url = null;
			if(isset($_POST['tentblogger-feedburner-feed-url'])) {
				$rss_feed_url = $this->fix($_POST['tentblogger-feedburner-feed-url']);
			} // end if
			
			$comment_feed_url = null;
			if(isset($_POST['tentblogger-feedburner-comment-url'])) {
				$comment_feed_url = $this->fix($_POST['tentblogger-feedburner-comment-url']);
			} // end if
			
			$options['tentblogger-feedburner-feed-url'] = $rss_feed_url;
			$options['tentblogger-comment-feed-url'] = $comment_feed_url;
		
			update_option('tentblogger-feedburner', $options);
			$is_updated = true;
			
		} // end if
		
		return $is_updated;
		
	} // end configuration
	
	/**
	 * If the incoming URL is malformed, correct it.
	 *
	 * @url	The incoming feed URL.
	 */
	function fix($url) {
		
		if(strlen(trim($url)) > 0) {
			$url = preg_replace('!^(http|https)://!i', '', $url);
			$url = preg_replace('!^/!i', '', $url);
			$url = 'http://'.$url;
		} // end if
		
		return $url;
		
	} // end fix
	
	/**
	 * Actually redirects the feed based on the configuration options.
	 */
	function redirect() {
	
		global $feed, $withcomments;
		
		if(!is_feed() || preg_match('/feedburner/i', $_SERVER['HTTP_USER_AGENT'])) {
			return;
		}
			
		$rss_feed_url = $this->get_rss_feed_url();
		$comment_feed_url = $this->get_comment_feed_url();
			
		/* If the feed's are specified, redirect... */
		if($rss_feed_url != null || $comment_feed_url != null) {
		
			/* Redirects the comments feed */
			if($feed == 'comments-rss2' || $withcomments) {
				$this->redirect_feed_to($comment_feed_url);
			} else {
				/* Handle other feeds */
				switch($feed) {
					case 'feed':
					case 'rdf':
					case 'rss':
					case 'rss2':
					case 'atom':
						$this->redirect_feed_to($rss_feed_url);
						break;
					default:
						break;
				} // end switch/case
			} // end if/else
	
		} // end if
		
	} // end redirect
	
	/*--------------------------------------------*
	 * Private Functions
	 *---------------------------------------------*/
	
	/**
	 * Returns the value of the RSS Feed URL stored in the options.
	 *
	 * @returns	rss_feed_url	The user-specified RSS feed
	 */
	private function get_rss_feed_url() {
	
		$options = get_option('tentblogger-feedburner');
	
		$rss_feed_url = null;
		if(isset($options['tentblogger-feedburner-feed-url'])) {
			$rss_feed_url = $options['tentblogger-feedburner-feed-url'];
		} // end if
		
		return trim($rss_feed_url);
	
	} // end get_rss_feed_url
	
	/**
	 * Returns the value of the Comment's RSS Feed URL stored in the options.
	 *
	 * @returns	comment_feed_url	The user-specified comment RSS feed
	 */
	private function get_comment_feed_url() {
		
		$options = get_option('tentblogger-feedburner');
		
		$comment_feed_url = null;
		if(isset($options['tentblogger-comment-feed-url'])) {
			$comment_feed_url = $options['tentblogger-comment-feed-url'];
		} // end if
		
		return trim($comment_feed_url);
		
	} // end get_comment_feed_url
	
	/**
	 * Redirects a feed to the specified URL
	 *
	 * @url	The URL to which we're redirecting.
	 */
	function redirect_feed_to($url) {
		if($url != null) {
				header("Location: " . $url);
				die;
		} // end if
	} // end redirect_comment_feed
	
	/**
	 * Helper function for registering and loading scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file($name, $file_path, $is_script = false) {
		$url = WP_PLUGIN_URL . $file_path;
		$file = WP_PLUGIN_DIR . $file_path;
		if(file_exists($file)) {
			if($is_script) {
				wp_register_script($name, $url);
				wp_enqueue_script($name);
			} else {
				wp_register_style($name, $url);
				wp_enqueue_style($name);
			} // end if
		} // end if
	} // end _load_file
		
  /**
   * http://wordpress.stackexchange.com/questions/6311/how-to-check-if-an-admin-submenu-already-exists
   */
  private function my_menu_exists( $handle, $sub = false){
    if( !is_admin() || (defined('DOING_AJAX') && DOING_AJAX) )
      return false;
    global $menu, $submenu;
    $check_menu = $sub ? $submenu : $menu;
    if( empty( $check_menu ) )
      return false;
    foreach( $check_menu as $k => $item ){
      if( $sub ){
        foreach( $item as $sm ){
          if($handle == $sm[2])
            return true;
        }
      } else {
        if( $handle == $item[2] )
          return true;
      }
    }
    return false;
  } // end my_menu_exists
  
} // TentBlogger_FeedBurner
new TentBlogger_FeedBurner();
?>