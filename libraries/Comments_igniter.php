<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
Comments Igniter Library

@package	Social Igniter
@subpackage	Comments Igniter Library
@author		Brennan Novak
@link		http://social-igniter.com

Contains functions that handle comments
*/
 
class Comments_Igniter
{
	protected $ci;

	function __construct()
	{
		$this->ci =& get_instance();
				
		// Load Models
		$this->ci->load->model('comments_model');

		// Define Variables
		$this->view_comments = '';
	}

	function get_comment($comment_id)
	{
		return $this->ci->comments_model->get_comment($comment_id);
	}
	
	function get_comments($site_id, $owner_id, $module='all')
	{
		return $this->ci->comments_model->get_comments($site_id, $owner_id, $module);
	}

	function get_comments_mine($site_id, $user_id, $module='all')
	{
		return $this->ci->comments_model->get_comments_mine($site_id, $user_id, $module);
	}

	function get_comments_recent($module=NULL, $limit=10)
	{
		return $this->ci->comments_model->get_comments_recent(config_item('site_id'), $module, $limit);
	}

	function get_comment_children($reply_to_id)
	{
		return $this->ci->comments_model->get_comment_children($reply_to_id);
	}

	function get_comments_count()
	{
		return $this->ci->comments_model->get_comments_count(config_item('site_id'));
	}

	function get_comments_content_count($content_id, $approval='Y')
	{
		return $this->ci->comments_model->get_comments_content_count($content_id, $approval);
	}

	function get_comments_new_count($site_id, $owner_id)
	{
		return $this->ci->comments_model->get_comments_new_count($site_id, $owner_id);
	}
	
	function get_comments_content($content_id)
	{
		return $this->ci->comments_model->get_comments_content($content_id);
	}
	
	function add_comment($comment_data)
	{
		$comment = FALSE;
		
		// Add Comment		
		if ($comment_id = $this->ci->comments_model->add_comment(config_item('site_id'), $comment_data))
		{			
			// Get Comment
			$comment = $this->get_comment($comment_id);

			$comments_count = $this->get_comments_content_count($comment_data['content_id']);

			// Update Comments Count
			$this->ci->social_igniter->update_content_value(array('content_id' => $comment_data['content_id'], 'comments_count' => $comments_count));		
		}
		
		return $comment;
	}

	function update_comment_viewed($comment_id)
	{
		return $this->ci->comments_model->update_comment_viewed($comment_id);
	}

	function update_comment_approve($comment_id)
	{
		return $this->ci->comments_model->update_comment_approve($comment_id);
	}

	function update_comment_orphaned_children($comment_id)
	{
		$orphaned_children = $this->get_comment_children($comment_id);
	
		if (!$orphaned_children) return FALSE;
	
		foreach ($orphaned_children as $child)
		{
			$this->ci->comments_model->update_comment_reply_to_id($child->comment_id, '0');
		}
	
		return TRUE;
	}

	function delete_comment($comment_id)
	{
		return $this->ci->comments_model->delete_comment($comment_id);
	}
	
	function delete_comments_content($content_id)
	{		
		if ($comments = $this->get_comments_content($content_id))
		{
			foreach ($comments as $comment)
			{
				$this->delete_comment($comment->comment_id);
			}
		}
		
		return TRUE;
	}

	function render_comments_children($comments, $reply_to_id, $user_id, $user_level_id)
	{
		foreach ($comments as $child)
		{
			if ($reply_to_id == $child->reply_to_id)
			{
				$comment_data['comment'] = $child;
			
				if ($reply_to_id != '0') $comment_data['sub'] = 'sub_';
				else					 $comment_data['sub'] = '';
			
				$comment_data['comment_id']		= $child->comment_id;
				$comment_data['comment_text']		= $child->comment;
				$comment_data['reply_id']			= $child->comment_id;
				$comment_data['item_can_modify']	= $this->ci->social_auth->has_access_to_modify('comment', $child, $user_id, $user_level_id);

				$this->view_comments  	       .= $this->ci->load->view('../modules/comments/views/partials/comment', $comment_data, true);
				
				// Recursive Call
				$this->render_comments_children($comments, $child->comment_id, $user_id, $user_level_id);
			}	
		}
			
		return $this->view_comments;
	}

}