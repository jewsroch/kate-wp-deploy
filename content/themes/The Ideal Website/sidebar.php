<?php
 

if(is_home() || is_page())

{

?>



<div id="menu">


	
	<?php
	
	$pages = get_pages();
	//print_r($pages);
	//list_pages_by_category(0, true, true, '', '<br/>', '<br/>', true, false, false); ?>
	<ul class='pagelist'>
		<li class='pagecat'><br/><br/>
		<ul class='pagemain'>
		<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

<li><a href="<?php bloginfo('url'); ?>" <?php if (is_home()) echo " class=\"selected\""; ?> title="<?php bloginfo('name')?>: Startpage" >Home</a>&nbsp; &nbsp;</li>
<?php 

$parent = '';
/*
if(is_home()) {
	$parent = '&depth=1';
}
else {
	$parent = '&child_of=' . $post->ID;
}
*/

wp_list_pages('title_li=&sort_column=menu_order');

?>
<?php endif; ?>
      </ul>
	</li>
</ul>
	

	



</div>



<?php 

}

?>