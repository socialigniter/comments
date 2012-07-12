<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : Controller
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the public Comments Controller class
*/
class Comments extends Site_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('comments_igniter');
	}

	function index()
	{
		redirect(base_url());
	}

	/* Widgets */
	function widgets_comments_list($widget_data)
	{
		// Get Comments
		$comments 							= $this->comments_igniter->get_comments_content($widget_data['content_id']);
		$comments_count						= count($comments);

		if ($comments_count)	$comments_title = $comments_count;
		else					$comments_title = 'Write';
		
		$widget_data['comments_title']		= $comments_title;
		
		// Recursive Function that builds comments
		$widget_data['comments'] 			= $this->comments_igniter->render_comments_children($comments, 0, $widget_data['logged_user_id'], $widget_data['logged_user_level_id']);

		$this->load->view('widgets/comments_list', $widget_data);
	}

	function widgets_comments_write($widget_data)
	{
		// Write
		$widget_data['comment_name']		= $this->session->flashdata('comment_name');
		$widget_data['comment_email']		= $this->session->flashdata('comment_email');
		$widget_data['comment_write_text'] 	= $this->session->flashdata('comment_write_text');
		$widget_data['reply_to_id']			= $this->session->flashdata('reply_to_id');
		$widget_data['comment_module']		= 'comments';
		$widget_data['comment_type']		= 'comment';
		$widget_data['geo_lat']				= $this->session->flashdata('geo_lat');
		$widget_data['geo_long']			= $this->session->flashdata('geo_long');
		$widget_data['comment_error']		= $this->session->flashdata('comment_error');

		// ReCAPTCHA Enabled
		/*
		if ((config_item('comments_recaptcha') == 'TRUE') && (!$this->social_auth->logged_in()))
		{
	    	$this->load->library('recaptcha');
			$this->data['recaptcha']		= $this->recaptcha->get_html();
		}
		else
		{
			$this->data['recaptcha']		= '';
		}
		*/
		$widget_data['recaptcha'] = '';

		
		$this->load->view('widgets/comments_write', $widget_data);
	}

}
