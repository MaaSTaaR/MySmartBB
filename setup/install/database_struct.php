<?php

include('../common.php');

class MySmartInstaller
{
	private $tables = array();
	private $rows = array();
	private $tables_path = 'tables/';
	private $rows_path = 'info/';
	private $engine;
	private $lang; // Language array
	
	function __construct( $engine, $lang )
	{
		$this->engine = $engine;
		$this->lang = $lang;
		
		// Prepare $tables and $rows
		$this->_addTables();
		$this->_addRows();
	}
	
	public function createTables()
	{
		if ( is_array( $this->tables ) )
		{
			$tables_num = sizeof( $this->tables );
			$k = 1;
			
			foreach ( $this->tables as $table )
			{
				// ... //
				
				$filename = $this->tables_path . $table[ 'filename' ];
				
				if ( !file_exists( $filename ) )
				{
					$this->msg( $this->lang[ 'file_doesnt_exist' ] . ' ' . $filename );
					die();
				}
				
				// ... //
				
				$fp = fopen( $filename, 'r' );
				
				$sql = fread( $fp, filesize( $filename ) );
				
				fclose( $fp );
				
				$sql = str_replace( '#table#', $table[ 'tablename' ], $sql );
				
				// ... //
				
				if ( !empty( $sql ) )
				{
					$query = $this->engine->db->sql_query( $sql );
					
					if ( $query )
					{
						$this->msg( $k . '/' . $tables_num . ' ' . $this->lang[ 'created' ] . ' ' . $table[ 'tablename' ] );
					}
					else
					{
						$this->msg( $k . '/' . $tables_num . ' ' . $this->lang[ 'create_failed' ] . ' ' . $table[ 'tablename' ] );
					}
				}
				
				// ... //
				
				$k += 1;
			}
		}
		else
		{
			$this->msg( $this->lang[ 'error_in_tables_array' ] );
			die();
		}
	}
	
	public function insertInformation()
	{
		if ( is_array( $this->rows ) )
		{
			$rows_num = sizeof( $this->rows );
			$k = 1;
			$success = array();
			
			foreach ( $this->rows as $row )
			{
				// ... //
				
				$filename = $this->rows_path . $row[ 'filename' ];
				
				if ( !file_exists( $filename ) )
				{
					$this->msg( $this->lang[ 'file_doesnt_exist' ] . ' ' . $filename );
					die();
				}
				
				// ... //
				
				$sqls = file( $filename );
				$lines = sizeof( $sqls );
				
				// ... //
				
				if ( is_array( $sqls ) )
				{
					$x = 1;
					
					foreach ( $sqls as $sql )
					{
					    $matches = array();
					    
						$sql = str_replace( '#table#', $row[ 'tablename' ], $sql );
						
						preg_match_all( '/lang\((.*?)\)/', $sql, &$matches );
						
						foreach ( $matches[ 1 ] as $idx => $key )
						{
						    $sql = str_replace( 'lang(' . $key . ')', addslashes( $this->lang[ 'data' ][ $key ] ), $sql );
						}
						
						$query = $this->engine->db->sql_query( $sql );
						
						if ( $query )
						{
							$this->msg( $this->lang[ 'process_succeed' ] . ' ' . $x . '/' . $lines . '::' . $filename );
						}
						else
						{
							$this->msg( $this->lang[ 'process_failed' ] . ' ' . $x . '/' . $lines . '::' . $filename );
						}
						
						$x += 1;
					}
				}
				
				// ... //
				
				$k += 1;
			}
		}
		else
		{
			$this->msg( $this->lang[ 'error_in_tables_array' ] );
			die();
		}
	}
	
	private function _addTables()
	{
		$this->_addTable( 'ads', $this->engine->table[ 'ads' ] );
		$this->_addTable( 'announcement', $this->engine->table[ 'announcement' ] );
		$this->_addTable( 'attach', $this->engine->table[ 'attach' ] );
		$this->_addTable( 'avatar', $this->engine->table[ 'avatar' ] );
		$this->_addTable( 'banned', $this->engine->table[ 'banned' ] );
		$this->_addTable( 'email_msg', $this->engine->table[ 'email_msg' ] );
		$this->_addTable( 'extension', $this->engine->table[ 'extension' ] );
		$this->_addTable( 'group', $this->engine->table[ 'group' ] );
		$this->_addTable( 'info', $this->engine->table[ 'info' ] );
		$this->_addTable( 'member', $this->engine->table[ 'member' ] );
		$this->_addTable( 'moderators', $this->engine->table[ 'moderators' ] );
		$this->_addTable( 'online', $this->engine->table[ 'online' ] );
		$this->_addTable( 'pages', $this->engine->table[ 'pages' ] );
		$this->_addTable( 'pm', $this->engine->table[ 'pm' ] );
		$this->_addTable( 'poll', $this->engine->table[ 'poll' ] );
		$this->_addTable( 'reply', $this->engine->table[ 'reply' ] );
		$this->_addTable( 'requests', $this->engine->table[ 'requests' ] );
		$this->_addTable( 'section', $this->engine->table[ 'section' ] );
		$this->_addTable( 'section_group', $this->engine->table[ 'section_group' ] );
		$this->_addTable( 'smiles', $this->engine->table[ 'smiles' ] );
		$this->_addTable( 'style', $this->engine->table[ 'style' ] );
		$this->_addTable( 'subject', $this->engine->table[ 'subject' ] );
		$this->_addTable( 'tags', $this->engine->table[ 'tag' ] );
		$this->_addTable( 'tags_subject', $this->engine->table[ 'tag_subject' ] );
		$this->_addTable( 'today', $this->engine->table[ 'today' ] );
		$this->_addTable( 'toolbox', $this->engine->table[ 'toolbox' ] );
		$this->_addTable( 'usertitle', $this->engine->table[ 'usertitle' ] );
		$this->_addTable( 'vote', $this->engine->table[ 'vote' ] );
		$this->_addTable( 'plugins', $this->engine->table[ 'plugin' ] );
		$this->_addTable( 'hooks', $this->engine->table[ 'hook' ] );
	}
	
	private function _addRows()
	{
		$this->_addRow( 'email_msg', $this->engine->table[ 'email_msg' ] );
		$this->_addRow( 'extension', $this->engine->table[ 'extension' ] );
		$this->_addRow( 'group', $this->engine->table[ 'group' ] );
		$this->_addRow( 'icons', $this->engine->table[ 'smiles' ] );
		$this->_addRow( 'info', $this->engine->table[ 'info' ] );
		$this->_addRow( 'smiles', $this->engine->table[ 'smiles' ] );
		$this->_addRow( 'style', $this->engine->table[ 'style' ] );
		$this->_addRow( 'toolbox', $this->engine->table[ 'toolbox' ] );
		$this->_addRow( 'usertitle', $this->engine->table[ 'usertitle' ] );
	}
	
	private function _addTable( $filename, $tablename )
	{
		$this->tables[] = array(	'filename'	=>	$filename,
									'tablename'	=>	$tablename	);
	}
	
	private function _addRow( $filename, $tablename )
	{
		$this->rows[] = array(	'filename'	=>	$filename,
								'tablename'	=>	$tablename	);
	}
	
	private function msg( $msg )
	{
		echo $msg . '<br />';
	}
}

?>
