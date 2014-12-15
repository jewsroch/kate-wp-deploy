<![CDATA[ TentBlogger FeedBurner 2.0 ]]>
<?php $options = get_option('tentblogger-feedburner'); ?>
<div class="wrap">
  <div class="icon">
    <h2>
      <?php _e("TentBlogger's FeedBurner RSS Redirect Plugin", "tentblogger-feedburner"); ?>
    </h2>
    <p class="description"><?php _e('Easily redirect your WordPress’ RSS Feed to FeedBurner automatically!', 'tentblogger-feedburner'); ?></p>
  </div>
  <div class="postbox-container">
	<div id="poststuff" class="postbox">
		<h3 class="hndle">
			<span>
				<?php _e("FeedBurner RSS Redirection", "tentblogger-feedburner"); ?>
			</span>
		</h3>
		<div class="inside">
			<?php if($is_updated) { ?>
				<div id="message" class="updated fade">
					<p>
						<?php _e('Feed options updated successfully!', 'tentblogger-feedburner'); ?>
					</p>
				</div>
			<?php } // end if ?>
			<p>
			<?php _e("This simple (yet effective) plugin redirects the your blog's feed to <a href='http://tentblogger.com/feedburner-plugin/'>FeedBurner</a>! This is strategic because <a href='http://tentblogger.com/feedburner-plugin/'>FeedBurner</a> lets you track your readers, analyze trends in your readership, and also allows you to setup email subscriptions and even monetize your feed!", 'tentblogger-feedburner'); ?>
			</p>
			<p>
				<?php _e('WordPress\' native RSS is great but it\'s made even better with <a href="http://tentblogger.com/feedburner-plugin/">FeedBurner</a>!', 'tentblogger-feedburner'); ?>
			</p>
		</div>
		<fieldset style="padding: 10px; margin: 10px; border: 1px solid #ddd;">
			<legend>
				<?php _e('Configuration Options', 'tentblogger-feedburner'); ?>
			</legend>
			<form method="post" action="" id="tentblogger-feedburner-configuraton">
				<p>
					<label for="tentblogger-feedburner-feed-url">
						<?php _e('Your FeedBurner Address:', 'tentblogger-feedburner'); ?>
					</label>
					<input type="text" id="tentblogger-feedburner-feed-url" name="tentblogger-feedburner-feed-url" value="<?php echo $options['tentblogger-feedburner-feed-url']; ?>" />
				</p>
				<p>
					<label for="tentblogger-feedburner-comment-url">
						<?php _e('Your FeedBurner Address For Comment Feeds:', 'tentblogger-feedburner'); ?>
					</label>
					<input type="text" id="tentblogger-feedburner-comment-url" name="tentblogger-feedburner-comment-url" value="<?php echo $options['tentblogger-comment-feed-url']; ?>" />
				</p>
				<p class="submit" id="tentblogger-feedburner-submit">
					<?php wp_nonce_field('tentblogger-feedburner', 'tentblogger-feedburner-admin'); ?>
					<input type="submit" name="submit" class="button-primary"  value="<?php _e('Redirect My Feeds!', 'tentblogger-feedburner'); ?>" />
				</p>
			</form>
		</fieldset>
		<div class="tentblogger-inside inside">
			<p>
				<?php _e('Feel free to <a href="http://twitter.com/tentblogger" target="_blank">follow me</a> on Twitter!', 'tentblogger-feedburner'); ?>
			</p>
		</div>
	</div>
</div>