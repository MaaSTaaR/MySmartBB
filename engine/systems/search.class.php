<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartSearch
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@hotmail.com>
 * @updated 	: 	18/07/2010 04:08:46 AM 
 */
 
class MySmartSearch
{
	private $engine;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	public function search()
	{
 		/*if (!isset($param)
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
      	if ($param['section'] == 'all')
        {
			if (empty($param['username'])
				and !empty($param['keyword']))
            {
				$search_query = $this->Engine->DB->sql_query("SELECT * FROM " . $this->Engine->table['subject'] . " WHERE sec_subject<>'1' AND delete_topic<>'1' AND (text LIKE '%" . $param['keyword'] . "%' OR title LIKE '%" . $param['keyword'] . "%')");
       		}

       		if (!empty($param['username'])
       			and !empty($param['keyword']))
            {
        		$search_query = $this->Engine->DB->sql_query("SELECT * FROM " . $this->Engine->table['subject'] . " WHERE writer='" . $param['username'] . "' AND delete_topic<>'1' AND sec_subject<>'1' AND (text LIKE '%" . $param['keyword'] . "%' OR title LIKE '%" . $param['keyword'] . "%')");
       		}

      	 	if (!empty($param['username'])
      	 		and empty($param['keyword']))
            {
        		$search_query = $this->Engine->DB->sql_query("SELECT * FROM " . $this->Engine->table['subject'] . " WHERE writer='" . $param['username'] . "' AND delete_topic<>'1' AND sec_subject<>'1'");
       		}
      	}
      	else
        {
       		$s_id = $param['section'];

       		if (empty($param['username'])
       			and !empty($param['keyword']))
            {
        		$search_query = $this->Engine->DB->sql_query("SELECT * FROM " . $this->Engine->table['subject'] . " WHERE section='" . $s_id . "' AND delete_topic<>'1' AND sec_subject<>'1' AND (text LIKE '%" . $param['keyword'] . "%' OR title LIKE '%" . $param['keyword'] . "%')");
       		}

       		if (!empty($param['username'])
       			and !empty($param['keyword']))
            {
        		$search_query = $this->Engine->DB->sql_query("SELECT * FROM " . $this->Engine->table['subject'] . " WHERE section='" . $s_id . "' AND writer='" . $param['username'] . "' AND delete_topic<>'1' AND sec_subject<>'1' AND (text LIKE '%" . $param['keyword'] . "%' OR title LIKE '%" . $param['keyword'] . "%')");
       		}

       		if (!empty($param['username'])
       			and empty($param['keyword']))
            {
        		$search_query = $this->Engine->DB->sql_query("SELECT * FROM " . $this->Engine->table['subject'] . " WHERE writer='" . $param['username'] . "' AND delete_topic<>'1' AND section='" . $s_id . "' AND sec_subject<>'1'");
       		}
      	}

		$rows = $this->engine->rec->getList($search_query,$param);
      	
      	return (is_array($rows)) ? $rows : false;*/
 	}
}
 
 ?>
