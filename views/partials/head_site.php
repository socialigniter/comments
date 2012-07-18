<style type="text/css">
#comments a 							{ font-weight: normal; color: #<?= config_item('design_link_color_normal') ?>; text-decoration: none; }
#comments a:visited						{ font-weight: normal; color: #<?= config_item('design_link_color_visited') ?>; text-decoration: none; }
#comments a:hover						{ font-weight: normal; color:#<?= config_item('design_link_color_hover') ?>; text-decoration: underline; }
#comments a:active						{ font-weight: normal; text-decoration: none; }

/* Comments List */
div.widget_comments_comments_list		{ width: 550px; margin: 25px 0 50px 0; }
div.widget_comments_comments_list li	{ margin: 0 0 15px 0; }

li.comment								{ margin: 0; clear: both; display: block; }
li.comment:hover ul.comment_actions 	{ visibility: visible; }
span.comment_thumbnail					{ width: 48px; height: 48px; display: block; position: relative; top: 0; left: 0; float: left; margin: 0 12px 35px 0; }
span.comment 							{ width: 375px; display: block; margin: 0; line-height: 21px;  position: relative; top: -4px; left: 0; float: left; }
span.comment_date 						{ width: 175px; display: block; margin: 0; font-size: 12px; color: #999999; }

li.sub_comment							{ margin: 0 0 20px 0; clear: both; }
li.sub_comment:hover ul.comment_actions { visibility: visible; }
span.sub_comment_thumbnail				{ width: 48px; height: 48px; display: block; position: relative; top: 0; left: 65px; float: left; margin: 0 12px 35px 0; }
span.sub_comment 						{ width: 325px; display: block; margin: 0; line-height: 21px;  position: relative; top: -4px; left: 62px; float: left; }
span.sub_comment_date 					{ width: 175px; display: block; margin: 0; font-size: 12px; color: #999999; }

ul.comment_actions 						{ margin: 0; position: relative; top: -20px; right: 12px; margin: 0; list-style: none; float: right; visibility: hidden; }
ul.comment_actions li					{ float: left; margin: 0; }
ul.comment_actions li a 				{ color: #999999; font-size: 12px; }
ul.comment_actions li a:visited			{ color: #999999; font-size: 12px; }
ul.comment_actions li a:hover 			{ color: #2078ce; font-size: 12px; }

/* Comments Write */
div.widget_comments_comments_write		{ width: 550px; margin: 0; }
div.widget_comments_comments_write li	{ margin: 0; }

div.comment_thumbnail					{  }
div.comment_write						{ width: 375px; display: block; margin: 0; line-height: 21px;  position: relative; top: -4px; left: 0; float: left; }

#comment_name							{ width: 315px; margin: 0 0 10px 0; }
#comment_email							{ width: 315px; margin: 0 0 0 0; }
#comment_write_text						{ width: 315px; margin: 10px 0 5px 0; }
</style>