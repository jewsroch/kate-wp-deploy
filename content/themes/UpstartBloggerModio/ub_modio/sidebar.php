<div id="sidebar">
 	<p class="menu"><B>INSIDE&nbsp;&nbsp;&nbsp;&nbsp;&larr;</b></p><br/>
<p><a href="<?php
 echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></p>
 <?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>



<br/><p><b>FUN</b> / PAGES</p>
				<ul><?php wp_list_pages('title_li=' ); ?></ul><br/>
					
					<ul style="text-align:right;">
	
		<p><b>FIND</b> / SEARCH</p>
<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
	<input type="text" class="search_input" value="Type and hit enter..." name="s" id="s" onfocus="if (this.value == 'Type and hit enter...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Type and hit enter...';}" />
	<input type="hidden" id="searchsubmit" value="Search" />
</form>
</ul><br/>
	<p><b>FEEDS</b> / RSS</p>
	<ul>
					<li class="page_item"><a href="<?php bloginfo('rss2_url'); ?>">Entries</a></li>
			<li class="page_item"><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments</a></li></ul><br/>
			
 <?php endif; ?> 
 </div><!-- end sidebar -->