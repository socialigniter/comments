<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : Routes
* Author: 		Brennan Novak
* 		  		hi@brennannovak.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	URI Routes for Comments for Social Igniter 
*/
$route['comments'] 										= 'comments';
$route['feed/comments']									= 'feed/comments';

$route['comments/home/others']							= 'home/feed';
$route['comments/home/mine']							= 'home/feed';

$route['comments/settings']								= 'settings/index';
