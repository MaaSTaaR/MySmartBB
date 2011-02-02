<?php

/**
 * @package : MySmartSystemFunctions
 * @author : MaaSTaaR <MaaSTaaR@hotmail.com>
 * @author : abuamal <abdullah@kuwaitphp.com>
 * @start : 23/9/2006 -> The first day of Ramadan 1427 :)
 * @updated : 10/07/2010 05:23:49 AM 
 */
 
class MySmartSystemFunctions
{
	var $Engine;
	
	function MySmartSystemFunctions($Engine)
	{
		$this->Engine = $Engine;
	}
		
	function ListProc(&$rows,$x,$param)
	{
		if (empty($param['proc']))
		{
			trigger_error('ERROR::NEED_PARAMETER',E_USER_ERROR);
		}
		
		if (is_array($param['proc']))
		{
			foreach ($param['proc'] as $f => $p)
			{
				if (!is_array($p['method']))
				{
					if ($p['method'] == 'clean')
					{
						if ($f == '*')
						{
							$this->CleanVariable($rows[$x],$p['param']);
						}
						else
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $this->CleanVariable($rows[$x][$f],$p['param']);
							}
							else
							{
								$rows[$x][$f] = $this->CleanVariable($rows[$x][$f],$p['param']);
							}
						}
					}
					elseif ($p['method'] == 'date')
					{
						if (is_numeric($rows[$x][$f]))
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $this->date($rows[$x][$f],$p['type']);
							}
							else
							{
								$rows[$x][$f] = $this->date($rows[$x][$f],$p['type']);
							}
						}
						else
						{
							if (!empty($rows[$x][$p['store']]))
							{
								$rows[$x][$p['store']] = $rows[$x][$f];
							}
							else
							{
								$rows[$x][$f] = $rows[$x][$f]; // Very smart line :p
							}
						}
					}
					elseif ($p['method'] == 'time')
					{
						if (is_numeric($rows[$x][$f]))
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $this->time($rows[$x][$f]);
							}
							else
							{
								$rows[$x][$f] = $this->time($rows[$x][$f]);
							}
						}
						else
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $rows[$x][$f];
							}
							else
							{
								$rows[$x][$f] = $rows[$x][$f];
							}
						}
					}
					elseif ($p['method'] == 'list')
					{
						$rows[$p['store']][$rows[$x][$p['id']]] = $rows[$x][$f];
					}
					elseif ($p['method'] == 'replace')
					{
						if (strstr($p['replace'],'rows{'))
						{
							$text = str_replace('rows{','',$p['replace']);
							$text = str_replace('}','',$text);
														
							$replace = $rows[$x][$text];
						}
						else
						{
							$replace = $p['replace'];
						}
						
						$rows[$x][$p['store']] = str_replace($p['search'],$replace,$rows[$x][$f]);						
					}
					else
					{
						trigger_error('ERROR::BAD_VALUE_OF_METHOD_VARIABLE',E_USER_ERROR);
					}
				}
				else
				{
					if (in_array('clean',$p['method']))
					{
						if ($f == '*')
						{
							$this->CleanVariable($rows[$x],$p['param']);
						}
						else
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $this->CleanVariable($rows[$x][$f],$p['param']);
							}
							else
							{
								$rows[$x][$f] = $this->CleanVariable($rows[$x][$f],$p['param']);
							}
						}
					}
					
					if (in_array('date',$p['method']))
					{
						if (is_numeric($rows[$x][$f]))
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $this->date($rows[$x][$f],$p['type']);
							}
							else
							{
								$rows[$x][$f] = $this->date($rows[$x][$f],$p['type']);
							}
						}
						else
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $rows[$x][$f];
							}
							else
							{
								$rows[$x][$f] = $rows[$x][$f]; // Very smart line :p
							}
						}
					}
					
					if (in_array('time',$p['method']))
					{
						if (is_numeric($rows[$x][$f]))
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $this->time($rows[$x][$f]);
							}
							else
							{
								$rows[$x][$f] = $this->time($rows[$x][$f]);
							}
						}
						else
						{
							if (!empty($p['store']))
							{
								$rows[$x][$p['store']] = $rows[$x][$f];
							}
							else
							{
								$rows[$x][$f] = $rows[$x][$f];
							}
						}
					}
					
					if (in_array('list',$p['method']))
					{						
						$rows[$p['store']][$rows[$x][$p['id']]] = $rows[$x][$f];
					}
					
					if (in_array('replace',$p['method']))
					{
						if (strstr($p['replace'],'rows{'))
						{
							$text = str_replace('rows{','',$p['replace']);
							$text = str_replace('}','',$p['replace']);
							
							$replace = &$rows[$x][$text];
						}
						else
						{
							$replace = $p['replace'];
						}
						
						$rows[$x][$p['store']] = str_replace($p['search'],$replace,$rows[$x][$f]);
					}
				}
			}
		}
		else
		{
			trigger_error('ERROR::PROC_SHOULD_BE_ARRAY',E_USER_ERROR);
		}
	}
	
 	/**
 	 * Clean the variable from any dirty :) , we should be thankful for abuamal
 	 *
 	 * By : abuamal
 	 */
	public function cleanVariable( $var, $type )
	{
		switch ( $type )
		{
			case 'sql':
				return addslashes($var);
				break;
			
			case 'html':
				return htmlspecialchars($var);
				break;
				
			case 'intval':
				return intval($var);
				break;
					
			case 'trim':
				return trim($var);
				break;
					
			case 'unhtml':
				return $this->BackHTML($var);
				break;
			
			default:
				trigger_error('ERROR::BAD_VALUE_OF_TYPE_VARIABLE',E_USER_ERROR);
				break;
		}
	}
	
	/**
	 * Clean the array from dirty, this function based on "cleanVariable( $var, $type )"
	 *
	 * By : abuamal
	 */
	public function cleanArray( &$variable, $type )
	{
		foreach ( $variable as $key => $var )
		{
			/* Multidimensional Array */
			// We should not be in this case as possible, because we want to be light.
			if ( is_array( $var ) )
			{
				$this->cleanArray( $variable[ $key ], $type );
			}
			else
			{
				if ( isset( $variable[ $key ] ) )
				{
					$variable[ $key ] = $this->cleanVariable( $var, $type );
				}
			}
		}
		
		return true;
	}
	
	/* ... */
	
	public function date( $input, $type = 'ty', $format = 'j/n/Y' )
	{
		$input = date( $format, $input );
		
		if ($type == 'n')
		{
			return $input;
		}
		else
		{
			$time = time();
		
			$date_list = array();
		
			$date_list['today'] 			= 	$time - (0 * 24 * 60 * 60);
			$date_list['today'] 			= 	date($format,$date_list['today']);
		
			$date_list['yesterday'] 		= 	$time - (1 * 24 * 60 * 60);
			$date_list['yesterday'] 		= 	date($format,$date_list['yesterday']);
		
			$date_list['before_yesterday'] 	= 	$time - (2 * 24 * 60 * 60);
			$date_list['before_yesterday'] 	= 	date($format,$date_list['before_yesterday']);
			
			$date_list['last_week'] 		= 	$time - (7 * 24 * 60 * 60);
			$date_list['last_week'] 		= 	date($format,$date_list['last_week']);
		
			$date_list['last_two_weeks'] 	= 	$time - (14 * 24 * 60 * 60);
			$date_list['last_two_weeks'] 	= 	date($format,$date_list['last_two_weeks']);
		
			$date_list['last_three_weeks'] 	= 	$time - (24 * 24 * 60 * 60);
			$date_list['last_three_weeks'] 	= 	date($format,$date_list['last_three_weeks']);
		
			$date_list['last_month'] 		= 	$time - (30 * 24 * 60 * 60);
			$date_list['last_month'] 		= 	date($format,$date_list['last_month']);
		
			if ($input == $date_list['today'])
			{
				return 'اليوم';
			}
			elseif ($input == $date_list['yesterday'])
			{
				return 'امس';
			}
			elseif ($input == $date_list['before_yesterday'])
			{
				return 'امس الاول';
			}
			elseif ($input == $date_list['last_week'])
			{
				return 'قبل اسبوع';
			}
			elseif ($input == $date_list['last_two_weeks'])
			{
				return 'قبل اسبوعين';
			}
			elseif ($input == $date_list['last_three_weeks'])
			{
				return 'قبل ثلاث اسابيع';
			}
			elseif ($input == $date_list['last_month'])
			{
				return 'قبل شهر';
			}
			else
			{
				return $input;
			}
		}		
	}
	
	/* ... */
	
	function time($time,$format='h:i:s A')
	{
		$x = date($format,$time);
		$x = strtolower($x);
		$x = str_replace('pm','مساء',$x);
		$x = str_replace('am','صباحا',$x);
				
		return $x;		
	}
	
	function BackHTML($text)
	{	
		$text = str_replace('&amp;','&',$text);
		$text = str_replace('&lt;','<',$text);
		$text = str_replace('&quot;','"',$text);
		$text = str_replace('&gt;','>',$text);
		$text = str_replace("\'","'",$text);
		
		$text = str_replace('<script','',$text);
		$text = str_replace('</script>','',$text);
		$text = str_replace('document.cookie','',$text);
		$text = str_replace('document.location','',$text);
		$text = str_replace('javascript','',$text);
		
		return $text;
	}
}

?>
