<?php

define( 'NO_INFO', true );

require_once('database_struct.php');

include( '../../' . $MySmartBB->getLanguageDir() . 'setup/setup.lang.php' );

$installer = new MySmartInstaller( $MySmartBB, $lang[ 'struct' ] );

$MySmartBB->html->page_header( $lang[ 'installation_wizard' ] );

$logo = $MySmartBB->html->create_image(array('align'=>$MySmartBB->_CONF[ 'align' ],'alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

// ... //

if (empty($MySmartBB->_GET['step']))
{
	$MySmartBB->html->cells( $lang[ 'welcome_message_step' ] ,'main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->msg( $lang[ 'welcome_message' ] );

	$MySmartBB->html->make_link( $lang[ 'start_install' ] ,'?step=1');
}

if ($MySmartBB->_GET['step'] == 1)
{
	$MySmartBB->html->cells( $lang[ 'first_step' ] ,'main1');
	$MySmartBB->html->close_table();
	
	// ... //
	
	$directories = array(	'../../download', 
							'../../download/avatar', 
							'../../modules/styles/main/compiler', 
							'../../modules/styles/main/templates',
							'../../modules/admin/styles/main/compiler' );
	
	foreach ( $directories as $directory )
	{
		if ( !is_writable( $directory ) )
		{
			$MySmartBB->html->msg( $lang[ 'dir_permission' ] . ' ' . $directory . ' ' . $lang[ 'uncorrect' ] );
		}
		else
		{
			$MySmartBB->html->msg( $lang[ 'dir_permission' ] . ' ' . $directory . ' ' . $lang[ 'correct' ] );
		}
	}
	
	// ... //
	
	$MySmartBB->html->make_link($lang[ 'next_step' ] . ' ' . $lang[ 'create_tables' ],'?step=2');
}
elseif ($MySmartBB->_GET['step'] == 2)
{
	$MySmartBB->html->cells($lang[ 'second_step' ] . ' ' . $lang[ 'create_tables' ],'main1');
	$MySmartBB->html->close_table();
	
	$installer->createTables();
	
	$MySmartBB->html->make_link($lang[ 'next_step' ] . ' ' . $lang[ 'insert_data' ],'?step=3');
}
elseif ($MySmartBB->_GET['step'] == 3)
{
	$MySmartBB->html->cells($lang[ 'third_step' ] . ' ' . $lang[ 'insert_data' ],'main1');
	$MySmartBB->html->close_table();
	
	$installer->insertInformation();
	
	$MySmartBB->html->make_link($lang[ 'next_step' ] . ' ' . $lang[ 'set_board_information' ],'?step=4');
}
elseif ($MySmartBB->_GET['step'] == 4)
{
	$MySmartBB->html->cells($lang[ 'fourth_step' ] . ' ' . $lang[ 'set_board_information' ],'main1');
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_form('index.php?step=5');
	
	$MySmartBB->html->open_table('60%',true,1);
	$MySmartBB->html->open_table_head( $lang[ 'admin_info' ] ,'main1');
	$MySmartBB->html->row( $lang[ 'username' ] ,$MySmartBB->html->input('username'));
	$MySmartBB->html->row( $lang[ 'password' ] ,$MySmartBB->html->password('password'));
	$MySmartBB->html->row( $lang[ 'email' ] ,$MySmartBB->html->input('email'));
	$MySmartBB->html->row( $lang[ 'gender' ] ,$MySmartBB->html->select('gender',array('m'=> $lang[ 'male' ] ,'f'=> $lang[ 'female' ] )));
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->open_table('60%',true,1);
	$MySmartBB->html->open_table_head( $lang[ 'board_information' ] ,'main1');
	$MySmartBB->html->row( $lang[ 'board_title' ] ,$MySmartBB->html->input('title'));
	$MySmartBB->html->close_table();
	
	$MySmartBB->html->close_form();
}
elseif ($MySmartBB->_GET['step'] == 5)
{
	$MySmartBB->load( 'icon' );
	
	$MySmartBB->html->cells( $lang[ 'final_step' ] ,'main1');
	$MySmartBB->html->close_table();
	
	if (empty($MySmartBB->_POST['username']) 
		or empty($MySmartBB->_POST['password']) 
		or empty($MySmartBB->_POST['email']) 
		or empty($MySmartBB->_POST['gender']) 
		or empty($MySmartBB->_POST['title']))
	{
		$MySmartBB->func->error( $lang[ 'fill_req_info' ] );
	}
	
	$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
	
	$MySmartBB->rec->fields			=	array();
	
	$MySmartBB->rec->fields['username']				= 	$MySmartBB->_POST['username'];
	$MySmartBB->rec->fields['password']				= 	md5($MySmartBB->_POST['password']);
	$MySmartBB->rec->fields['email']				= 	$MySmartBB->_POST['email'];
	$MySmartBB->rec->fields['usergroup']			= 	1;
	$MySmartBB->rec->fields['user_gender']			= 	$MySmartBB->_POST['gender'];
	$MySmartBB->rec->fields['register_date']		= 	$MySmartBB->_CONF['now'];
	$MySmartBB->rec->fields['user_title']			= 	$lang[ 'admin' ];
	$MySmartBB->rec->fields['style']				=	1;
	$MySmartBB->rec->fields['username_style_cache']	=	'<strong><em><span style="color: #800000;">' . $MySmartBB->_POST['username'] . '</span></em></strong>';
	
	$insert = $MySmartBB->rec->insert();
	
	if ($insert)
	{
		$MySmartBB->html->msg( $lang[ 'admin_created' ] );
	}
	else
	{
		$MySmartBB->html->msg( $lang[ 'admin_failed' ] );
	}
	
	$update = $MySmartBB->info->updateInfo( 'create_date', $MySmartBB->_CONF['now'] );
	
	if ($update)
	{
		$MySmartBB->html->msg( $lang[ 'create_date_added' ] );
	}
	else
	{
		$MySmartBB->html->msg( $lang[ 'create_date_failed' ] );
	}
	
	$update = $MySmartBB->info->updateInfo( 'title', $MySmartBB->_POST['title'] );
	
	if ($update)
	{
		$MySmartBB->html->msg( $lang[ 'board_title_set' ] );
	}
	else
	{
		$MySmartBB->html->msg( $lang[ 'board_title_failed' ] );
	}
	
	$cache = $MySmartBB->icon->updateSmilesCache();
	
	if ($cache)
	{
		$MySmartBB->html->msg( $lang[ 'smile_cache_set' ] );
	}
	else
	{
		$MySmartBB->html->msg( $lang[ 'smile_cache_failed' ] );
	}
	
	$MySmartBB->html->msg( $lang[ 'board_installed' ] ,'center');
	$MySmartBB->html->msg($lang[ 'goto_main_page' ]) . $MySmartBB->html->make_link( $lang[ 'here' ] ,'../../index.php');
	$MySmartBB->html->msg($lang[ 'goto_admin_cp' ]) . $MySmartBB->html->make_link( $lang[ 'here' ] ,'../../admin.php');
}

?>
