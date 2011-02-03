<?php

/**
 * MySmartBB Engine - The Engine Helps You To Create Bulletin Board System.
 */
 
/**
 * @package 	: 	MySmartSection
 * @author 		: 	Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @updated 	: 	24/07/2010 12:24:46 PM 
 */
 
class MySmartSection
{
	private $engine;
	
	public $id;
	public $get_id;
	
	/* ... */
	
	function __construct( $engine )
	{
		$this->engine = $engine;
	}
	
	/* ... */
	
	function insertSection()
	{
		$this->engine->rec->table = $this->engine->table[ 'section' ];
		
		$query = $this->engine->rec->insert();
		
		if ( $this->get_id )
		{
			$this->id = $this->engine->db->sql_insert_id();
			
			unset( $this->get_id );
		}
		
		return ( $query ) ? true : false;
	}
	
	/* ... */
	
 	public function updateSection()
 	{
 		$this->engine->rec->table = $this->engine->table['section'];
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 		
	public function deleteSection()
	{
 		$this->engine->rec->table = $this->engine->table[ 'section' ];
 		
 		$query = $this->engine->rec->delete();
 		
 		return ($query) ? true : false;
	}
	
	/* ... */
	
	public function getSectionsList()
 	{
 		$this->engine->rec->table = $this->engine->table[ 'section' ];
 		
 		$this->engine->rec->getList();
 	}
 	
 	/* ... */
	
 	/**
 	 * Get section information
 	 */
	public function getSectionInfo()
	{
		$this->engine->rec->table = $this->engine->table['section'];
		
		return $this->engine->rec->getInfo();
	}
	
	/* ... */
 	
	public function getSectionNumber()
 	{
  		$this->engine->rec->table = $this->engine->table[ 'section' ];
 		
 		return $this->engine->rec->getNumber();
 	}
 	
 	/* ... */
 	
 	// TODO :: DELETE ME!
	/**
	 * Get admin section list
	 *
	 */
	/*function GetSectionAdminList($param)
	{
 		if (!isset($param) 
 			or !is_array($param))
 		{
 			$param = array();
 		}
 		
 		$param['select'] 	= 	'*';
 		$param['from'] 		= 	$this->engine->table['section_admin'];
 		
 	 	$rows = $this->engine->rec->GetList($param);
 	       
		return $rows;
	}*/
	
 	/* ... */
 	
 	public function checkPassword( $password, $id )
 	{
 		if (empty( $id )
 			or empty( $password ))
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM checkPassword() -- EMPTY id OR password',E_USER_ERROR);
 		}
 		
 		$MySmartBB->rec->table = $this->engine->table['section'];
 		$MySmartBB->rec->filter = "id='" . $id . "' AND section_password='" . $password . "'";
 		
      	$num = $this->engine->rec->getNumber();
      	
      	return ($num <= 0) ? false : true;
 	}
 	
 	/* ... */
 	
 	public function updateLastSubject( $writer, $title, $subject_id, $date, $section_id )
 	{
 		if ( !isset( $writer )
 			or !isset( $title )
 			or !isset( $subject_id )
 			or !isset( $date )
 			or !isset( $section_id ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateLastSubject()',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->table = $this->engine->table['section'];
 		
 		$MySmartBB->rec->fields = array(	'last_writer'	=>	$writer,
 											'last_subject'	=>	$title,
 											'last_subjectid'	=>	$subject_id,
 											'last_date'	=>	$date	);
 		
 		$MySmartBB->rec->filter = "id='" . $section_id . "'";
 		
		$query = $this->engine->rec->update();
		           
		return ( $query ) ? true : false;
 	}
 	
 	/* ... */
 	
	public function createSectionsCache( $parent )
 	{
 		if ( !isset( $parent ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM createSectionsCache()',E_USER_ERROR);
 		}
 		
 		$this->engine->rec->filter = "parent='" . $parent . "'";
 		$this->engine->rec->order = "sort ASC";
 		
 		$forums = $this->getSectionsList();
 		
 		$cache = array();
 		$x = 0;
 		
 		while ( $forum = $this->rec->getInfo() )
 		{
 			$cache[$x] 							= 	array();
			$cache[$x]['id'] 					= 	$forum['id'];
			$cache[$x]['title'] 				= 	$forum['title'];
			$cache[$x]['section_describe'] 		= 	$forum['section_describe'];
			$cache[$x]['parent'] 				= 	$forum['parent'];
			$cache[$x]['sort'] 					= 	$forum['sort'];
			$cache[$x]['section_picture'] 		= 	$forum['section_picture'];
			$cache[$x]['sectionpicture_type'] 	= 	$forum['sectionpicture_type'];
			$cache[$x]['use_section_picture'] 	= 	$forum['use_section_picture'];
			$cache[$x]['linksection'] 			= 	$forum['linksection'];
			$cache[$x]['linkvisitor'] 			= 	$forum['linkvisitor'];
			$cache[$x]['last_writer'] 			= 	$forum['last_writer'];
			$cache[$x]['last_subject'] 			= 	$forum['last_subject'];
			$cache[$x]['last_subjectid'] 		= 	$forum['last_subjectid'];
			$cache[$x]['last_date'] 			= 	$forum['last_date'];
			$cache[$x]['subject_num'] 			= 	$forum['subject_num'];
			$cache[$x]['reply_num'] 			= 	$forum['reply_num'];
			$cache[$x]['moderators'] 			= 	$forum['moderators'];
			$cache[$x]['forums_cache'] 			= 	$forum['forums_cache'];
			
			/* ... */
			
			$cache[$x]['groups'] 				= 	array();
			
 			$this->engine->rec->filter = "section_id='" . $forum['id'] . "'";
 			$this->engine->rec->order = "id ASC";
 			
			$this->engine->group->getSectionGroupList();
			
			while ( $group = $this->rec->getInfo() )
			{
				$cache[$x]['groups'][$group['group_id']] 					=	array();
				$cache[$x]['groups'][$group['group_id']]['view_section'] 	= 	$group['view_section'];
				$cache[$x]['groups'][$group['group_id']]['main_section'] 	= 	$group['main_section'];
			}
 			
 			/* ... */
 				
			$x += 1;
 		}
 		
 		if ( $x > 0 )
 		{
 			$cache = serialize( $cache );
 			$cache = base64_encode( $cache );
 		}
 		else
 		{
 			$cache = false;
 		}
 		 		
		return $cache;
	}
	
	/* ... */
	
 	public function updateSectionsCache( $parent )
 	{
 		if ( !isset( $parent ) )
 		{
 			trigger_error('ERROR::NEED_PARAMETER -- FROM updateSectionsCache()',E_USER_ERROR);
 		}
 		
 		$cache = $this->createSectionsCache( $parent );
 		
 		if ( $cache == false )
 		{
 			$cache = '';
 		}
 		
 		$this->engine->rec->fields = array(	'forums_cache'	=>	$cache	);
 		$this->engine->rec->filter = "id='" . $parent . "'";
 		
 		$update = $this->updateSection();
 		
 		return ($update) ? true : false;
 	}
 	
 	/* ... */
 	
 	public function updateAllSectionsCache()
 	{
 		$this->getSectionsList();
 		
 		$fail = false;
 		
 		while ( $row = $this->engine->rec->getInfo() )
 		{
 			if (!empty($row['forums_cache']))
 			{
 				$this->engine->rec->fields					=	array();
 				$this->engine->rec->fields['forums_cache'] 	= 	$this->createSectionsCache( $row['id'] );
 				
 				$this->engine->rec->filter = "id='" . $row[ 'id' ] . "'";
 				
 				$update = $this->updateSection();
 				
 				if (!$update)
 				{
 					$fail = true;
 				}
 			}
 			else
 			{
 				continue;
 			}
 		}
 		
 		return ($fail) ? false : true;
 	}
 	
 	/* ... */
}
 
?>
