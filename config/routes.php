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

/* Comments */
$route['comments/api/content/(:any)/(:any)']			= 'api/comments/content/$1/$2';
$route['comments/api/viewed/(:any)/(:any)']				= 'api/comments/viewed/$1/$2';
$route['comments/api/approve/(:any)/(:any)']			= 'api/comments/approve/$1/$2';
$route['comments/api/destroy/(:any)/(:any)']			= 'api/comments/destroy/$1/$2';
$route['comments/api/content']							= 'api/comments/content';
$route['comments/api/recent']							= 'api/comments/recent';
$route['comments/api/create']							= 'api/comments/create';
$route['comments/api/create_public']					= 'api/comments/create_public';
$route['comments/api/new']								= 'api/comments/new';

$route['comments/home/(:any)'] 							= 'home/index/$1';
$route['comments/home/'] 								= 'home/index';

$route['comments/settings']								= 'settings/index';
