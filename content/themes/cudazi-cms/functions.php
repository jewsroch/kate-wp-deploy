<?php

global $custom_settings;
$custom_settings = get_custom_settings(); 
automatic_feed_links();

// Adding Custom Admin Settings Page
add_action('admin_menu', 'theme_settings'); 
add_action('admin_head', 'theme_styles');
function theme_settings() { 
	add_menu_page('Theme Settings', 'Theme Settings', 'edit_themes', __FILE__, 'theme_settings_form');
}

// display the settings form on the custom settings admin page
function theme_settings_form(){ 
	global $custom_settings;
	
    if(isset($_POST['submit-updates']) && $_POST['submit-updates'] == "yes"){

		$custom_settings["default_columns"] = $_POST["options"]["default_columns"];
		$custom_settings["menu_exclude"] = $_POST["options"]["menu_exclude"];
		$custom_settings["footer_text"] = stripslashes(htmlentities($_POST["options"]["footer_text"], ENT_QUOTES));
		$custom_settings["posts"]["read_more_text"] = stripslashes($_POST["options"]["posts"]["read_more_text"]);
		$custom_settings["extra"]["head"] = stripslashes(htmlentities($_POST["options"]["extra"]["head"], ENT_QUOTES));
		$custom_settings["extra"]["footer"] = stripslashes(htmlentities($_POST["options"]["extra"]["footer"], ENT_QUOTES));
		$custom_settings["home_display_style"] = $_POST["options"]["home_display_style"];
		$custom_settings["home_news_title"] = stripslashes($_POST["options"]["home_news_title"]);
		$custom_settings["home_news_length"] = $_POST["options"]["home_news_length"];
		$custom_settings["home_news_max"] = $_POST["options"]["home_news_max"];
		$custom_settings["home_news_cat"] = $_POST["options"]["home_news_cat"];
		$custom_settings["home_column_cat"] = $_POST["options"]["home_column_cat"];
		$custom_settings["logo"] = $_POST["options"]["logo"];
		$custom_settings["background"] = $_POST["options"]["background"];
		$custom_settings["css"]["links"] = $_POST["options"]["css"]["links"];
		$custom_settings["css"]["links_hover"] = $_POST["options"]["css"]["links_hover"];
		$custom_settings["css"]["extra"] = $_POST["options"]["css"]["extra"];
		$custom_settings["promo_config"]["speed"] = $_POST["options"]["promo_config"]["speed"];
		$custom_settings["promo_config"]["timeout"] = $_POST["options"]["promo_config"]["timeout"];
		$custom_settings["promo_config"]["fx"] = $_POST["options"]["promo_config"]["fx"];
		
		// Update Social Media
		for($i=0; $i <= 15; $i++)
		{
			$custom_settings["social_media"][$i]["icon"] = $_POST["options"]["social_media"][$i]["icon"];
			$custom_settings["social_media"][$i]["url"] = $_POST["options"]["social_media"][$i]["url"];
		}
		
		for($i=0; $i < 15; $i++)
		{
			$custom_settings["promo"][$i]["photo"] = $_POST["options"]["promo"][$i]["photo"];
			$custom_settings["promo"][$i]["url"] = $_POST["options"]["promo"][$i]["url"];
			$custom_settings["promo"][$i]["title"] = stripslashes($_POST["options"]["promo"][$i]["title"]);
		}
		
		// *************************************************
		// pass array into custom settings row in DB
		update_option("custom_settings", $custom_settings);
		// *************************************************
		
        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Saved Settings!</strong></p></div>";
    }
?>
<div class="wrap">
	<form method="post" name="brightness" target="_self" class="adminoptions">
		<h1>Theme Settings</h1>
		<h3 style="color:#990000;">Please read through all settings to find helpful tips and best practice information.</h3>
		<input type="submit" name="Submit" value="Save Settings" />
		
		<h2>General Settings</h2>
		<div class="field inset">
			<label>Exclude From Main Menu</label>
			<small>Enter the page id/ids to exclude and separate each with a comma.<br />Example: 1&nbsp;&nbsp;Example: 1,2&nbsp;&nbsp; Example:12,22</small>
			<div><input name="options[menu_exclude]" value="<?php echo $custom_settings["menu_exclude"]; ?>" class="textbox-small" /></div>
			<small><a href="http://www.google.com/search?q=how+to+find+page+ID+wordpress" target="_blank">How to find Page IDs</a></small>
			<small>Please note, the main menu aligns to the right, this means to move items left, set page order higher.</small>
		</div>
		
		<div class="field inset">
			<label>Column Setup</label>
			<small>Control whether your "blog posts page" displays in a single column or the standard two.</small>
			<small>Set to <strong>1</strong> for a single column layout, enter 2 or leave empty to keep the standard 2-column layout.</small>
			<div><input name="options[default_columns]" value="<?php echo $custom_settings["default_columns"]; ?>" class="textbox-small" /></div>
			<small>This will also control the search and archive pages since they use the same template.</small>
			<small>Note: See the instructions for this theme when setting up a page to display all your blog posts on a specific page.</small>
			<small>You can also control the columns on a per-post or per-page basis, see the instructions.</small>
		</div>
		
		<div class="field inset">
			<label>Footer Text</label>
			<div><input name="options[footer_text]" value="<?php echo $custom_settings["footer_text"]; ?>" class="textbox-large" /></div>
		</div>
		<div class="field inset">
			<label>Custom "Read More..." Text</label>
			<small>Also override with custom field: <strong>readmore</strong> on a specific post.</small>
			<div><input name="options[posts][read_more_text]" value="<?php echo $custom_settings["posts"]["read_more_text"]; ?>" class="textbox-large" /></div>
		</div>
		<div class="field inset">
			<label>Additional &lt;head&gt; HTML.</label>
			<div><textarea name="options[extra][head]" class="textarea-large" ><?php echo $custom_settings["extra"]["head"]; ?></textarea></div>
		</div>
		<div class="field inset">
			<label>Additional footer HTML, right before the closing  &lt;/body&gt; tag.</label>
			<div><textarea name="options[extra][footer]" class="textarea-large" ><?php echo $custom_settings["extra"]["footer"]; ?></textarea></div>
		</div>
		
		<h2>Home Page Setup / Layout</h2>
		<p>If you do not use the custom home page template, you can ignore this section.</p>
		<p>Create a page in wordpress using the "Home" page template.<br />Then, in Settings > Reading Settings > Front Page Displays - Set this new "home" page as your home.</p>
		<div class="field inset">
			<label>Home Page Content Layout</label>
			<small>The content below the home page promo items.</small>
			<?php echo $current = $custom_settings["home_display_style"]; ?>
			<select name="options[home_display_style]">
				<option value="post|post|news" <?php if(empty($current) || $current=="post|post|news"){ echo "selected='selected'"; } ?>>Post | Post | News (Default Layout)</option>
				<option value="news|post|post" <?php if($current=="news|post|post"){ echo "selected='selected'"; } ?>>News | Post | Post</option>
				<option value="post|post|post" <?php if($current=="post|post|post"){ echo "selected='selected'"; } ?>>Post | Post | Post</option>
				<option value="widget|widget|widget" <?php if($current=="widget|widget|widget"){ echo "selected='selected'"; } ?>>Widget | Widget | Widget (new)</option>
				<option value="widget|widget|news" <?php if($current=="widget|widget|news"){ echo "selected='selected'"; } ?>>Widget | Widget | News (new)</option>
				<option value="doublepost|news" <?php if($current=="doublepost|news"){ echo "selected='selected'"; } ?>>Doule-Width Post | News</option>
				<option value="news|doublepost" <?php if($current=="news|doublepost"){ echo "selected='selected'"; } ?>>News | Double-Width Post</option>
				<option value="triplepost" <?php if($current=="triplepost"){ echo "selected='selected'"; } ?>>Single, Full Width Post</option>
			</select>
			<small>If layout above includes "News", please use the settings below:</small>
		
			<div class="field inset2">
				<label>Home: News Heading</label>
				<small>Default is "Latest News"</small>
				<div><input name="options[home_news_title]" value="<?php echo $custom_settings["home_news_title"]; ?>" class="textbox-medium" /></div>
			</div>
			<div class="field inset2">
				<div><input name="options[home_news_length]" value="<?php echo $custom_settings["home_news_length"]; ?>" class="textbox-small" /> Maximum Characters of Home News Story (Default: 100)</div>
				<div><input name="options[home_news_max]" value="<?php echo $custom_settings["home_news_max"]; ?>" class="textbox-small" /> Maximum News Items on Home (Default: 2)</div>
			</div>
			<div class="field inset2">
				<label>Home: News Category ID Number</label>
				<small>Enter the category id, ids to include or exclude.<br />Separate each with a comma and use - to exclude a category.<br />Example: 1&nbsp;&nbsp;Example: 1,2&nbsp;&nbsp;Example:12,-22</small>
				<div><input name="options[home_news_cat]" value="<?php echo $custom_settings["home_news_cat"]; ?>" class="textbox-small" /></div>
				<small><a href="http://www.google.com/search?q=how+to+find+category+ID+wordpress" target="_blank">How to find Category IDs</a></small>
			</div>
			<div class="field inset2">
				<label>Home: Posts Category ID Number</label>
				<small>Enter the category id, ids to include or exclude.<br />Separate each with a comma and use - to exclude a category.<br />Example: 1&nbsp;&nbsp;Example: 1,2&nbsp;&nbsp;Example:12,-22</small>
				<div><input name="options[home_column_cat]" value="<?php echo $custom_settings["home_column_cat"]; ?>" class="textbox-small" /></div>
				<small><a href="http://www.google.com/search?q=how+to+find+category+ID+wordpress" target="_blank">How to find Category IDs</a></small>
			</div>
		</div>
		
		
		
		
		<h2>Social Media</h2>
		<div class="field inset">
		<label>Footer Social Media Icons</label>
		<small>Choose an icon on the left, your URL at the right.<br />To add more icons to the dropdown lists, place images in the <strong>images/social</strong> folder inside this theme. (24x24px works perfect)</small>
		<?php for($i=0; $i <= 15; $i++) { ?>
			<div><select name="options[social_media][<?php echo $i; ?>][icon]"><?php echo list_social_icons($custom_settings['social_media'][$i]['icon']); ?></select>
			<input name="options[social_media][<?php echo $i; ?>][url]" value="<?php echo $custom_settings["social_media"][$i]["url"]; ?>" class="textbox-large" /></div>
		<?php } ?>
		</div>
		
		
		<h2>Styles / Colors / Logo</h2>
		<div class="field inset"><label>Custom Logo URL</label>
		<small>You may also just overwrite logo.gif in this theme's /images/ folder with your own.</small>
        <input name="options[logo]" value="<?php echo $custom_settings["logo"]; ?>" class="textbox-large" />
		</div>
		<div class="field inset">
		<label>Background URL</label>
		<small>You may also just overwrite bg.gif in this theme's /images/ folder with your own.</small>
			<input name="options[background]" value="<?php echo $custom_settings["background"]; ?>" class="textbox-large" />
		</div>
		<div class="field inset">
		<label>Main Colors</label>
		<small>Advanced users may just want to edit the style.css file directly or enter custom styles below.</small>
			<div style="clear:both;">
					<div class="column">
						<div><input name="options[css][links]" value="<?php echo $custom_settings["css"]["links"]; ?>" class="textbox-small" /> Link Color</div>
						<div><input name="options[css][links_hover]" value="<?php echo $custom_settings["css"]["links_hover"]; ?>" class="textbox-small" /> Link Hover Color</div>
					</div>
					<div class="column">
						
					</div>
					<br clear="all" />
			</div>
		</div>
		<div class="field inset">
			<label>Custom / Add-On CSS</label>
			<small>This CSS will be added after all other styles have been applied.</small>
			<textarea class="textarea-large" name="options[css][extra]"><?php echo $custom_settings["css"]["extra"]; ?></textarea>
		</div>
		
		<h2>Home Page Promos</h2>
		<div class="field inset">
			<label>General Settings</label>
			<div><input name="options[promo_config][speed]" value="<?php echo $custom_settings["promo_config"]["speed"]; ?>" class="textbox-small" /> Transition speed in milliseconds (Default:1000)</div>
			<div><input name="options[promo_config][timeout]" value="<?php echo $custom_settings["promo_config"]["timeout"]; ?>" class="textbox-small" /> Pause between slides in milliseconds (Default:3000)</div>
			<div>
				<input name="options[promo_config][fx]" value="<?php echo $custom_settings["promo_config"]["fx"]; ?>" class="textbox-small" /> Slide Transition (Default: fade)
				<small>Examples: fade, scrollLeft, ScrollDown, toss, etc...
				<br />Visit the <a href="http://www.google.com/search?q=jQuery+Cycle+Plugin+Effects" target="_blank">jQuery Cycle Effects Browser</a> for a full list.</small>
			</div>
		</div>
		
		<div class="field inset">
			<label>Promo Items</label>
			<?php for($i=0; $i<15; $i++) { ?>
			<div class="field inset2">
				<small><strong>Promo Item <?php echo $i+1; ?></strong></small>
				<div><input name="options[promo][<?php echo $i; ?>][title]" value="<?php echo $custom_settings["promo"][$i]["title"]; ?>" class="textbox-small" /> Link Title</div>
				<div><input name="options[promo][<?php echo $i; ?>][url]" value="<?php echo $custom_settings["promo"][$i]["url"]; ?>" class="textbox-medium" /> Link URL (External/Internal)</div>
				<div><input name="options[promo][<?php echo $i; ?>][photo]" value="<?php echo $custom_settings["promo"][$i]["photo"]; ?>" class="textbox-large" /> Photo URL</div>
			</div>
			<?php } ?>
			
		</div>
		
		
		<input name="submit-updates" type="hidden" value="yes" />
		<br /><br /><br /><br />
	</form>
</div>
<?php 
}

// Add Dashboard Head CSS to custom settings page
function theme_styles() { 
	echo "<style type=\"text/css\"> 
	.adminoptions label { display: block; font-weight:bold; } 
	.adminoptions .field { padding:5px 0; } 
	.adminoptions small { display:block; } 
	.adminoptions .textbox-small { width:100px; } 
	.adminoptions .textbox-med-small { width:175px; } 
	.adminoptions .textbox-medium { width:250px; } 
	.adminoptions .textbox-large { width:350px; } 
	.adminoptions .textarea-small { width:350px; height:50px; } 
	.adminoptions .textarea-medium { width:450px; height:50px; } 
	.adminoptions .textarea-large { width:500px; height:100px; } 
	.adminoptions .inset { padding-left:20px; margin:15px 0;  border-left:2px dotted #ccc; } 
	.adminoptions .inset2 { padding-left:20px; margin:15px 20px;  } 
	.adminoptions .column { float:left; width:350px; } 
	</style>";
}


//
// Gets custom settings array.
// If not set in DB, inserts defaults below for the first run
// and then pulls in settings from DB from then on.
//
function get_custom_settings()
{
	$custom_settings_array = get_option("custom_settings");
	
	if(!empty($custom_settings_array))
	{
		// Custom Settings set, pull from DB
		$s = $custom_settings_array;
	}else{
		// First time run, custom settings NOT set, use defaults, save to DB.
		// manually set
		$s["home_news_dots"] = true; 
		$s["menu_depth"] = 2;
		$s["home_news_length"] = 100;
		$s["home_display_style"] = "post|post|news";
		$s["home_news_title"] = "Latest News";
		$s["footer_text"] = "Copyright Your name here. Designed by Curt Ziegler for ThemeForest.net";
		$s["posts"]["read_more_text"] = "Continue Reading...";
		$s["css"]["links"] = "#336699";
		$s["css"]["links_hover"] = "#990000";
		$s["promo_config"]["speed"] = 1000;
		$s["promo_config"]["timeout"] = 3000;
		$s["promo_config"]["fx"] = "fade";
		// *********
		
		
		// set defaults into DB
		update_option("custom_settings", $s);
	}
	
	return $s;
}


// show news?
function display_home_columns($max,$colspan=4)
{
	global $custom_settings;
	global $more; // needed to display "more link"
	$more = 0;  // needed to display "more link"
	$cat = "";
	$content = "";
	query_posts("cat=".$custom_settings["home_column_cat"]."&showposts=".$max);
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		$content .= "<div class='grid_".$colspan."'>";
		$content .= "<h3><a href='" . get_permalink() . "'>" . get_the_title() . "</a></h3>";
		$content .= get_the_content_formatted();
		$content .= "</div>";
	endwhile; else:
	endif;
	wp_reset_query();
	return $content;
}

// lists all thumbnails in the "social_icons" directory
function list_social_icons($id)
{
	$list_of_icons = "";
	$list_of_icons .= "<option value=''>None</option>";
	if ($handle = opendir(TEMPLATEPATH . "/images/social")) {
		while (false !== ($file = readdir($handle))) {
			if (preg_match("/^.*\.(jpg|jpeg|png|gif)$/i", $file)) {
				
				if($file == $id)
				{
					$list_of_icons .= "<option selected='selected'>";
				}else{
					$list_of_icons .= "<option>";
					//$list_of_icons .= "<!-- test: File: ".$file." id: " .$id. "-->";
				}
				$list_of_icons .= "$file</option>";
			}
			
		}
		closedir($handle);
		return $list_of_icons;
	}
}


function display_news()
{
	global $custom_settings;
	//$custom_settings = get_custom_settings(); // grab custom wp settings array
	if(empty($custom_settings["home_news_title"])) { $title = "Latest News"; }
	
	$content = "";
	$content .= "<div class='grid_4'>";
	$content .= "<div class='latest-posts'><h3>".$custom_settings["home_news_title"]."</h3><ul>";
	query_posts("cat=".$custom_settings["home_news_cat"]."&showposts=".$custom_settings["home_news_max"]);
	if ( have_posts() ) : while ( have_posts() ) : the_post();
		$content .= "<li class='clearfix'>";
		$content .= "<div class='date left'><div class='small'>".get_the_time('M')."</div><div class='large'>".get_the_time('d')."</div></div>";
		$content .= "<div class='summary left'><p><a href='" . get_permalink() . "'><strong>". get_the_title() ."</strong><br />";
		$content .= chopstring(get_the_excerpt(),$custom_settings["home_news_length"],$custom_settings["home_news_dots"]) ."</a></p></div>";
		$content .= "</li>";
	endwhile; else:
	endif;
	$content .= "</ul></div>";
	$content .= "</div>";
	wp_reset_query();
	return $content;
}


function chopstring($str, $max, $dots=true)
{
	if(strlen($str) > $max)
	{
		$str = substr($str, 0, $max);
	}
	if($dots)
	{
		$str .= "...";
	}
	return $str;
}

//
//	Since get_the_content loses the formatting, we need to do some hacking...
//
function get_the_content_formatted ($stripteaser = 0, $more_file = '') {
	global $custom_settings;
	$content = get_the_content(custom_read_more(), $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}


//
// Display social media icons from custom settings area in footer.
function display_social_icons()
{
	global $custom_settings;
	$count = 0;
	$output = "";
	$icon_list = "";
	if(!empty($custom_settings["social_media"]))
	{
		foreach($custom_settings["social_media"] as $key => $value){
			if(!empty($value["icon"]) && !empty($value["url"]))
			{
				$icon_list .= "&nbsp;<a href='".$value["url"]."'><img src='" . get_bloginfo("template_directory") . "/images/social/" .$value["icon"]."' alt='Social Media Icon' /></a>";
				$count++;
			}
		}
	}
	if($count > 0)
	{
		$output = "<div class='right softbutton'>" . $icon_list . "</div>";
	}
	return $output;
}


//
//	Display home slider.
function display_slider()
{
	$promo_output = "";
	global $custom_settings;
	$promo_ouput .= "<div id='promo-container' class='grid_12'><div id='promos' class='clearfix'>";
	
	$item_count = 0;
	foreach($custom_settings["promo"] as $key => $value){
		if(!empty($value["photo"]) && !empty($value["title"]))
		{
			if(empty($value["url"])){ $item_url = "#"; }else{ $item_url = $value["url"]; } 
			if($item_count > 0) { $hidden = " hidden"; }
			$promo_ouput .= "<div class='promo".$hidden."'><a href='".$item_url."'><img src='".$value["photo"]."' alt='".$value["title"]."' /></a></div>";
			$item_count++;
		}
	}
	$promo_ouput .= "</div><div id='promo-nav' class='clearfix'><ul>";
	foreach($custom_settings["promo"] as $key => $value){
		if(!empty($value["photo"]) && !empty($value["title"]))
		{
			if(empty($value["url"])){ $item_url = "#"; }else{ $item_url = $value["url"]; } 
			$promo_ouput .= "<li><a href='".$item_url."'>".$value["title"]."</a></li>";
		}
	}
	$promo_ouput .= "</ul></div></div>";
	
	if($item_count > 0)
	{
		echo $promo_ouput;
	}else{
		echo "<!-- No Promos -->";
	}
	
}


function get_columns($postID)
{
	$columns = get_post_meta($postID, "columns", true);
	return $columns;
}

// Display custom read-more link.
function custom_read_more()
{
	global $custom_settings;
	global $post;
	$readmore_text = get_post_meta($post->ID, "readmore", true);
	if(empty($readmore_text))
	{
		$readmore_text = $custom_settings["posts"]["read_more_text"];
	}
	return $readmore_text;
}



// creating sidebars
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name'=>'sidebar-all',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="sidebar">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=>'sidebar-blog',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="sidebar">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=>'sidebar-page',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="sidebar">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=>'sidebar-post',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="sidebar">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	));
	
	register_sidebar(array(
		'name'=>'sidebar-home-1',
		'before_widget' => '<div id="%1$s" class="grid_4 widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=>'sidebar-home-2',
		'before_widget' => '<div id="%1$s" class="grid_4 widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name'=>'sidebar-home-3',
		'before_widget' => '<div id="%1$s" class="grid_4 widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	
}





?>