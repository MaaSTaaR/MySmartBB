<?php 

define( 'IN_MYSMARTBB', true );

// ... //

include( 'common.php' );
include( 'includes/systems/router.class.php' );

// ... //

$modules 								    = 	array();
$modules[ 'index' ] 						= 	'main.module.php';
$modules[ 'forum' ] 						= 	'forum.module.php';
$modules[ 'profile' ] 					    = 	'profile.module.php';
$modules[ 'register' ] 					    = 	'register.module.php';
$modules[ 'statistics' ] 					= 	'statistics.module.php';
$modules[ 'member_list' ] 				    = 	'memberlist.module.php';
$modules[ 'search' ] 						= 	'search.module.php';
$modules[ 'ads' ] 						    = 	'ads.module.php';
$modules[ 'announcement' ] 				    = 	'announcement.module.php';
$modules[ 'pages' ] 						= 	'pages.module.php';
$modules[ 'login' ] 						= 	'login.module.php';
$modules[ 'logout' ] 						= 	'logout.module.php';
$modules[ 'usercp' ] 						= 	'usercp.module.php';
$modules[ 'new_password' ] 				    = 	'new_password.module.php';
$modules[ 'activation' ] 					= 	'activation.module.php';
$modules[ 'forget' ] 						= 	'forget.module.php';
$modules[ 'cancel_requests' ] 			    = 	'cancel_requests.module.php';
$modules[ 'topic' ] 						= 	'topic.module.php';
$modules[ 'new_topic' ] 					= 	'new_topic.module.php';
$modules[ 'new_reply' ] 					= 	'new_reply.module.php';
$modules[ 'change_style' ] 				    = 	'change_style.module.php';
$modules[ 'management' ] 					= 	'management.module.php';
$modules[ 'vote' ] 						    = 	'vote.module.php';
$modules[ 'tags' ] 						    = 	'tags.module.php';
$modules[ 'rss' ] 						    = 	'rss.module.php';
$modules[ 'online' ] 						= 	'online.module.php';
$modules[ 'download' ] 					    = 	'download.module.php';
$modules[ 'latest' ] 						= 	'latest.module.php';
$modules[ 'send' ] 						    = 	'send.module.php';
$modules[ 'report' ] 						= 	'report.module.php';
$modules[ 'pm_send' ] 					    = 	'pm_send.module.php';
$modules[ 'pm_list' ] 					    = 	'pm_list.module.php';
$modules[ 'pm_show' ] 					    = 	'pm_show.module.php';
$modules[ 'pm_cp' ] 						= 	'pm_cp.module.php';
$modules[ 'pm_setting' ] 					= 	'pm_setting.module.php';
$modules[ 'usercp_control_info' ] 		    =  	'usercp_control_info.module.php';
$modules[ 'usercp_control_setting' ] 		=  	'usercp_control_setting.module.php';
$modules[ 'usercp_control_signature' ] 	    =  	'usercp_control_signature.module.php';
$modules[ 'usercp_control_password' ] 	    =  	'usercp_control_password.module.php';
$modules[ 'usercp_control_email' ] 		    =  	'usercp_control_email.module.php';
$modules[ 'usercp_control_avatar' ] 		=  	'usercp_control_avatar.module.php';
$modules[ 'usercp_option_subject' ] 		=  	'usercp_option_subject.module.php';
$modules[ 'plugin' ] 		                =  	'plugin.module.php';

// ... //

$router = new MySmartRouter( $modules, 'index', 'modules/' );

$state = $router->run( $MySmartBB->_SERVER[ 'REQUEST_URI' ], $MySmartBB->_SERVER[ 'SCRIPT_NAME' ] );

if ( $state !== true )
{
	switch ( $state )
	{
		case MySmartRouter::FEW_ARGS:
			echo 'Wrong Path!';
			break;
	}
}

?>