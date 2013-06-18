<?php

include( 'topic_management.module.php' );

define( 'CLASS_NAME', 'MySmartManagementRepeatedMOD' );

class MySmartManagementRepeatedMOD extends MySmartManagementMOD
{
	public function run( $id )
	{
		global $MySmartBB;
		
		parent::run( $id );
		
		// ... //
		
		$MySmartBB->load( 'subject,section,cache' );
		
		// ... //
		
		if ( empty( $MySmartBB->_POST[ 'url' ] ) )
			die( $MySmartBB->lang_common[ 'please_fill_information' ] );
		
		// ... //
		
		$update = $MySmartBB->subject->closeSubject( $MySmartBB->lang[ 'repeated_subject' ], $this->subject_info[ 'id' ] );
		
		if ( $update )
		{
			$MySmartBB->rec->table = $MySmartBB->table[ 'reply' ];
			$MySmartBB->rec->fields = array(	'text'			=>	$MySmartBB->lang[ 'repeated_subject_see_original' ] . " [url=" . $MySmartBB->_POST['url'] . "]" . $MySmartBB->lang_common[ 'here' ] . '[/url]',
					'writer'		=>	$MySmartBB->_CONF[ 'member_row' ][ 'username' ],
					'subject_id'	=>	$this->subject_info[ 'id' ],
					'write_time'	=>	$MySmartBB->_CONF[ 'now' ],
					'section'		=>	$this->subject_info[ 'section' ]	);
			 
			$insert = $MySmartBB->rec->insert();
		
			if ( $insert )
			{
				// ... //
		
				$MySmartBB->rec->table = $MySmartBB->table[ 'member' ];
				$MySmartBB->rec->fields = array(	'lastpost_time'	=>	$MySmartBB->_CONF[ 'now' ]	);
				$MySmartBB->rec->filter = "id='" . $MySmartBB->_CONF[ 'member_row' ][ 'id' ] . "'";
		
				$UpdateMember = $MySmartBB->rec->update();
					
				// ... //
					
				$MySmartBB->subject->updateWriteTime( $this->subject_info[ 'id' ] );
		
				$MySmartBB->subject->updateReplyNumber( $this->subject_info[ 'id' ] );
					
				$MySmartBB->section->updateLastSubject( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $this->subject_info[ 'title' ], $this->subject_info[ 'id' ], $MySmartBB->_CONF[ 'now' ],  ( !$this->subject_info[ 'sub_section' ] ) ? $this->subject_info[ 'id' ] : $this->subject_info[ 'from_sub_section' ] );
		
				$MySmartBB->cache->updateReplyNumber();
		
				$MySmartBB->subject->updateLastReplier( $MySmartBB->_CONF[ 'member_row' ][ 'username' ], $this->subject_info[ 'id' ] );
		
				$MySmartBB->section->updateReplyNumber( $this->subject_info[ 'section' ] );
		
				// We need to update forum's cache to show the correct number of statistics in the main page
				$MySmartBB->section->updateForumCache( null, $this->subject_info[ 'section' ] );
		
				// ... //
		
				echo $MySmartBB->lang[ 'update_succeed' ];
			}
		}
	}
}

?>