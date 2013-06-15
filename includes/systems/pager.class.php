<?php

/**
 * @package MySmartPager
 * @author Mohammed Q. Hussain <MaaSTaaR@gmail.com>
 * @since 24-8-2007 6:53 AM 
 * @license GNU LGPL
*/

class MySmartPager
{
	private $total;					// The total number of rows
	private $rows_perpage;			// How many rows per page
	private $count;					// Variable which help us to do pagers
	private $prefix;				// The prefix of web page location
	private $suffix;				// The suffix of web page location
	private $location_ext;
	private $pages_number;			// The number of pages
	private $print_style = array();	// The style of print
	private $limit;					// How many of pages will be printed?
	private $i;						// Will use it in loop
	private $page = 1;				// The current page (Inside the loop)
	private $p;
	private $curr_page;
	
	public function setOutput( $style )
	{
		if ( !is_array( $style ) )
			return false;
		
		$this->print_style = $style;
	}
	
	/**
	 * This function setup important variables and count the pages number
	 */
	public function start( $total, $rows_perpage, $curr_page, $prefix = null, $suffix = null )
	{
		$this->total 		= 	( $total < 0 ) ? 0 : $total;
		$this->rows_perpage = 	( $rows_perpage < 0 ) ? 10 : $rows_perpage;
		$this->curr_page 	= 	( $curr_page < 1 ) ? 1 : $curr_page;
		$this->prefix		=	$prefix;
		$this->suffix		=	$suffix;
		$this->limit		=	3; // TODO : I'll be glad if we use a dynamic value ;-)
		
		// We want integer only in pages number, so we use ceil();
		$this->pages_number = 	ceil( $this->total / $this->rows_perpage );
	}
	
	/**
	 * Return output which contain pages with links
	 */
	public function show()
	{
		$output = $this->print_style[ 0 ];
		
		// ... //
		
		// We should always print the First Page
		
		if ( $this->curr_page != 1 )
		{
			//$this->i = 0;
			$this->page = 1;
			
			$output .= $this->_proc( $this->print_style[ 2 ] );
		}
		
		// ... //
		
		// Shows the previous page if the current page is the 3rd or less
		if ( $this->curr_page <= 3 )
			$this->page = ( $this->curr_page > 2 ) ? $this->curr_page - 1 : $this->curr_page;
		else // Shows the _two_ previous pages if the current page is the 4th or greater
			$this->page = $this->curr_page - 2;
		
		// ... //
		
		// The total of rows bigger than the rows that should be shown per page
		// so we have work to do.
		if ( $this->total > $this->rows_perpage )
		{
			if ( $this->pages_number > $this->limit )
			{
				$k = ( $this->page + $this->limit );
				
				while ( $this->page <= $k )
				{
					if ( $this->page < $this->pages_number )
					{
						if ( $this->curr_page == $this->page )
							$output .= $this->_proc( $this->print_style[ 1 ] );
						else
							$output .= $this->_proc( $this->print_style[ 2 ] );
						
						$this->page++;
					}
					else
					{
						break;
					}
				}
				
				// ~ The last page ~ //
				$this->page = $this->pages_number;
				
				if ( $this->curr_page == $this->page )
					$output .= $this->_proc( $this->print_style[ 1 ] );
				else
					$output .= $this->_proc( $this->print_style[ 2 ] );
			}
			else
			{
				while ( $this->page <= $this->pages_number )
				{
					if ( $this->curr_page == $this->page )
						$output .= $this->_proc( $this->print_style[ 1 ] );
					else
						$output .= $this->_proc( $this->print_style[ 2 ] );
			
					$this->i += $this->rows_perpage;
					$this->page++;
				}
			}
		}
		
		$output .= $this->print_style[ 3 ];
		
		return $output;
	}
	
	private function _proc( $string )
	{
		$string = str_replace( '[p]', $this->page, $string );
		$string = str_replace( '[prefix]', $this->prefix, $string );
		$string = str_replace( '[suffix]', $this->suffix, $string );
		
		return $string;
	}
}

?>
