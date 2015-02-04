<?php

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Sidebar',
        'before_widget' => '<div class="block %1$s %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Blurb',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
	
if ( function_exists('register_sidebar') )
register_sidebar(array(
	'name' => 'Top Navigation',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => '',
));

add_filter( 'got_rewrite', '__return_true' );


function remove_version() {
    return '';
}
add_filter('the_generator', 'remove_version');

define('DISALLOW_FILE_EDIT', true);
remove_action('wp_head', 'wlwmanifest_link');