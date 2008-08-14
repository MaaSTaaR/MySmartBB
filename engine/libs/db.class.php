<?php

class MySmartSQL
{
	var $host			=	'localhost';
	var $db_username	=	'';
	var $db_password	=	'';
	var $db_name		=	'';
	var $use_pconnect	=	true;
	var $debug			=	false;
	var $store_queries	=	false;
	var $queries		=	array();
	var $number;
	var $_from;
	var $_query;
	var $_x = 0;

	function SetInformation($host,$db_username,$db_password,$db_name)
	{
		$this->host        = $host;
		$this->db_username = $db_username;
		$this->db_password = $db_password;
		$this->db_name     = $db_name;
	}
	
	function SetDebug($debug)
	{
		$this->debug = $debug;
	}
	
	function SetQueriesStore($store)
	{
		$this->store_queries = $store;
	}
		
	function GetQueriesNumber()
	{
		return $this->number;
	}
	
	function GetQueriesArray()
	{
		return $this->queries;
	}
	
	function sql_connect()
	{
		$function = (!$this->user_pconnect) ? 'mysql_connect' : 'mysql_pconnect';
		
		$connect = @$function($this->host,$this->db_username,$this->db_password);
		
		$this->_from = 'connect';
		
		if (!$connect)
		{
			$this->_error();
		}
		
		return $connect;
	}

	function sql_select_db()
	{
		$select = @mysql_select_db($this->db_name);
		
		$this->_from = 'select';
		
		if (!$select)
		{
			$this->_error();
		}
		
		return $select;
	}
	
	function sql_close()
	{
		$close = @mysql_close();
		
		$this->_from = 'close';
		
		if (!$close)
		{
			$this->_error();
		}
		
		return $close;
	}
	
	function sql_query($query)
	{
		$result = @mysql_query($query);
		
		$this->_from = 'query';
		
		if (!$result)
		{
			$this->_query = $query;
			
			$this->_error();
		}
		
		/*$MySmartBB->_CONF['temp']['query_numbers']++;
		
		$MySmartBB->_CONF['temp']['queries'][] = $query;
		
		if ($this->debug)
		{
			if ($this->store_queries)
			{
				//$this->queries[$this->_x++] = $query;
			}
		}*/
			
		return $result;
	}
	
	function sql_unbuffered_query($query)
	{		
		$result = @mysql_unbuffered_query($query);
		
		$this->_from = 'query';
		
		if (!$result)
		{
			$this->_query = $query;
			
			$this->_error();
		}
		
		/*$MySmartBB->_CONF['temp']['query_numbers']++;
		
		$MySmartBB->_CONF['temp']['queries'][] = $query;
		
		if ($this->debug)
		{
			if ($this->store_queries)
			{
				$this->queries[$this->_x++] = $query;
			}
		}*/
			
		return $result;		
	}
	
	function sql_fetch_array($result)
	{
		$out = @mysql_fetch_array($result,MYSQL_ASSOC);
		
		return $out;
	}
	
	function sql_num_rows($result)
	{
		$out = @mysql_num_rows($result);
		
		return $out;
	}
	
	function sql_insert_id()
	{
		$out = @mysql_insert_id();
		
		return $out;
	}
	
	function check($table)
	{
		$result = @mysql_query("SELECT * FROM " . $table);
		
		if (!$result)
		{
			$err = mysql_errno();
			
			if ($err = 1146)
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
	
	function _error()
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
