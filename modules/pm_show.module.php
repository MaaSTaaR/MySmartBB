<?php

(!defined('IN_MYSMARTBB')) ? die() : '';

include( 'common.module.php' );

define('CLASS_NAME','MySmartPrivateMassegeShowMOD');

class MySmartPrivateMassegeShowMOD
{
	private $id;
	
	public function run( $id )
	{
		global $MySmartBB;
		
		$this->id = (int) $id;
		
		// ... //
		
		$MySmartBB->loadLanguage( 'pm_show' );
		
		// ... //
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'member_zone' ] );
		
		if ( !$MySmartBB->_CONF[ 'info_row' ][ 'pm_feature' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_feature_stopped' ] );
		
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'use_pm' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_use_pm' ] );
		
		// ... //
		
		$MySmartBB->load( 'pm,icon,toolbox' );
		
		$this->_showMassege();		
	}
	
	/**
	 * Get a massege information to show it
	 */
	private function _showMassege()
	{
		global $MySmartBB;
		
		// ... //
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "' AND user_to='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ] = $MySmartBB->rec->getInfo();

		// ... //
		
		if ( !$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_doesnt_exist' ] );
		
		// ... //
		
		$MySmartBB->template->assign( 'SMARTCODE', true );
		
		$MySmartBB->func->showHeader( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'title' ] );
		
		// ... //
		
		$MySmartBB->template->assign( 'send_text', '[quote]' . $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'text' ] . '[/quote]' );
		
		// ... //
		
		$MySmartBB->rec->select = 'id,username,user_sig,user_country,user_gender,register_date,posts,user_title,visitor,avater_path,away,away_msg,hide_online,logged,username_style_cache';
		$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
		$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'user_from' ] . "'";
		
		$MySmartBB->_CONF[ 'template' ][ 'Info' ] = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->member->processMemberInfo( $MySmartBB->_CONF[ 'template' ][ 'Info' ] );
		
		// ... //
		
		$this->formatMessageContext();

		// ... //
		
		$this->getAttachments();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'pm_show_before_mark_read' );
		
		// ... //
		
		$this->markAsRead();
		
		// ... //
		
		$MySmartBB->template->assign( 'send_title', $MySmartBB->lang[ 'reply' ] . ' ' . $MySmartBB->lang_common[ 'colon' ] . ' ' . $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'title' ] );
		
		$MySmartBB->template->assign( 'to', $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'user_from' ] );
		
		$MySmartBB->template->assign( 'embedded_pm_send_call', true ); // To prevent show the menu of user cp twice
		
		// ... //
		
		$MySmartBB->func->getEditorTools();
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'pm_show_main' );
		
		// ... //
		
		$MySmartBB->template->display( 'pm_show' );
	}
	
	private function formatMessageContext()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'title' ]	=	str_replace( $MySmartBB->lang[ 'reply' ] . ' ' . $MySmartBB->lang_common[ 'colon' ], '', $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'title' ] );
		
		$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'text' ] 	=	nl2br( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'text' ] );
		$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'text '] 	=	$MySmartBB->smartparse->replace( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'text' ] );
		
		$MySmartBB->smartparse->replace_smiles( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'text' ] );
		
		if ( is_numeric( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'date' ] ) )
		{
			$MassegeDate = $MySmartBB->func->date( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'date' ] );
			$MassegeTime = $MySmartBB->func->time( $MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'date' ] );
			
			$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'date' ] = $MassegeDate . ' ; ' . $MassegeTime;
		}
	}
	
	private function getAttachments()
	{
		global $MySmartBB;
		
		$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'attach_res' ] = '';
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		$MySmartBB->rec->filter = "pm_id='" . $this->id . "'";
		$MySmartBB->rec->result = &$MySmartBB->_CONF[ 'template' ][ 'res' ][ 'attach_res' ];
		
		$MySmartBB->rec->getList();
		
		$attach_num = $MySmartBB->rec->getNumber( $MySmartBB->_CONF[ 'template' ][ 'res' ][ 'attach_res' ] );
		
		if ( $attach_num > 0 )
			$MySmartBB->template->assign( 'ATTACH_SHOW', true );
	}
	
	private function markAsRead()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'template' ][ 'MassegeRow' ][ 'user_read' ] )
		{
			$Read = $MySmartBB->pm->markMessageAsRead( $this->id );
			
			if ( $Read )
			{
				$Number = $MySmartBB->pm->newMessageNumber( $MySmartBB->_CONF[ 'member_row' ][ 'username' ] );
				
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array(	'unread_pm'	=>	$Number);
				$MySmartBB->rec->filter = "username='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
				
				$MySmartBB->rec->update();
			}
		}
	}
}

?>
