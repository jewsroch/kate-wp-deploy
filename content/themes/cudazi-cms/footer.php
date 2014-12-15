<?php
 
	global $custom_settings;
	global $include_cycle_plugin; // decides whether to include cycle.js or not...
?>

			<div class="grid_12">
				<div class="footer clearfix">
					<div class="left"><p><?php echo html_entity_decode($custom_settings["footer_text"], ENT_QUOTES); ?></p></div>
					<?php echo display_social_icons(); ?>
				</div>
			</div>
			
		</div>

		<!--[if lt IE 7]><script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script><![endif]-->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<?php 
			// Since the promos are only on the home page template
			// only include the extra JavaScript on EVERY page.
			if($include_cycle_plugin == "yes") { 
		?>
			<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.cycle.all.min.js"></script>
			<script type="text/javascript">
				// Promo Init, inserted on when promo is in use to save bandwidth
				$('#promos').cycle({ 
					fx:     '<?php echo $custom_settings["promo_config"]["fx"]; ?>', 
					speed:  <?php echo $custom_settings["promo_config"]["speed"]; ?>, 
					timeout: <?php echo $custom_settings["promo_config"]["timeout"]; ?>,
					pager: '#promo-nav',
					pause: 1,
					height: 'auto',
					pauseOnPagerHover: 1,
					fastOnEvent: 350,
					pagerAnchorBuilder: function(idx, slide) { 
						return "#promo-nav li:eq("+ idx +") a"; 
					}
				});
			</script>
		<?php }else{  ?>
		<!-- Cycle/Promo JS not needed -->
		<?php }  ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/supersubs.js"></script><!-- For dropdown menu -->
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/superfish.js"></script><!-- For dropdown menu -->
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/general.js"></script>
		<?php echo html_entity_decode($custom_settings["extra"]["footer"], ENT_QUOTES); ?>
		<?php wp_footer(); ?>
	</body>
</html>