<div class="widget_<?= $widget_region ?> widget_comments_comments_list" id="widget_<?= $widget_id ?>">
	<?php if ($widget_title): ?><h3><span id="comments_count"><?= $comments_title ?></span> Comments</h3><?php endif; ?>
	<ol id="comments_list">
		<?php if($comments) echo $comments; ?>
	</ol>
</div>
