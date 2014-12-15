<?php

/*
Plugin Name: nCode Image Resizer
Plugin URI: http://www.dmry.net/
Description: This plugin enables you to automatically resize every user-posted image which is larger than given dimensions. Original plugin writen by <a href="http://www.ncode.nl/vbulletinplugins/" target="_blank" title="Jorrit Schippers">Jorrit Schippers  for vBulletin</a>.
Author: Hakan Demiray
Version: 1.3
Author URI: http://www.dmry.net/
*/
add_action('init', 'ncode_init');
add_action('admin_menu', 'ncode_options_page');
add_action('activate_ncode-image-resizer/ncode-image-resizer.php','ncode_activate');
add_action('wp_head', 'ncode_wp_head');
add_filter('the_content', 'ncode_the_content',100);

function ncode_init() {
	load_plugin_textdomain('ncode', 'wp-content/plugins/ncode-image-resizer/languages' );
}

function ncode_activate() {
	add_option('ncode_db_surum', 1);
	add_option('ncode_secenekler', array('resizemode'=>'enlarge', 'maxwidth'=>400, 'maxheight'=>''));
}


function ncode_options_page() {
	add_options_page(__('nCode Settings','ncode'), __('nCode Settings','ncode'), 'administrator', basename(__FILE__), 'ncode_options');
}

function ncode_wp_head() {
	$ncode_secenekler = get_option('ncode_secenekler');
	$ncode_plugin_url = WP_CONTENT_URL.'/plugins/ncode-image-resizer/';
?>
<script type="text/javascript" src="<?php echo $ncode_plugin_url; ?>js/ncode_imageresizer.js?v=1.0.1"></script>
<?php if ($ncode_secenekler['resizemode']=='tinybox') { ?>
<script type="text/javascript" src="<?php echo $ncode_plugin_url; ?>js/tinybox.js?v=1.0"></script>
<?php } ?>
<style type="text/css">table.ncode_imageresizer_warning {background: #FFFFE0;color:#333333;border: 1px solid #E6DB55;cursor: pointer;}table.ncode_imageresizer_warning td {font-size: 10px;vertical-align: middle;text-decoration: none; text-align:left; font-family:Verdana, Geneva, sans-serif;}table.ncode_imageresizer_warning td.td1 {padding: 5px;}table.ncode_imageresizer_warning td.td1 {padding: 2px;}
<?php if ($ncode_secenekler['resizemode']=='tinybox') { ?>
#tinybox {position:absolute; display:none; padding:10px; background:#fff url(<?php echo $ncode_plugin_url; ?>images/preload.gif) no-repeat 50% 50%; border:10px solid #e3e3e3; z-index:2000}#tinymask {position:absolute; display:none; top:0; left:0; height:100%; width:100%; background:#000; z-index:1500}#tinycontent {background:#fff}
<?php } ?>
</style>
<script type="text/javascript">
NcodeImageResizer.MODE = '<?php echo $ncode_secenekler['resizemode'];?>';
NcodeImageResizer.MAXWIDTH = <?php if($ncode_secenekler['maxwidth']=='') echo "''"; else echo $ncode_secenekler['maxwidth'];?>;
NcodeImageResizer.MAXHEIGHT = <?php if($ncode_secenekler['maxheight']=='') echo "''"; else echo $ncode_secenekler['maxheight'];?>;
NcodeImageResizer.BBURL = '<?php echo $ncode_plugin_url; ?>images/uyari.gif';
var vbphrase=new Array;
vbphrase['ncode_imageresizer_warning_small'] = '<?php _e('Click this bar to view the full image.', 'ncode'); ?>';
vbphrase['ncode_imageresizer_warning_filesize'] = '<?php _e('This image has been resized. Click this bar to view the full image. The original image is sized %1$sx%2$spx and weights %3$sKB.', 'ncode'); ?>';
vbphrase['ncode_imageresizer_warning_no_filesize'] = '<?php _e('This image has been resized. Click this bar to view the full image. The original image is sized %1$sx%2$spx.', 'ncode'); ?>';
vbphrase['ncode_imageresizer_warning_fullsize'] = '<?php _e('Click this bar to view the small image.', 'ncode'); ?>';
</script>
<?php	
}

function ncode_durum_katman($mesaj, $durum) {
	if($durum == 'guncellendi') $class = 'updated fade';
	elseif($durum == 'hata') $class = 'updated error';
	else $class = $type;
	
	echo '<div id="message" class="'.$class.'"><p>' . __($mesaj, 'ncode') . '</p></div>';
}

function ncode_the_content($content) {
	return preg_replace("/<img([^`|>]*)>/im", "<img onload=\"NcodeImageResizer.createOn(this);\"$1>", $content);
}

function ncode_options() {
	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) die(__('Cheatin&#8217; uh?', 'ncode'));
	if (! user_can_access_admin_page()) wp_die( __('You do not have sufficient permissions to access this page','ncode') );
	
	$array_resizemode = array('none'=>__('Keep original size', 'ncode'), 'enlarge'=>__('Enlarge in same window', 'ncode'), 'samewindow'=>__('Open in same window', 'ncode'), 'newwindow'=>__('Open in new window', 'ncode'), 'tinybox'=>__('Open in modal window', 'ncode'));

	if(isset($_REQUEST['submit']) and $_REQUEST['submit']) {
		$maxwidth = $_POST['maxwidth'];
		$maxheight = $_POST['maxheight'];
		$resizemode = $_POST['resizemode'];
		$varhata=false;
		if(!is_numeric($maxwidth) && !empty($maxwidth)) {
			ncode_durum_katman('Maximum width must be numeric', 'hata');
			$varhata = true;
		} else if(!is_numeric($maxheight) && !empty($maxheight)) {
			ncode_durum_katman('Maximum height must be numeric', 'hata');
			$varhata = true;
		}
		if($varhata==false) {
			$secenekler = compact('maxwidth','maxheight','resizemode');
			update_option('ncode_secenekler', $secenekler);
			ncode_durum_katman('Options updated', 'guncellendi');
		}
		
	}
	$ncode_secenekler = get_option('ncode_secenekler');
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2><?php _e('nCode Settings', 'ncode'); ?></h2>

<form action="" method="post">
<table class="form-table">
<tr valign="top">
<th scope="row"><label for="resizemode"><?php _e('Images in posts', 'ncode'); ?></label></th>
<td>
<select name="resizemode" id="resizemode">
<?php
foreach($array_resizemode as $_value=>$_option) {
	echo "<option value='$_value'". ( ($ncode_secenekler['resizemode']==$_value) ? ' selected="selected"' : ''  ) .">$_option</option>";	
}
?>
</select>

<span class="description"><?php _e('This blog automatically resizes images which are too large. Please choose here how you would like to view the enlarged images.', 'ncode'); ?></span></td>
</tr>
<tr valign="top">

<th scope="row"><label for="maxwidth"><?php _e('Maximum width', 'ncode'); ?></label></th>
<td><input name="maxwidth" type="text" id="maxwidth" value="<?php echo $ncode_secenekler['maxwidth']; ?>" class="small-text" />
<span class="description"><?php _e('Images taller than this width will be resized. Enter 0 to allow all widths, or leave the field empty to use the default value.', 'ncode'); ?></span>
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="maxheight"><?php _e('Maximum height', 'ncode'); ?></label></th>
<td><input name="maxheight" type="text" id="maxheight" value="<?php echo $ncode_secenekler['maxheight']; ?>" class="small-text" />
<span class="description"><?php _e('Images taller than this height will be resized. Enter 0 to allow all heights, or leave the field empty to use the default value.', 'ncode'); ?></span></td>
</tr>
</table>
<p class="submit">
<input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes', 'ncode'); ?>" />
</p>

</form>
</div>
<?php	
}

?>