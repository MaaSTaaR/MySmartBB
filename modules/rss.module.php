<?php

( !defined( 'IN_MYSMARTBB' ) ) ? die() : '';

include( 'common.module.php' );

define( 'CLASS_NAME', 'MySmartRSSMOD' );

class MySmartRSSMOD
{
	public function run( $type, $section_id = null )
	{
		global $MySmartBB;
		
		$MySmartBB->loadLanguage( 'rss' );
		
		echo '<?xml version="1.0"?>';
		echo '<rss version="2.0">';
		echo '<channel>';
		echo '<title>' . $MySmartBB->_CONF[ 'info_row' ][ 'title' ] . '</title>';
		echo '<link>' . $MySmartBB->func->getForumAdress() . '</link>';
		echo '<description>' . $MySmartBB->lang[ 'latest_subjects_rss' ] . ' ' . $MySmartBB->_CONF[ 'info_row' ][ 'title' ] . '</description>';
		
		if ( $type == 'subject' )
			$this->_subjectRSS();
		elseif ( $type == 'section' )
			$this->_sectionRSS( $section_id );
		
		echo '</channel>';
		echo '</rss>';
	}
	
	private function _subjectRSS()
	{
		global $MySmartBB;
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "delete_topic<>'1' AND sec_subject<>'1'";
		$MySmartBB->rec->order = "write_time DESC";
		$MySmartBB->rec->limit = '10';
		
		$MySmartBB->rec->getList();
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			echo '<item>';
			echo '<title>' . $row[ 'title' ] . '</title>';
			echo '<link>' . $MySmartBB->func->getForumAdress() . 'index.php?page=topic&amp;show=1&amp;id=' . $row[ 'id' ] . '</link>';
			echo '<description>' . $row[ 'text' ] . '</description>';
			echo '</item>';
		}
	}
	
	private function _sectionRSS( $section_id )
	{
		global $MySmartBB;
		
		if ( is_null( $section_id ) )
		{
			echo '<item>';
			echo '<title>' . $MySmartBB->lang_common[ 'wrong_path' ] . '</title>';
			echo '</item>';
			
			return false;
		}

		$MySmartBB->rec->table = $MySmartBB->table[ 'section' ];
		$MySmartBB->rec->filter = "id='" . $section_id . "'";
		
		$Section = $MySmartBB->rec->getInfo();
		
		if ( !$Section )
		{
			echo '<item>';
			echo '<title>' . $MySmartBB->lang[ 'section_doesnt_exist' ] . '</title>';
			echo '</item>';
		
			return false;
		}
		
		if ( $Section[ 'parent' ] == 0 )
		{
			echo '<item>';
			echo '<title>' . $MySmartBB->lang[ 'this_is_main_section' ] . '</title>';
			echo '</item>';
				
			return false;
		}
		
		if ( !empty( $Section[ 'section_password' ] ) )
		{
			echo '<item>';
			echo '<title>' . $MySmartBB->lang[ 'section_protected' ] . '</title>';
			echo '</item>';
				
			return false;
		}
		
		$MySmartBB->rec->table = $MySmartBB->table[ 'section_group' ];
		$MySmartBB->rec->filter = "section_id='" . $Section[ 'id' ] . "' AND group_id='" . $MySmartBB->_CONF[ 'group_info' ][ 'id' ] . "'";
		
		$SectionGroup = $MySmartBB->rec->getInfo();
		
		if ( !$SectionGroup[ 'view_section' ] )
		{
			echo '<item>';
			echo '<title>' . $MySmartBB->lang[ 'cant_view_section' ] . '</title>';
			echo '</item>';
			
			return false;
		}

		$MySmartBB->rec->table = $MySmartBB->table[ 'subject' ];
		$MySmartBB->rec->filter = "section='" . $section_id . "' AND delete_topic<>'1'";
		$MySmartBB->rec->order = "write_time DESC";
		$MySmartBB->rec->limit = '10';
		
		$MySmartBB->rec->getList();
		
		while ( $row = $MySmartBB->rec->getInfo() )
		{
			echo '<item>';
			echo '<title>' . $row[ 'title' ] . '</title>';
			echo '<link>' . $MySmartBB->func->getForumAdress() . 'index.php?page=topic&amp;show=1&amp;id=' . $row[ 'id' ] . '</link>';
			echo '<description>' . $row[ 'text' ] . '</description>';
			echo '</item>';			
		}
	}
}

?>
