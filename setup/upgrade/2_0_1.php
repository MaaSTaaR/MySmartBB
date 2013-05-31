<?php

include( '../common.php' );
include( '../../' . $MySmartBB->getLanguageDir() . 'setup/upgrade.lang.php' );

$MySmartBB->html->page_header( $lang[ 'update_to' ] . ' 2.0.1' );

$logo = $MySmartBB->html->create_image(array('align'=>$MySmartBB->_CONF[ 'align' ],'alt'=>'MySmartBB','src'=>'../logo.jpg','return'=>true));
$MySmartBB->html->open_table('100%',true);
$MySmartBB->html->cells($logo,'header_logo_side');

$MySmartBB->html->cells( $lang[ 'update_to' ] . ' 2.0.1', 'main1');
$MySmartBB->html->close_table();

if ( $MySmartBB->_CONF[ 'info_row' ][ 'MySBB_version' ] != '2.0.0' )
{
	$MySmartBB->html->msg( $lang[ 'current_version_must_be' ] . ' 2.0.0' );
	exit();
}

// There is no database modification in this version. So just update the version number in the database
$update = $MySmartBB->info->updateInfo( 'MySBB_version', '2.0.1' );

if ( $update )
	$MySmartBB->html->msg( $lang[ 'upgrade_succeed' ] );

?>