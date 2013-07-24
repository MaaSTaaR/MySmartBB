<?php

include( '../common.php' );
include( '../../' . $MySmartBB->getLanguageDir() . 'setup/upgrade.lang.php' );

$MySmartBB->html->page_header( $lang[ 'update_to' ] . ' 2.1.0' );

$logo = $MySmartBB->html->create_image(array('align'=>$MySmartBB->_CONF[ 'align' ],'alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

$MySmartBB->html->cells( $lang[ 'update_to' ] . ' 2.1.0', 'main1');
$MySmartBB->html->close_table();

if ( $MySmartBB->_CONF[ 'info_row' ][ 'MySBB_version' ] != '2.0.0' and $MySmartBB->_CONF[ 'info_row' ][ 'MySBB_version' ] != '2.0.1' )
{
	$MySmartBB->html->msg( $lang[ 'current_version_must_be' ] . ' 2.0.0, 2.0.1' );
	exit();
}

// ... //

$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
$MySmartBB->rec->fields = array(	'need_update_forbidden_forums'	=>	'INT( 1 ) NOT NULL',
									'forbidden_forums'	=>	'TEXT NOT NULL' );

$addMemberFields = $MySmartBB->rec->addFields();

// ... //

$insert = array();

$insert[] = $MySmartBB->info->insertInfo( 'need_update_global_forbidden_forums', '1' );
$insert[] = $MySmartBB->info->insertInfo( 'global_forbidden_forums' );

// ... //

$updateVersion = $MySmartBB->info->updateInfo( 'MySBB_version', '2.1.0' );

// ... //

if ( $addMemberFields and !in_array( false, $insert ) and $updateVersion )
	$MySmartBB->html->msg( $lang[ 'upgrade_succeed' ] );

?>