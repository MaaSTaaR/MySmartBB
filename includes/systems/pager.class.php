<?php

/*
 * @package : MySmartPager
 * @author : Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @started : 24-8-2007 6:53 AM
 * @last update : Fri 02 Sep 2011 03:23:52 AM AST 
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
	private $page = 1;					// The current page (Inside the loop)
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
		$this->pages_number = 	ceil( $this->total / $this->rows_perpage );
		
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
		$output = $this->print_style[ 0 ];
		
		if ( $this->total > $this->rows_perpage )
		{
			if ( $this->pages_number > $this->limit )
			{
				$current_page = ( ( $this->count / $this->rows_perpage ) + 1 );
				
				$this->page = $current_page;
				$this->i = $this->count;
				
				
				$k = ( $this->page + $this->limit );

				while ( $this->page <= $k )
				{
					if ( $this->page < $this->pages_number )
					{
						if ( $current_page == $this->page )
							$output .= $this->_proc( $this->print_style[ 1 ] );
						else
							$output .= $this->_proc( $this->print_style[ 2 ] );
					
				
						$this->i += $this->rows_perpage;
						$this->page++;
					}
					else
					{
						break;
					}
				}
				
				// ~ The last page ~ //
				$this->i = ( $this->pages_number * $this->rows_perpage ) - $this->rows_perpage;
				$this->page = $this->pages_number;
				
				if ( $current_page == $this->page )
					$output .= $this->_proc( $this->print_style[ 1 ] );
				else
					$output .= $this->_proc( $this->print_style[ 2 ] );
			}
			else
			{
				$current_page = ( ( $this->count / $this->rows_perpage ) + 1 );
			
				$this->page = $current_page;
				$this->i = $this->count;
			
				while ( $this->page <= $this->pages_number )
				{
					if ( $current_page == $this->page )
						$output .= $this->_proc( $this->print_style[ 1 ] );
					else
						$output .= $this->_proc( $this->print_style[ 2 ] );
			
					$this->i += $this->rows_perpage;
					$this->page++;
				}
			}
		}
		else
		{
			$current_page = ( ( $this->count / $this->rows_perpage ) + 1 );
			
			$this->page = $current_page;
			$this->i = $this->count;
			
			while ( $this->page <= $this->pages_number )
			{
				if ( $current_page == $this->page )
					$output .= $this->_proc( $this->print_style[ 1 ] );
				else
					$output .= $this->_proc( $this->print_style[ 2 ] );
			
				$this->i += $this->rows_perpage;
				$this->page++;
			}
		}
		
		$output .= $this->print_style[ 3 ];
		
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
