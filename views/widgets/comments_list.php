<div class="widget_<?= $widget_region ?> widget_comments_comments_list" id="widget_<?= $widget_id ?>">
	<h3><span id="comments_count"><?= $comments_title ?></span> Comments</h3>
	<ol id="comments_list">
		<?php if($comments) echo $comments; ?>
	</ol>
</div>
