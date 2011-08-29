<?php

// Last Update : Fri 26 Aug 2011 10:37:13 PM AST 

class MySmartSQL
{
	protected $host				=	'localhost';
	protected $db_username		=	'';
	protected $db_password		=	'';
	protected $db_name			=	'';
	protected $use_pconnect		=	true;
	private $_from;
	private $_query;
	
	function __construct( $host, $db_username, $db_password, $db_name )
	{
		$this->host        = $host;
		$this->db_username = $db_username;
		$this->db_password = $db_password;
		$this->db_name     = $db_name;
	}
	
	public function sql_connect()
	{
		$function = ( !$this->use_pconnect ) ? 'mysql_connect' : 'mysql_pconnect';
		
		$connect = @$function( $this->host, $this->db_username, $this->db_password );
		
		$this->_from = 'connect';
		
		if ( !$connect )
		{
			$this->_error();
		}
		
		return $connect;
	}

	public function sql_select_db()
	{
		$select = @mysql_select_db( $this->db_name );
		
		$this->_from = 'select';
		
		if ( !$select )
		{
			$this->_error();
		}
		
		return $select;
	}
	
	public function sql_close()
	{
		$close = @mysql_close();
		
		$this->_from = 'close';
		
		if (!$close)
		{
			$this->_error();
		}
		
		return $close;
	}
	
	public function sql_query( $query, $unbuffered = false )
	{
		$function = ( !$unbuffered ) ? 'mysql_query' : 'mysql_unbuffered_query';
		
		$result = @$function( $query );
		
		$this->_from = 'query';
		
		if (!$result)
		{
			$this->_query = $query;
			
			$this->_error();
		}
			
		return $result;
	}
	
	public function sql_fetch_array( $result )
	{
		// Only returns associative array
		$out = @mysql_fetch_array( $result, MYSQL_ASSOC );
		
		return $out;
	}
	
	public function sql_num_rows( $result )
	{
		$out = @mysql_num_rows( $result );
		
		return $out;
	}
	
	public function sql_insert_id()
	{
		$out = @mysql_insert_id();
		
		return $out;
	}
	
	public function check( $table )
	{
		$result = mysql_query( "SELECT * FROM " . $table );
		
		if (!$result)
		{
			$err = mysql_errno();
			
			if ($err == 1146)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	
	public function _error()
	{
		$error_no  = mysql_errno();
		$error_msg = mysql_error();
		
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

		echo '<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ar" lang="ar">';

		echo '<head>';
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo '<title>خطأ في قواعد البيانات</title>';
		echo '<style type="text/css"> body { font-family:tahoma; font-size:12px; } </style>';
		echo '</head>';
		echo '<body dir="rtl">';
		echo '<div align="center">';
		echo 'حدث خطأ مع قواعد البيانات <br />';
		
		if (!empty($this->_from))
		{
			echo '<strong>';
			echo 'سبب الخطأ : ';
			
			if ($this->_from == 'connect')
			{
				echo 'الاتصال بقواعد البيانات';
			}
			elseif ($this->_from == 'select')
			{
				echo 'اختيار قاعدة البيانات';
			}
			elseif ($this->_from == 'close')
			{
				echo 'اغلاق الاتصال';
			}
			elseif ($this->_from == 'query')
			{
				echo 'استعلام';
			}
			else
			{
				echo 'غير معروف';
			}
			
			echo '</strong>';
			echo '<br />';
		}
		
		echo 'رقم الخطأ : ' . $error_no . '<br />';
		echo 'رسالة الخطأ : ' . $error_msg . '<br />';
		
		if ($this->debug)
		{
			echo 'الاستعلام المسبب للخطأ : <br />';
			echo '<div dir="ltr">';
			echo $this->_query;
			echo '</div>';
		}
		
		echo '</div>';
		echo '</body>';
		
		exit();
	}
}
?>
