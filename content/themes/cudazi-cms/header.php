<?php
 global $custom_settings; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('-', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/960.css" type="text/css" media="screen" />
		<link rel="shortcut icon" href="http://www.katekorroch.com/wp-content/themes/cudazi-cms/images/favicon.ico" />
		
		<style type="text/css"><?php include_once (TEMPLATEPATH . "/dynamic-css.php"); ?></style>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php echo html_entity_decode($custom_settings["extra"]["head"], ENT_QUOTES); ?>
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
		
		<div class="outer clearfix container_12">
			
			<div class="grid_9">
				<a href="<?php bloginfo('url'); ?>"><img src="<?php if($custom_settings["logo"]) { echo $custom_settings["logo"]; }else{ echo get_bloginfo('template_directory') . "/images/logo.gif"; } ?>" alt="Logo" /></a>
			</div>
			
			<div class="header-search grid_3">
				<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			</div>
			
			<div class="grid_12">
				<div class="menu">
					<ul class="sf-menu">
						
						<?php wp_list_pages("sort_column=menu_order&sort_order=DESC&title_li=&depth=".$custom_settings["menu_depth"]."&exclude=".$custom_settings["menu_exclude"]); ?>
					</ul>
				</div>
			</div>
			<div class="grid_12"><hr /></div>