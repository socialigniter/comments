<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : Settings Controller
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
* 
* Project:		http://social-igniter.com
* 
* Description: This file is for the Comments Settings Controller class
*/
class Settings extends Dashboard_Controller 
{
    function __construct() 
    {
        parent::__construct();

		if ($this->data['logged_user_level_id'] > 1) redirect('home');	
        
        $this->load->config('comments');
        $this->load->library('comments_igniter');        
        
		$this->data['page_title']	= 'Settings';
    }
 
 	function index()
	{
		if (config_item('comments_enabled') == '') 
		{
			$this->session->set_flashdata('message', 'Oops, the Comments is not installed');
			redirect('settings/apps');
		}		
		
		if ($this->session->userdata('user_level_id') != 1) redirect(base_url().config_item('home_view_redirect'), 'refresh');
		
		$this->data['sub_title'] 	= 'Comments';
		$this->data['this_module']	= 'comments';
		$this->data['shared_ajax'] .= $this->load->view(config_item('dashboard_theme').'/partials/settings_modules_ajax.php', $this->data, true);		
    	$this->render('dashboard_wide');
	}
	
	function widgets()
	{
		$this->data['sub_title'] = 'Widgets';		
		$this->render('dashboard_wide');
	}		

}