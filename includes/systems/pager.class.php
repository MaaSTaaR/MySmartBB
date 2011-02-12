<?php
/*
Started : 24-8-2007 6:53 AM
*/

class MySmartPager
{
	var $total;					// The total number of rows
	var $perpage;				// How many rows per page
	var $count;					// Variable which help us to do pagers
	var $location;				// The web page location
	var $pages_number;			// The number of pages
	var $var_name;				// The count's variable name
	var $print_style = array();	// The style of print
	var $limit;					// How many of pages will print?
	var $i;						// Will use it in loop
	var $x;						// Will use it in loop
	var $p;
	
	function SetInformation($style)
	{
		$this->print_style = $style;
	}
	
	/**
	 * This function setup important variables and count the pages number
	 */
	function start($total,$perpage,$count,$location,$var)
	{
		$this->total 		= 	($total < 0) ? 0 : $total;
		$this->perpage 		= 	($perpage < 0) ? 10 : $perpage;
		$this->count 		= 	($count < 0) ? 0 : $count;
		$this->location		=	$location;
		$this->var_name		=	$var;
		$this->limit		=	3;
		
		// We want integer only in pages number, so we use ceil();
		$this->pages_number = 	ceil($this->total/$this->perpage);
	}
	
	/**
	 * Return output which contain pages with links
	 */
	function show()
	{
		$this->i = 0;
		$this->x = 1;
		
		if ($this->total > $this->perpage)
		{
			$output = $this->print_style[0];
			
			while ($this->x <= $this->pages_number)
			{
				if ($this->pages_number > $this->limit)
				{
					$last 	= 	$this->pages_number;
					$i 		= 	($this->pages_number * $this->perpage) - $this->perpage;
					
					if ($this->x <= $this->limit)
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
						$this->x = $last;
						
						$output .= $this->_proc($this->print_style[2]);
						
						break;
					}
				}
				else
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
				
				$this->i = $this->i + $this->perpage;
				$this->x += 1;
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
		 * [p] = x
		 */
		 
		$string = str_replace('[l]',$this->location,$string);
		$string = str_replace('[v]',$this->var_name,$string);
		$string = str_replace('[c]',$this->i,$string);
		$string = str_replace('[p]',$this->x,$string);
		
		return $string;
	}
}

?>
