<?php

/*
 * @package : MySmartPager
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started : 24-8-2007 6:53 AM
 * @last update : Thu 01 Sep 2011 08:22:31 AM AST 
 * @under : GNU LGPL
*/

class MySmartPager
{
	private $total;					// The total number of rows
	private $rows_perpage;			// How many rows per page
	private $count;					// Variable which help us to do pagers
	private $location;				// The web page location
	private $location_ext;
	private $pages_number;			// The number of pages
	private $var_name;				// The count's variable name
	private $print_style = array();	// The style of print
	private $limit;					// How many of pages will print?
	private $i;						// Will use it in loop
	private $page;					// The current page (Inside the loop)
	private $p;
	
	function SetInformation($style)
	{
		$this->print_style = $style;
	}
	
	/**
	 * This function setup important variables and count the pages number
	 */
	public function start( $total, $rows_perpage, $count, $location, $var )
	{
		$this->total 		= 	($total < 0) ? 0 : $total;
		$this->rows_perpage = 	($rows_perpage < 0) ? 10 : $rows_perpage;
		$this->count 		= 	($count < 0) ? 0 : $count;
		$this->location		=	$location;
		$this->var_name		=	$var;
		$this->limit		=	3;
		
		// We want integer only in pages number, so we use ceil();
		$this->pages_number = 	ceil($this->total/$this->rows_perpage);
		
		if ( strstr( $this->location, '#' ) != false )
		{
			$loc = explode( '#', $this->location );
			
			$this->location = $loc[ 0 ];
			$this->location_ext = '#' . $loc[ 1 ];
		}
		else
		{
			$this->location_ext = '';
		}
	}
	
	/**
	 * Return output which contain pages with links
	 */
	public function show()
	{
		$this->i = 0;
		$this->page = 1;
		
		if ($this->total > $this->rows_perpage)
		{
			$output = $this->print_style[0];
			
			while ( $this->page <= $this->pages_number )
			{
				if ( $this->pages_number > $this->limit )
				{
					$last 	= 	$this->pages_number;
					$i 		= 	( $this->pages_number * $this->rows_perpage ) - $this->rows_perpage;
					
					if ( $this->page <= $this->limit )
					{
						if ($this->count == $this->i)
						{
							$output .= $this->_proc($this->print_style[1]);
						}
						else
						{
							$output .= $this->_proc($this->print_style[2]);
						}
					}
					else
					{
						$this->i = $i;
						$this->page = $last;
						
						//$output .= '...';
						
						if ($this->count == $this->i)
						{
							$output .= $this->_proc($this->print_style[1]);
						}
						else
						{
							$output .= $this->_proc($this->print_style[2]);
						}
						
						break;
					}
				}
				else
				{
					if ( $this->count == $this->i )
					{
						$output .= $this->_proc($this->print_style[1]);
					}
					else
					{
						$output .= $this->_proc($this->print_style[2]);
					}
				}
				
				$this->i = $this->i + $this->rows_perpage;
				$this->page += 1;
			}
		}
		else
		{
			$output = $this->print_style[0];
			
			$output .= $this->_proc($this->print_style[1]);
		}
		
		$output .= $this->print_style[3];
		
		return $output;
	}
	
	function _proc($string)
	{
		/**
		 * [l] = location
		 * [v] = var_name
		 * [c] = i
		 * [p] = page
		 */
		 
		$string = str_replace('[l]',$this->location,$string);
		$string = str_replace('[v]',$this->var_name,$string);
		$string = str_replace('[c]',$this->i . $this->location_ext,$string);
		$string = str_replace('[p]',$this->page,$string);
		
		return $string;
	}
}

?>
