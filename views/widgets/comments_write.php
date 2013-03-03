<div class="widget_<?= $widget_region ?> widget_comments_comments_write" id="widget_<?= $widget_id ?>">
	<?php if ($widget_title): ?><h3><?= $widget_title ?></h3><?php endif; ?>
	<form method="post" name="comments_write_form" id="comments_write_form">
		<div class="comment_thumbnail">
			<a href="<?= $logged_profile ?>"><img src="<?= $this->social_igniter->profile_image($this->session->userdata('user_id'), $this->session->userdata('image'), $this->session->userdata('gravatar')) ?>" border="0"></a>
		</div>
		<div class="comment_write">
			<a href="<?= $logged_profile ?>"><?= $logged_name; ?></a> says:<br>
			<textarea name="comment" id="comment_write_text" placeholder="Write comment..." rows="3" cols="38"></textarea><br>
			<?= $recaptcha ?>
			<div id="comment_error" class="error"><?= $comment_error ?></div>
			<input type="submit" id="comment_submit" value="Comment">
		</div>
		<div class="clear"></div>
		<input type="hidden" name="module" value="<?= $module ?>">
		<input type="hidden" name="type" value="<?= $type ?>">
		<input type="hidden" name="reply_to_id" id="reply_to_id" value="<?= $reply_to_id ?>">
		<input type="hidden" name="content_id" id="content_id" value="<?= $content_id ?>">
		<input type="hidden" name="geo_lat" id="geo_lat" value="<?= $geo_lat ?>">
		<input type="hidden" name="geo_long" id="geo_long" value="<?= $geo_long ?>">
	</form>
</div>