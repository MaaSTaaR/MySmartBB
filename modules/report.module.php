<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartReportMOD' );

class MySmartReportMOD
{
	public function run()
	{
		global $MySmartBB;
		
		if ( !$MySmartBB->_CONF[ 'member_permission' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'no_permission_visitors' ] );
		
		$MySmartBB->loadLanguage( 'report' );
		
		$MySmartBB->func->showHeader( $MySmartBB->lang[ 'template' ][ 'send_report' ] );
		
		$this->_commonCode();
		
		if ( $MySmartBB->_GET[ 'index' ] )
		{
			$this->_memberReportIndex();
		}
		elseif ( $MySmartBB->_GET[ 'start' ] )
		{
			$this->_memberReportStart();
		}
		
		$MySmartBB->func->getFooter();
	}
	
	private function _memberReportIndex()
	{
		global $MySmartBB;
		
		$MySmartBB->template->assign( 'subject_id', $MySmartBB->_GET[ 'subject_id' ] );
		
		if ( !empty( $MySmartBB->_GET[ 'reply_id' ] ) )
			$MySmartBB->template->assign( 'reply_id', $MySmartBB->_GET[ 'reply_id' ] );
		
		$MySmartBB->template->display( 'send_report' );
	}
	
	private function _memberReportStart()
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'text' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$MySmartBB->_POST[ 'text' ] .= "\n" . $MySmartBB->func->getForumAdress() . 'index.php?page=topic&show=1&id=' . $MySmartBB->_GET[ 'subject_id' ];
		
		if ( !empty( $MySmartBB->_GET[ 'reply_id' ] ) )
			$MySmartBB->_POST[ 'text' ] .= "#" . $MySmartBB->_GET[ 'reply_id' ];
		
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
	
	private function _commonCode()
	{
		global $MySmartBB;
		
		$MySmartBB->_GET[ 'subject_id' ] = (int) $MySmartBB->_GET[ 'subject_id' ];
		
		if ( empty( $MySmartBB->_GET[ 'subject_id' ] ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	}
}

?>
