<?php

/*
 * @package : MySmartRecords
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started : 19/4/2007 11:55 AM
 * @update : Tue 31 Jan 2012 06:57:16 AM AST 
 * @license : GNU LGPL
 * @version : 2.1.0
*/

/**
 * History
 * 2.1.0 :
 *          - Add createTable() and dropTable()
 *          - Add addFields() and dropFields()
 *
 */

class MySmartRecords
{
	private $db; // Database class
	private $func; // Functions class (must implement the function cleanVariable)
	private $pager_obj; // Pager class
	private $query;
	private $info_cb = null;
	private $debug = true;
	
	public $filter;
	public $fields;
	public $table;
	public $order;
	public $limit;
	public $result;
	
	// For select()
	public $select;
	public $join;
	
	// Pager information (Array)
	public $pager;
	
	// ID
	public $get_id;
	public $id;
	
	// ... //
	
	function __construct( $db, $func, $pager )
	{
		$this->db = $db;
		$this->func = $func;
		$this->pager_obj = $pager;
	}
	
	// ... //
	
	public function select()
	{
		if ( !isset( $this->table ) )
		{
			if ( $this->debug )
			{
				echo '<pre dir="ltr">';
				debug_print_backtrace();
				echo '</pre>';
			}
				
			trigger_error('ERROR::NEED_PARAMETER -- FROM Select() -- table',E_USER_ERROR);
		}
		
		// ... //
		
		$statement 	= 	'SELECT ';
		$statement	.=	( isset( $this->select ) ) ? $this->select : '*'; // Choose fields to fetch, or fetch all of them
		$statement	.=	' FROM ' . $this->table;
		
		unset( $this->select, $this->table );
		
		// ... //
		
		if ( isset( $this->join ) )
		{
			$statement .= ' JOIN ' . $this->join;
			
			unset( $this->join );
		}
		
		// ... //
				
		if ( isset( $this->filter ) )
		{
			$statement .= ' WHERE ' . $this->filter;
		
			unset( $this->filter );
		}
		
		// ... //
		
		if ( isset( $this->order ) )
		{
			$statement .= ' ORDER BY ' . $this->order;
			
			unset( $this->order );
		}
		
		// ... //
		
		if ( is_object( $this->pager_obj ) and is_array( $this->pager ) )
		{
			$statement = $this->initPager( $statement );
		}
		
		// ... //
		
		// We can only use "LIMIT" in our statement when the user didn't request to use pagination system
	    if ( isset( $this->limit ) and !is_array( $this->pager ) )
		{
			$statement .= ' LIMIT ' . $this->limit;
				
			unset( $this->limit );
		}

		// ... //
		
		$query = $this->db->sql_query( $statement );
		
		return $query;
	}
	
	// ... //
	
	private function initPager( $statement )
	{
	    if (!isset( $this->pager[ 'total' ] ) or !isset( $this->pager[ 'perpage' ] ) 
	        or !isset( $this->pager[ 'count' ] ) or empty( $this->pager[ 'location' ] )
	        or empty( $this->pager[ 'var' ] ) )
	    {
	        trigger_error( 'ERROR::NEED_PARAMETER -- FROM initPager() -- PAGER', E_USER_ERROR );
	    }
	    
	    $this->pager[ 'perpage' ] 	= ( $this->pager[ 'perpage' ] < 0 ) ? 10 : $this->pager[ 'perpage' ];
	    $this->pager[ 'count' ] 	= ( $this->pager[ 'count' ] < 0 ) ? 0 : $this->pager[ 'count' ];
	    
	    $this->pager_obj->start(    $this->pager[ 'total' ], 
	                                $this->pager[ 'perpage' ], 
	                                $this->pager[ 'count' ], 
	                                $this->pager[ 'location' ], 
	                                $this->pager[ 'var' ] );
	    
	    $statement .= ' LIMIT ' . $this->pager['count'] . ',' . $this->pager['perpage'];
	    
	    return $statement;
	}
	
	// ... //
	
	// This function adds slashes to input automatically.
	public function insert()
	{
		// ... //
			
		if ( empty( $this->table ) or empty( $this->fields ) )
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM Insert() -- TABLE OR FIELD', E_USER_ERROR );
		
		// ... //
		
		$statement = 'INSERT INTO ' . $this->table . ' SET ';
		
		unset( $this->table );
		
		// ... //
		
		$size = sizeof( $this->fields );
		
		$i = 0;
		          	
		foreach ( $this->fields as $name => $value )
		{
			$statement .= $name . '=' . "'" . $this->func->cleanVariable( $value, 'sql' ) . "'"; // Ensure there is no SQL Injection by adding slashes
			
			if ( $i < $size - 1 )
			{
				$i += 1;
				
				$statement .= ',';
			}
		}
		
		unset( $this->fields );
		
		// ... //
		
		$query = $this->db->sql_query( $statement, true );
		
		// ... //
		
		if ( $this->get_id )
		{
			$this->id = $this->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		// ... //
		
		return $query;
	}
	
	// ... //
	
	public function update()
	{
		if ( !isset( $this->table )
			or !isset( $this->fields ) )
		{		
			if ( $this->debug )
			{
				echo '<pre dir="ltr">';
				debug_print_backtrace();
				echo '</pre>';
			}
			
			trigger_error( 'ERROR::NEED_PARAMETER -- FROM Update() -- TABLE OR FIELD', E_USER_ERROR  );
		}
		
		// ... //
				
		$statement = "UPDATE " . $this->table . " SET ";
		
		unset( $this->table );
		
		// ... //
		
		$f = array_filter( $this->fields, array( 'MySmartRecords', '_updateCallBack' ) ); // TODO :: explain why?
		
		$size = sizeof( $f );
		
		$i = 0;
		$x = 0;
		
		foreach ( $f as $name => $value )
		{
			$statement .= $name . '=' . "'" . $this->func->cleanVariable( $value, 'sql' ) . "'"; // Ensure there is no SQL Injection by adding slashes
		
			if ( $i < $size - 1 )
			{
				$i += 1;
				
				$statement .= ',';
			}
		}
		
		unset( $this->fields );
		
		// ... //
		
		if ( isset( $this->filter ) )
		{
			$statement .= ' WHERE ' . $this->filter;
		
			unset( $this->filter );
		}
		
		// ... //
		
		$query = $this->db->sql_query( $statement, true );
		
		return $query;
	}
	
	// ... //
	
	public function getList()
	{
		$query = $this->select();
		
		if ( !isset( $this->result ) )
		{
			$this->query = $query;
		}
		else
		{
			$this->query = $this->result = $query;
			
			unset( $this->result );
		}
	}
	
	// ... //
	
	public function getInfo( $result = null )
	{
		if ( is_null( $result ) )
		{
			// There is no request to a list, so we just need one row
			if ( !isset( $this->query ) )
				$query = $this->select();
			else
				$query = $this->query;
		}
		elseif ( $result == false )
		{
			$query = $this->select();
		}
		else
		{
			$query = $result;
		}
		
		$row = $this->db->sql_fetch_array( $query );
		
		// To prevent the user from any XSS attack, clean the data from html tags.
		if ( is_array( $row ) )
		{
			/* 
		 	 * Note : This feature is new and important one that comes with the new version of MySmartRecords
		 	 * the main goal of this feature is improving the performance, instead of clean the array after getting
		 	 * the whole data we clean it immediately after getting it from the database.
		 	 */
		 	 
			$this->func->cleanArray( $row, 'html' );
			
			if ( isset( $this->info_cb ) )
				call_user_func( $this->info_cb, &$row );
		}
		
		// If there is a request of a list and there is no more rows, unset this->query
		if ( isset( $this->query ) and $row == false )
			unset( $this->query );
		
		return $row;
	}
	
	// ... //
	
	public function getNumber( $result = null )
	{
	    $query = ( !isset( $result ) ) ? $this->select() : $result;
		
		$num = $this->db->sql_num_rows( $query );
		
		return is_numeric( $num ) ? $num : $query;
	}

	// ... //
		
	public function delete()
	{
		if ( !isset( $this->table ) )
			trigger_error('ERROR::NEED_PARAMETER -- FROM delete() -- TABLE',E_USER_ERROR);
		
		// ... //
		
		$statement = 'DELETE FROM ' . $this->table;
		
		unset( $this->table );
		
		// ... //
		
		if ( isset( $this->filter ) )
		{
			$statement .= ' WHERE ' . $this->filter;
		
			unset( $this->filter );
		}
		
		// ... //
		
		if ( isset( $this->order ) )
		{
			$statement .= ' ORDER BY ' . $this->order;
			
			unset( $this->order );
		}
		
		// ... //
		
		if ( isset( $this->limit ) )
		{
			$statement .= ' LIMIT ' . $this->limit;
			
			unset( $this->limit );
		}
		
		// ... //

		$query = $this->db->sql_query( $statement, true );
		
		return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function createTable()
	{
	    if ( !isset( $this->table ) or !is_array( $this->fields ) )
	        trigger_error( 'MySmartRecords::createTable() -> empty table or fields', E_USER_ERROR );
	    
	    $statement = 'CREATE TABLE ' . $this->table . ' (';
	    
	    $fields_num = sizeof( $this->fields );
	    $k = 1;
	    
	    foreach ( $this->fields as $name => $def )
	    {
	        $statement .= $name . ' ' . $def;
	        
	        if ( $k < $fields_num )
	            $statement .= ',';
	        
	        $k++;
	    }
	    
	    $statement .= ')';
	    
	    $query = $this->db->sql_query( $statement );
	    
	    unset( $this->table, $this->fields );
	    
	    return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function dropTable()
	{
	    if ( !isset( $this->table ) )
	        trigger_error( 'MySmartRecords::dropTable() -> empty table', E_USER_ERROR );
	    
	    $query = $this->db->sql_query( "DROP TABLE " . $this->table );
	    
	    unset( $this->table );
	    
	    return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function addFields()
	{
	    if ( !isset( $this->table ) or !is_array( $this->fields ) )
	        trigger_error( 'MySmartRecords::addFields() -> empty table or fields', E_USER_ERROR );

	    $statement = 'ALTER TABLE ' . $this->table . ' ';
	    
	    $fields_num = sizeof( $this->fields );
	    $k = 1;
	    
	    foreach ( $this->fields as $name => $def )
	    {
	        $statement .= 'ADD ' . $name . ' ' . $def;
	        
	        if ( $k < $fields_num )
	            $statement .= ',';
	        
	        $k++;
	    }
	    
	    $query = $this->db->sql_query( $statement );
	    
	    unset( $this->table, $this->fields );
	    
	    return ( $query ) ? true : false;
	}
	
	// ... //
	
	public function dropFields()
	{
	    if ( !isset( $this->table ) or !is_array( $this->fields ) )
	        trigger_error( 'MySmartRecords::dropFields() -> empty table or fields', E_USER_ERROR );

	    $statement = 'ALTER TABLE ' . $this->table . ' ';
	    
	    $fields_num = sizeof( $this->fields );
	    $k = 1;
	    
	    foreach ( $this->fields as $key => $name )
	    {
	        $statement .= 'DROP ' . $name;
	        
	        if ( $k < $fields_num )
	            $statement .= ',';
	        
	        $k++;
	    }
	    
	    $query = $this->db->sql_query( $statement );
	    
	    unset( $this->table, $this->fields );
	    
	    return ( $query ) ? true : false;
	}
	
	// ... //
	
	/*
	 * setInfoCallback() :
	 *      Set a function that runs with every row fetch in "getInfo"
	**/
	public function setInfoCallback( $cb )
	{
		$this->info_cb = $cb;
	}
	
	// ... //
	
	public function removeInfoCallback()
	{
		$this->info_cb = null;
	}
	
	// ... //
	
	private function _updateCallBack( $var )
	{
		return ( ( isset( $var ) or !empty( $var ) ) ) ? true : false;
	}
	
	// ... //
}

?>
