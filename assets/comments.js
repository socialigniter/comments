$(document).ready(function()
{
	// Comments On Site
	$('#comments_write_form').bind('submit', function(e)
	{
		e.preventDefault();		
		var comment_data = $('#comments_write_form').serializeArray();
					
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
		
		if(comment_count_current == 1) var comment_count_updated	= 'Write';		
		else var comment_count_updated	= parseInt(comment_count_current)-1;		

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