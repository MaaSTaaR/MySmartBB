<?php

class MySmartUpgrader
{
	private $engine;
	private $path;
	
	function __construct( $engine, $version )
	{
		$this->engine = $engine;
		$this->path = 'data/' . $version . '/';
	}
	
	public function addFields()
	{
		$this->_executeCommands( $this->path . 'add_fields' );
	}
	
	public function dropFields()
	{
		$this->_executeCommands( $this->path . 'drop_fields' );
	}
	
	private function _executeCommands( $path )
	{
		if ( !file_exists( $path ) )
		{
			$this->engine->func->msg( 'خطأ : الملف التالي غير موجود ' . $path );
			die();
		}
		
		$sqls = file( $path );
		$lines = sizeof( $sqls );
		
		if ( is_array( $sqls ) )
		{
			$k = 1;
			
			foreach ( $sqls as $sql )
			{
				// Replace #table_name# with the real table name which stored in $MySmartBB->table according to key
				$sql = preg_replace_callback( '/#[A-Za-z0-9]+#/', array( 'MySmartUpgrader', '_getTableName' ), $sql );
				
				$query = $this->engine->db->sql_query( $sql );
				
				if ( $query )
				{
					$this->engine->func->msg( 'تمّت العمليه ' . $k . ' من الملف ' . $path );
				}
				else
				{
					$this->engine->func->msg( 'فشلت العمليه ' . $k . ' من الملف ' . $path );
				}
				
				$k += 1;
			}
		}
	}
	
	private function _getTableName( $key )
	{
		$key = str_replace( '#', '', $key[ 0 ] );
		
		return $this->engine->table[ $key ];
	}
}

?>
