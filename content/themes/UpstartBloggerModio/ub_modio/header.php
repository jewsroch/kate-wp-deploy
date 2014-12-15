<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php
 language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?>
		</title>
		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie.css">
		<![endif]-->

<?php wp_head(); ?>
	</head>
	<body>
		<div class="page">
			<div id="header">
				<a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a> / <span class="description"><?php bloginfo('description'); ?></span><span style="float:right;"><a href="<?php bloginfo('rss2_url'); ?>" title="">
						<img src="<?php bloginfo('template_url'); ?>/images/rss_black.png" alt="<?php bloginfo('name'); ?> Feed" width="14" height="14"/>
					</a>
				</span>
			</div><!-- end header -->