<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:			Social Igniter : Comments : Install
* Author: 		Brennan Novak
* 		  		contact@social-igniter.com
*          
* Project:		http://social-igniter.com/
*
* Description: 	Installer values for Comments for Social Igniter 
*/

/* Settings */
$config['comments_settings']['enabled']				= 'TRUE';
$config['comments_settings']['widgets'] 			= 'TRUE';
$config['comments_settings']['reply'] 					= 'TRUE';
$config['comments_settings']['reply_level'] 			= '2';
$config['comments_settings']['email_signup'] 			= 'TRUE';
$config['comments_settings']['email_replies'] 			= 'TRUE';
$config['comments_settings']['akismet'] 				= 'TRUE';
$config['comments_settings']['recaptcha'] 				= 'TRUE';
$config['comments_settings']['date_style'] 				= 'ELAPSED';

$config['database_comments_comments_table'] = array(
	'comment_id' => array(
		'type' 					=> 'INT',
		'constraint' 			=> 32,
		'unsigned' 				=> TRUE,
		'auto_increment'		=> TRUE
	),
	'site_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 6,
		'null'					=> TRUE
	),
	'reply_to_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 11,
		'null'					=> TRUE
	),
	'content_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 11,
		'null'					=> TRUE
	),
	'owner_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 11,
		'null'					=> TRUE
	),
	'module' => array(
		'type'					=> 'VARCHAR',
		'constraint'			=> 32,
		'null'					=> TRUE
	),
	'type' => array(
		'type'					=> 'VARCHAR',
		'constraint'			=> 32,
		'null'					=> TRUE
	),
	'user_id' => array(
		'type'					=> 'INT',
		'constraint'			=> 11,
		'null'					=> TRUE
	),
	'comment' => array(
		'type'					=> 'TEXT',
		'null'					=> TRUE
	),
	'geo_lat' => array(
		'type'					=> 'VARCHAR',
		'constraint'			=> 16,
		'null'					=> TRUE
	),
	'geo_long' => array(
		'type'					=> 'VARCHAR',
		'constraint'			=> 16,
		'null'					=> TRUE
	),
	'viewed' => array(
		'type'					=> 'CHAR',
		'constraint'			=> 1,
		'null'					=> TRUE
	),
	'approval' => array(
		'type'					=> 'CHAR',
		'constraint'			=> 1,
		'null'					=> TRUE
	),
	'created_at' => array(
		'type'					=> 'DATETIME',
		'null'					=> TRUE,
		'default'				=> '9999-12-31 00:00:00'				
	),
	'updated_at' => array(
		'type'					=> 'DATETIME',
		'null'					=> TRUE,
		'default'				=> '9999-12-31 00:00:00'				
	)			
);
