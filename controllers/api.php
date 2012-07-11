<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : API Controller
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the Comments API Controller class
*/
class Api extends Oauth_Controller
{
    function __construct()
    {
        parent::__construct(); 

        $this->load->library('comments_igniter');       
	}

    /* Install App */
	function install_get()
	{
		// Load
		$this->load->library('installer');
		$this->load->config('install');   
		$this->load->dbforge();		     

		// Settings & Create Folders
		$settings = $this->installer->install_settings('comments', config_item('comments_settings'));

		// Create Comments Table
		$this->dbforge->add_key('comment_id', TRUE);
		$this->dbforge->add_field(config_item('database_comments_comments_table'));
		$this->dbforge->create_table('comments');

		if ($settings == TRUE)
		{
            $message = array('status' => 'success', 'message' => 'Yay, the Comments App was installed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Dang Comments App could not be installed');
        }		
		
		$this->response($message, 200);
	} 

    // Recent Comments
    function recent_get()
    {
        $comments = $this->social_tools->get_comments_recent('all', 25);
        
        if ($comments)
        {
            $message = array('status' => 'success', 'message' => 'Yay found some comments', 'data' => $comments);
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Could not find any comments');
        }

        $this->response($message, 200);        
    }

	// Comments for Content
	function content_get()
    {
        if ($this->get('id'))
        {
      		$comments = $this->social_tools->get_comments_content($this->get('id'));
    	
	        if($comments)
	        {
	            $message = array('status' => 'success', 'message' => 'Comments were found', 'data' => $comments);
	        }
	        else
	        {
	            $message = array('status' => 'error', 'message' => 'No comments could be found');
	        }
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'You need to specify a content_id');	        
        }

        $this->response($message, 200);        
    }
    
    // New Comments for User
	function new_authd_get()
	{	
		$site_id = config_item('site_id');	
	
		if ($new_comments = $this->social_tools->get_comments_new_count($site_id, $this->oauth_user_id))
		{
         	$message = array('status' => 'success', 'message' => 'New comments found', 'data' => $new_comments);	
		}
		else
		{
         	$message = array('status' => 'error', 'message' => 'No new comments found', 'data' => $new_comments);			
		}
		
        $this->response($message, 200);		
	}

	// Creates Comment
    function create_authd_post()
    {
		$this->form_validation->set_rules('comment', 'Comment', 'required');

		// Validation
		if ($this->form_validation->run() == true)
		{  
			if ($content = $this->social_igniter->check_content_comments($this->input->post('content_id')))
			{
	        	$comment_data = array(
	    			'reply_to_id'	=> $this->input->post('reply_to_id'),
	    			'content_id'	=> $content->content_id,		
	    			'owner_id'		=> $content->user_id,
					'module'		=> $content->module,
	    			'type'			=> $content->type,
	    			'user_id'		=> $this->oauth_user_id,
	    			'comment'		=> $this->input->post('comment'),
	    			'geo_lat'		=> $this->input->post('geo_lat'),
	    			'geo_long'		=> $this->input->post('geo_long'),
	    			'approval'		=> $content->comments_allow
	        	);
	
				// Insert
				if ($comment = $this->social_tools->add_comment($comment_data))
				{
					$comment_data['comment_id']		= $comment->comment_id;
					$comment_data['created_at']		= format_datetime(config_item('comments_date_style'), $comment->created_at);
					$comment_data['name']			= $comment->name;
					$comment_data['username']		= $comment->username;
					$comment_data['gravatar']		= $comment->gravatar;
					$comment_data['image']			= $comment->image;
					$comment_data['sub']			= '';
				
					// Set Reply Id For Comments
					if ($comment->reply_to_id)
					{
						$comment_data['sub']		= 'sub_';
						$comment_data['reply_id']	= $comment->reply_to_id;
					}
	
					// Set Display Comment
					if ($content->comments_allow == 'A')
					{
						$comment_data['comment']	= '<i>Your comment is awaiting approval!</i>';
					}
				
		        	$message = array('status' => 'success', 'message' => 'Comment posted successfully', 'data' => $comment_data);
		        }
		        else
		        {
			        $message = array('status' => 'error', 'message' => 'Oops unable to post your comment');
		        }
			}
			else
			{
		        $message = array('status' => 'error', 'message' => 'Oops you can not comment on that!');
			}	
		}
		// Not Valid
		else 
		{	
	        $message = array('status' => 'error', 'message' => validation_errors());
		}

        $this->response($message, 200);
    }
    

	function create_public_post()
	{	
	 	// Validation Rules
    	$this->form_validation->set_rules('comment_name', 'Name', 'required');
    	$this->form_validation->set_rules('comment_email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('comment', 'Comment', 'required');

		// Validates
		if ($this->form_validation->run() == true)
		{
/*
			// Akismet Enabled
			if (config_item('comments_akismet') == 'TRUE')		
			{
				$this->load->library('akismet');
				
				$comment = array('author' => $this->input->post('comment_name'), 'email' => $this->input->post('comment_email'), 'body' => $this->input->post('comment'));
				$config  = array('blog_url' => config_item('site_url'), 'api_key' => config_item('site_akismet_key'), 'comment' => $comment);
				
				$this->akismet->init($config);
				 
				if ($this->akismet->errors_exist())
				{				
					if ($this->akismet->is_error('AKISMET_INVALID_KEY')) 			
					{
						return FALSE;
					}
					elseif ($this->akismet->is_error('AKISMET_RESPONSE_FAILED'))
					{
						return FALSE;
					}
					elseif ($this->akismet->is_error('AKISMET_SERVER_NOT_FOUND'))
					{
						return FALSE;
					}
					else															
					{
						return TRUE;
					}
				}
				else
				{
					if ($this->akismet->is_spam())	
					{
						$this->form_validation->set_message('akistmet_validate', 'We think your comment might be spam!"');		
						return FALSE; 
					}
					else
					{
						return TRUE;
					}
				}
			}
			
			// ReCAPTCHA Enabled
			if (config_item('comments_recaptcha') == 'TRUE')		
			{
			    $this->load->library('recaptcha');	
			
				if ($this->recaptcha->check_answer($this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $val))
				{
					$recaptcha = TRUE;
				} 
				else
				{
					$this->form_validation->set_message('check_captcha', $this->lang->line('recaptcha_incorrect_response'));
					$recaptcha = FALSE;
				}	
			}
*/		
			if ($content = $this->social_igniter->check_content_comments($this->input->post('content_id')))
			{
				$user = $this->social_auth->get_user('email', $this->input->post('comment_email'));
				
				if (!$user)
				{
					$username			= url_username($this->input->post('comment_name'), 'none', true);
		        	$email				= $this->input->post('comment_email');
		        	$password			= random_string('unique');
		        	$additional_data 	= array('name' => $this->input->post('comment_name'));
					$level				= config_item('comments_group');
		        	
		        	// Register User
		        	if ($this->social_auth->register($username, $password, $email, $additional_data, $level))
		        	{
		        	
		        		log_message('debug', 'COOOOM inside register');

		        	
						$user = $this->social_auth->get_user('email', $this->input->post('comment_email'));
		       		}
				}
				
	        	$comment_data = array(
	    			'reply_to_id'	=> $this->input->post('reply_to_id'),
	    			'content_id'	=> $content->content_id,
	    			'owner_id'		=> $content->user_id,
					'module'		=> $content->module,
	    			'type'			=> $content->type,
	    			'user_id'		=> $user->user_id,
	    			'comment'		=> $this->input->post('comment'),
	    			'geo_lat'		=> $this->input->post('geo_lat'),
	    			'geo_long'		=> $this->input->post('geo_long'),
	    			'approval'		=> $content->comments_allow
	        	);
	
				// Insert
				if ($comment = $this->social_tools->add_comment($comment_data))
				{			
				
					log_message('debug', 'COOOOM inside comment created');

						
					$comment_data['comment_id']		= $comment->comment_id;
					$comment_data['created_at']		= format_datetime(config_item('comments_date_style'), $comment->created_at);
					$comment_data['name']			= $comment->name;
					$comment_data['username']		= $comment->username;
					$comment_data['gravatar']		= $comment->gravatar;
					$comment_data['image']			= $comment->image;
					$comment_data['sub']			= '';	
				
					// Set Reply Id For Comments
					if ($comment->reply_to_id)
					{
						$comment_data['sub']		= 'sub_';
						$comment_data['reply_id']	= $comment->reply_to_id;
					}
	
					// Set Display Comment
					if ($content->comments_allow == 'A')
					{
						$comment_data['comment']	= '<i>Your comment is awaiting approval!</i>';
					}
				
		        	$message = array('status' => 'success', 'message' => 'Yay we posted your comment', 'data' => $comment_data);
		        }
		        else
		        {
			        $message = array('status' => 'error', 'message' => 'Oops unable to post your comment');
		        }
			}
			else
			{
		        $message = array('status' => 'error', 'message' => 'Oops you can not comment on that content');
			}
		}
		// Not Valid
		else 
		{	
	        $message = array('status' => 'error', 'message' => validation_errors());
		}

        $this->response($message, 200);
	}    
    
    
    /* PUT types */
    function viewed_authd_get()
    {				
        if($this->social_tools->update_comment_viewed($this->get('id')))
        {
            $message = array('status' => 'success', 'message' => 'Comment viewed');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Could not mark as viewed');
        }
        
        $this->response($message, 200);            
    }   
    
    function approve_authd_get()
    {
    	$approve = $this->social_tools->update_comment_approve($this->get('id'));	

        if($approve)
        {
            $message = array('status' => 'success', 'message' => 'Comment approved');
        }
        else
        {
            $message = array('status' => 'error', 'message' => 'Could not be approved');
        }

        $this->response($message, 200);        
    } 

    function destroy_authd_get()
    {		
		$comment = $this->social_tools->get_comment($this->get('id'));
		
		// Make sure user has access to do this func    	
    	if ($access = $this->social_auth->has_access_to_modify('comment', $comment, $this->oauth_user_id))
        {       
        	$this->social_tools->delete_comment($comment->comment_id);
        
			// Reset comments with this reply_to_id
			$this->social_tools->update_comment_orphaned_children($comment->comment_id);
			
			// Update Content
			$this->social_igniter->update_content_comments_count($comment->comment_id);
        
        	$message = array('status' => 'success', 'message' => 'Comment deleted');
        }
        else
        {
            $messgage = array('status' => 'error', 'message' => 'Could not delete that comment!');
        }

        $this->response($message, 200); 
    }	
	

}