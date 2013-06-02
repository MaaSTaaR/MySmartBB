<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

define( 'COMMON_FILE_PATH', dirname( __FILE__ ) . '/common.module.php' );

include( 'common.php' );

define( 'CLASS_NAME', 'MySmartDownloadMOD' );

class MySmartDownloadMOD
{
	private $type;
	private $id;
	
	public function run( $type, $id )
	{
		global $MySmartBB;
		
		$this->type = $type;
		$this->id = (int) $id;
		
		// ... //
		
		$MySmartBB->loadLanguage( 'download' );
		
		// ... //
		
		if ( empty( $this->id ) )
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
		
		// ... //
		
		if ( $type == 'subject' )
			$this->_downloadSubject();
		elseif ( $type == 'attach' )
			$this->_downloadAttach();
		elseif ( $type == 'pm' )
			$this->_downloadPM();
		else
			$MySmartBB->func->error( $MySmartBB->lang_common[ 'wrong_path' ] );
	}
	
	private function _downloadSubject()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$SubjectInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		if ( $SubjectInfo[ 'delete_topic' ] and !$MySmartBB->_CONF[ 'group_info' ][ 'admincp_allow' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_in_trash' ] );
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $SubjectInfo[ 'section' ] . "'";
		
		$SectionInfo = $MySmartBB->rec->getInfo();
		
		// ... //
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $SectionInfo[ 'id' ] . "' AND group_id='" . $MySmartBB->_CONF[ 'group_info' ][ 'id' ] . "'";
		
		$SectionGroup = $MySmartBB->rec->getInfo();
		
		if ( !$SectionGroup[ 'view_section' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_view_topic' ] );
		
		// ... //
		
		$MySmartBB->plugin->runHooks( 'download_subject_start' );
		
		// ... //
		
		$filename = str_replace( ' ', '_', $SubjectInfo[ 'title' ] );
		$filename .= '.txt';
		
		header( 'Content-Disposition: attachment;filename=' . $filename );
		header( 'Content-type: text/plain' );
		
		// ... //

		echo $MySmartBB->lang[ 'topic_title' ] . ' ' . $SubjectInfo[ 'title' ] . "\n" . $MySmartBB->lang[ 'topic_writer' ] . ' ' . $SubjectInfo[ 'writer' ] . "\n\n" . $SubjectInfo[ 'text' ];
	}
	
	private function _downloadAttach()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "'";
		
		$AttachInfo = $MySmartBB->rec->getInfo();
		
		if ( !$AttachInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_download_attach' ] );
		
		// ... //
		
		if ( $AttachInfo[ 'pm_id' ] == '0' )
		{
			$subject_id = $AttachInfo[ 'subject_id' ];
			
			if ( $AttachInfo[ 'reply' ] )
			{
				$MySmartBB->rec->select = 'id,subject_id';
				$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
				$MySmartBB->rec->filter = "id='" . $AttachInfo[ 'subject_id' ] . "'";
				
				$reply_info = $MySmartBB->rec->getInfo();
				
				$subject_id = $reply_info[ 'subject_id' ];
			}
			
			$this->__checkTopicPermissions( $subject_id );
		}
		else
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
			$MySmartBB->rec->filter = "id='" . $AttachInfo[ 'pm_id' ] . "' AND user_to='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
			
			$pm_info = $MySmartBB->rec->getInfo();
			
			if ( !$pm_info )
				$MySmartBB->func->error( $MySmartBB->lang[ 'cant_download_attach' ] );
		}

		// ... //
		
		$MySmartBB->plugin->runHooks( 'download_attachment_start' );
		
		// ... //
		
		// Send headers
		
		// File name
		header('Content-Disposition: attachment;filename=' . $AttachInfo['filename']);
		
		// File size (bytes)
		header('Content-Length: ' . $AttachInfo['filesize']);
		
		// MIME (TODO : dynamic)
		header('Content-type: application/download');
		
		// ... //
		
		// Count a new download
		$MySmartBB->rec->table = $MySmartBB->table[ 'attach' ];
		$MySmartBB->rec->fields = array(	'visitor'	=>	$AttachInfo['visitor'] + 1);
		$MySmartBB->rec->filter = "id='" . $AttachInfo['id'] . "'";
		
		$update = $MySmartBB->rec->update();
		
		// ... //
		
		// File content
		echo file_get_contents( './' . $AttachInfo['filepath'] );
		
		// ... //
	}
	
	private function _downloadPM()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'pm' ];
		$MySmartBB->rec->filter = "id='" . $this->id . "' AND user_to='" . $MySmartBB->_CONF[ 'member_row' ][ 'username' ] . "'";
		
		$info = $MySmartBB->rec->getInfo();
		
		if ( !$info )
			$MySmartBB->func->error( $MySmartBB->lang[ 'pm_doesnt_exist' ] );
		
		$info['title'] = $MySmartBB->func->cleanVariable( $info['title'], 'html' );
		
		$filename = str_replace( ' ', '_', $info[ 'title' ] );
		$filename .= '.txt';
		
		$MySmartBB->plugin->runHooks( 'download_pm_start' );
		
		// ... //
		
		// Send headers
		
		// File name
		header( 'Content-Disposition: attachment;filename=' . $filename );
		
		// MIME
		header( 'Content-type: text/plain' );
		
		// ... //
		
		echo $MySmartBB->lang[ 'pm_title' ] . ' ' . $info[ 'title' ] . "\n" . $MySmartBB->lang[ 'pm_sender' ] . ' ' . $info[ 'user_from' ] . "\n\n" . $info[ 'text' ];
	}
	
	private function __checkTopicPermissions( $id )
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "id='" . $id . "'";
		
		$SubjectInfo = $MySmartBB->rec->getInfo();
		
		if ( !$SubjectInfo )
			$MySmartBB->func->error( $MySmartBB->lang[ 'cant_download_attach' ] );
		
		// ... //
		
		// The subject isn't available
		if ( $SubjectInfo[ 'delete_topic' ] and !$MySmartBB->_CONF[ 'group_info' ][ 'admincp_allow' ] )
			$MySmartBB->func->error( $MySmartBB->lang[ 'topic_in_trash' ] );
		
		// ... //
		
		// We can't stop the admin :)
		if ( !$MySmartBB->_CONF[ 'group_info' ][ 'admincp_allow' ] )
		{
			// ... //
				
			$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
			$MySmartBB->rec->filter = "section_id='" . $SubjectInfo[ 'section' ] . "' AND group_id='" . $MySmartBB->_CONF[ 'group_info' ][ 'id' ] . "'";
				
			$SectionGroup = $MySmartBB->rec->getInfo();
				
			// ... //
		
			// The user can't show this subject
			if ( !$SectionGroup[ 'view_section' ] )
				$MySmartBB->func->error( $MySmartBB->lang[ 'cant_view_topic' ] );
		
			// The user can't download this attachment
			if ( !$SectionGroup[ 'download_attach' ] )
				$MySmartBB->func->error( $MySmartBB->lang[ 'cant_download_attach' ] );
				
			// These checks are special for members
			if ( $MySmartBB->_CONF[ 'member_permission' ] )
			{
				// No enough posts
				if ( $MySmartBB->_CONF[ 'group_info' ][ 'download_attach_number' ] > $MySmartBB->_CONF[ 'member_row' ][ 'posts' ] )
					$MySmartBB->func->error( $MySmartBB->lang[ 'your_posts_must_be' ] . ' ' . $MySmartBB->_CONF[ 'group_info' ][ 'download_attach_number' ] );
			}
		}
	}
}

?>
