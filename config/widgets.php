<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : Widgets
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	Installer values for Comments for Social Igniter 
*/

$config['comments_widgets'][] = array(
	'regions'	=> array('content','sidebar','wide'),
	'widget'	=> array(
		'module'	=> 'comments',
		'name'		=> 'Comments List',
		'method'	=> 'run',
		'path'		=> 'widgets_comments_list',
		'multiple'	=> 'TRUE',
		'order'		=> '1',
		'title'		=> 'Comments List',
		'content'	=> ''
	)
);

$config['comments_widgets'][] = array(
	'regions'	=> array('content','sidebar','wide'),
	'widget'	=> array(
		'module'	=> 'comments',
		'name'		=> 'Comments Write',
		'method'	=> 'run',
		'path'		=> 'widgets_comments_write',
		'multiple'	=> 'TRUE',
		'order'		=> '1',
		'title'		=> 'Comments Write',
		'content'	=> ''
	)
);