<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : Home Controller
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the Comments Home Controller class
*/
class Home extends Dashboard_Controller
{
    function __construct()
    {
        parent::__construct();

		$this->load->config('comments');
        $this->load->library('comments_igniter');

		$this->data['page_title'] = 'Comments';
	}
	
	function index()
 	{
 	    $this->data['page_title'] 	= "Comments";
 	    $this->data['sub_title'] 	= "Recent";
 		$this->data['navigation']	= $this->load->view(config_item('dashboard_theme').'/partials/navigation_comments.php', $this->data, true);

		$comments 					= $this->social_tools->get_comments(config_item('site_id'), $this->session->userdata('user_id'), $this->uri->segment(3));		
		$comments_view 				= NULL;
		$this->data['feed_type']	= 'comments';
    	$this->data['item_verb']	= item_type($this->lang->line('object_types'), 'comment');
	
		if (empty($comments))
		{
			 $comments_view = '<li>No comments to show!</li>';
	 	}
	 	else
	 	{
			foreach ($comments as $comment)
			{
				// Item
				$this->data['item_id']				= $comment->comment_id;
				$this->data['item_type']			= item_type_class($comment->type);
				$this->data['item_viewed']			= item_viewed('item', $comment->viewed);
				
				// Contributor
				$this->data['item_avatar']			= $this->social_igniter->profile_image($comment->user_id, $comment->image, $comment->gravatar);
				$this->data['item_contributor']		= $comment->name;
				$this->data['item_profile']			= base_url().'profile/'.$comment->username;

				// Activity
				if ($comment->title)
				{
					$this->data['item_article']		= '';
					$this->data['item_object']		= $comment->title;
				}
				else
				{
					$this->data['item_article']		= item_type($this->lang->line('object_articles'), $comment->type);
					$this->data['item_object']		= $comment->type;
				}
				
				$this->data['item_text']			= item_linkify($comment->comment);
				$this->data['item_date']			= format_datetime(config_item('comments_date_style'), $comment->created_at);				
				$this->data['item_approval']		= $comment->approval;

				// Alerts
				$this->data['item_alerts']			= item_alerts_comment($comment);
		
		 		// Actions
				$this->data['item_view'] 			= base_url().$comment->module.'/view/'.$comment->content_id.'/'.$comment->comment_id;
				$this->data['item_reply'] 			= base_url().$comment->module.'/reply/id/'.$comment->content_id.'/'.$comment->comment_id;
				$this->data['item_approve']			= base_url().'api/comments/approve/id/'.$comment->comment_id;
				$this->data['item_delete']			= base_url().'api/comments/destroy/id/'.$comment->comment_id;
				
				// Load Partial For Items
				$comments_view 				   	   .= $this->load->view('../modules/comments/views/partials/item_comments.php', $this->data, true);
	 		}
 		}
		
		$this->data['comments_view'] = $comments_view;	
				
		$this->render();
	}


}