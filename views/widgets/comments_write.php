<div class="widget_<?= $widget_region ?> widget_comments_comments_write" id="widget_<?= $widget_id ?>">
	<?php if ($widget_title): ?><h3><?= $widget_title ?></h3><?php endif; ?>
	<form method="post" name="comments_write_form" id="comments_write_form">
		<div class="comment_thumbnail">
			<a href="<?= $link_profile ?>"><img src="<?= $logged_image ?>" border="0"></a>
		</div>
		<div class="comment_write">
			<a href="<?= $link_profile ?>"><?= $logged_name; ?></a> says:<br>
			<textarea name="comment" id="comment_write_text" placeholder="Write comment..." rows="3" cols="38"><?= $comment_write_text; ?></textarea><br>
			<?= $recaptcha ?>
			<div id="comment_error" class="error"><?= $comment_error ?></div>
			<input type="submit" id="comment_submit" value="Comment">
		</div>
		<div class="clear"></div>
		<input type="hidden" name="module" value="<?= $comment_module ?>">
		<input type="hidden" name="type" value="<?= $comment_type ?>">
		<input type="hidden" name="reply_to_id" id="reply_to_id" value="<?= $reply_to_id ?>">
		<input type="hidden" name="content_id" id="content_id" value="<?= $content_id ?>">
		<input type="hidden" name="geo_lat" id="geo_lat" value="<?= $geo_lat ?>">
		<input type="hidden" name="geo_long" id="geo_long" value="<?= $geo_long ?>">
	</form>
</div>

<script type="text/javascript">
$(document).ready(function()
{
	// Comments On Site
	$('#comments_write_form').bind('submit', function(e)
	{
		e.preventDefault();		
		var comment_data = $('#comments_write_form').serializeArray();
		console.log(comment_data);
					
		$.oauthAjax(
		{			
			oauth 		: user_data,
			url			: base_url + 'api/comments/create',
			type		: 'POST',
			dataType	: 'json',
			data		: comment_data,
		  	success		: function(result)
		  	{				  		  				  	
				if(result.status == 'success')
				{
					var comment_count_current	= $('#comments_count').html();
					var reply_to_id				= $('#reply_to_id').val();
			
					if(comment_count_current == 'Write')	var comment_count_updated = 1;
					else									var comment_count_updated = parseInt(comment_count_current) + 1;		
			
					// Reply or Normal		
					if (reply_to_id)	var append_to_where = '#comment-replies-' + reply_to_id;
					else				var append_to_where = '#comments_list';				
							
									 	
					var html = '<li class="' + result.data.sub + 'comment" id="comment-' + result.data.comment_id + '"><a href="' + result.data.profile_link + '"><span class="comment_thumbnail"><img src="' + user_data.image + '" border="0" /></span></a><span class="' + result.data.sub + 'comment"><a href="' + result.data.profile_link + '">' + result.data.name + '</a> ' + result.data.comment + '<span class="comment_date ' + result.data.sub + '">' + result.data.created_at + '</span><ul class="comment_actions"><li><a href="' + base_url + 'api/comments/destroy/id/' + result.data.comment_id + '" id="delete-' + result.data.comment_id + '" class="comment_delete"><span class="item_actions action_delete"></span> Delete</a></li></ul><div class="clear"></div></span><div class="clear"></div></li>';
			 					 	
				 	$(append_to_where).append(html).show('slow');
					$('#comment_write_text').val('');
					$('#reply_to_id').val('');
					$('#comments_count').html(comment_count_updated);
			 	}
			 	else
			 	{					 		
				 	$('#comment_error').append(result.message).show('normal');
				}
		 	}
		});
	});

		
	$('.comment_reply').live('click', function()	
	{
		var reply_id = $(this).attr('id').split('-');		
		$('#reply_to_id').val(reply_id[1]);
	});

	
	$('.comment_delete').live('click', function(e)
	{
		e.preventDefault();
		var comment_id 				= $(this).attr('id').split('-');
		var comment_delete			= $(this).attr('href');
		var comment_element			= '#comment-' + comment_id[1];	
		var comment_count_current	= $('#comments_count').html();
		
		if(comment_count_current == 1)
		{
			var comment_count_updated	= 'Write';
		}
		else
		{
			var comment_count_updated	= parseInt(comment_count_current)-1;		
		}

		$.oauthAjax(
		{
			oauth 		: user_data,
			url			: comment_delete,
			type		: 'GET',
			dataType	: 'json',
		  	success		: function(result)
		  	{		  	
				if(result.status == 'error')
				{
				 	$('#comment_error').append(result.message).show('normal');
			 	}
			 	else
			 	{			 	
					$(comment_element).hide('normal');
					$('#comments_count').html(comment_count_updated);
			 	}	
		 	}
		});
	});
	
	
});
</script>

</div>
