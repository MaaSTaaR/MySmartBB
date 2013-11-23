<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartReportMOD' );

class MySmartReportMOD
{
	public function run( $subject_id, $reply_id = null )
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		$MySmartBB->template->assign( 'subject_id', $subject_id );
		
		if ( !is_null( $reply_id ) )
			$MySmartBB->template->assign( 'reply_id', $reply_id );
		
		$MySmartBB->template->display( 'send_report' );		
	}
	
	public function start( $subject_id, $reply_id = null )
	{
		global $MySmartBB;
		
		$this->commonProcesses();
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->_POST[ 'text' ] .= "\n" . $MySmartBB->func->getForumAdress() . 'index.php/topic/' . $subject_id;
		
		if ( !is_null( $reply_id ) )
			$MySmartBB->_POST[ 'text' ] .= "#" . $reply_id;
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'email_msg' ];
		$MySmartBB->rec->filter = "id='3'";
				
		$messageInfo = $MySmartBB->rec->getInfo();
		
		$messageInfo[ 'text' ] = $MySmartBB->func->htmlDecode( $messageInfo[ 'text' ] ) . $MySmartBB->_POST[ 'text' ];
		
		// ... //
		
		$Report = $MySmartBB->func->mail(	$MySmartBB->_CONF[ 'info_row' ][ 'admin_email' ],
											$messageInfo[ 'title' ],
											$messageInfo[ 'text' ],
											$MySmartBB->_CONF[ 'member_row' ][ 'email' ] );
		
		if ( $Report )
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'report_sent' ] );
			$MySmartBB->func->move( 'index.php' );
		}
		else
		{
			$MySmartBB->func->msg( $MySmartBB->lang[ 'send_failed' ] );
		}		
	}
	
	private function commonProcesses()
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'report' );
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_visitors' ] );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'send_report' ] );
	}
}

?>
