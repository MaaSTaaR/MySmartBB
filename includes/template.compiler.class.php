<?php
/**
 * MySmartBB's compiler for MySmartTemplate
 */

class MySmartTemplateCompiler
{
	protected $while_num;
	
	protected $x_loop				=	0;
	protected $size_loop			=	0;
	protected $_while_var			=	null;
	protected $_while_var_num		=	0;
	protected $_foreach_var			=	null;
	protected $_foreach_var_num		=	0;
	private $vars_list				=	array();
	
	public $vars 					= 	array();
	public $while_array				=	array();
	public $foreach_array			=	array();
	
	/* ... */
	
	function __construct( $MySmartBB )
	{
		$this->while_array 		= 	array();
		$this->foreach_array 	= 	array();
		$this->_vars 			= 	array();
		$this->_while_var 		= 	array();
		$this->_foreach_var 	= 	array();
		
		$this->vars = &$MySmartBB->_CONF[ 'template' ];
	}
	
	/* ... */
	
	public function assign( $varname, $value )
	{
		$this->vars[ $varname ] = $value;
	}
	
	/* ... */
	
	public function compile( $string )
	{
		//////////
		
		/* We need to avoid PHP's Warning and Notice messages */
		if ( preg_match( '~\{\$([^[<].*?)\}~', $string )
			or preg_match( '~\{\$([^[<].*?)\[([^[<].*?)\]\}~', $string )
			or preg_match( '~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\[\'([^[<].*?)\'\]\}~', $string ) )
		{
			$vars_search = array();
			$var_replace = array();
			
			$vars_search[] = '~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\[\'([^[<].*?)\'\]\}~ie';
			$vars_replace[] = '$this->_registerVariable( \'\\1\', \'\\2\', \'\\3\' );';
			
			$vars_search[] = '~\{\$([^[<].*?)\[([^[<].*?)\]\}~ie';
			$vars_replace[] = '$this->_registerVariable( \'\\1\', \'\\2\' );';
			
			$vars_search[] = '~\{\$([^[<].*?)\}~ie';
			$vars_replace[] = '$this->_registerVariable( \'\\1\' );';
			
			preg_replace( $vars_search, $vars_replace, $string );
			
			$string = $this->_defineVariables( $string );
		}
		
		//////////
		
		if (preg_match('~\{Des::while}{([^[<].*?)}~',$string)
			or preg_match('~\{Des::while::complete}~',$string))
		{
			$string = $this->_proccessWhile($string);
		}
		
		//////////
		
		if (preg_match('~\{Des::foreach}{([^[<].*?)}~',$string))
		{
			$string = $this->_proccessForeach($string);
		}
		
		//////////
		
		if (preg_match('~\{if (.*)\}~',$string))
		{
			$string = $this->_proccessIfStatement($string);
		}
		
		/* ... */
		
		$search_array 	= 	array();
		$replace_array 	= 	array();
		
		/* ... */
		
		/** Array **/
		
		// 2D
		$search_array[] 	= 	'~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\[\'([^[<].*?)\'\]\}~';
		$replace_array[] 	= 	'<?php echo $this->compiler->vars[\'\\1\'][\'\\2\'][\'\\3\']; ?>';
		
		// 2D - Without apostrophes
		$search_array[] 	= 	'~\{\$([^[<].*?)\[([^[<].*?)\]\[([^[<].*?)\]\}~';
		$replace_array[] 	= 	'<?php echo $this->compiler->vars[\'\\1\'][\'\\2\'][\'\\3\']; ?>';
		
		// 1D
		$search_array[] 	= 	'~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\}~';
		$replace_array[] 	= 	'<?php echo $this->compiler->vars[\'\\1\'][\'\\2\']; ?>';
		
		// 1D - Without apostrophes
		$search_array[] 	= 	'~\{\$([^[<].*?)\[([^[<].*?)\]\}~';
		$replace_array[] 	= 	'<?php echo $this->compiler->vars[\'\\1\'][\'\\2\']; ?>';
		
		/** End of Array **/
		
		/* ... */
		
		// Variable
		$search_array[] 	= 	'~\{\$([^[<].*?)\}~';
		$replace_array[] 	= 	'<?php echo $this->compiler->vars[\'\\1\']; ?>';
		
		/* ... */
		
		$search_array[] 	= 	'~\{template}([^[<].*?){/template}~';
		$replace_array[] 	= 	'<?php $this->display(\'\\1\'); ?>';
		
		$search_array[] 	= 	'~\{include}([^[<].*?){/include}~';
		$replace_array[] 	= 	'<?php include(\\1); ?>';
		
		/* ... */
		
		$string = preg_replace( $search_array, $replace_array, $string );
		
		return $string;
	}
	
	/* ... */
	
	/**
	 * The first step to kill PHP's warning and notice messages.
	 */
	private function _registerVariable()
	{
		$args_num = func_num_args();
		$args = func_get_args();
				
		// An array
		if ( $args_num > 1 )
		{
			foreach ( $args as $arg )
			{
				$array_syntax_args = '[\'' . $arg . '\']';
			}
			
			$value = '$this->compiler->vars' . $array_syntax_args;
		}
		// Normal variable
		else
		{
			$value = '$this->compiler->vars[\'' . $args[ 0 ] . '\']';
		}
		
		$value = str_replace( '$this->compiler->vars[\'\'', '$this->compiler->vars[\'', $value );
		$value = str_replace( '\'\']', '\']', $value );
		
		// Duplication is not allowed
		if ( !in_array( $value, $this->vars_list ) )
		{
			$this->vars_list[] = $value;
		}
	}
	
	/* ... */
	
	/**
	 * The second step to kill PHP's warning and notice messages.
	 */
	 
	private function _defineVariables( $string )
	{
		$define_string = '<?php';
		
		foreach ( $this->vars_list as $var )
		{
			$define_string .= ' if ( !isset( ' . $var . ' ) ) { ' . $var . ' = null; } 
			';
		}
		
		$define_string .= '?>';
		
		$string = $define_string . $string;
		
		return $string;
	}
	
	/* ... */
	
	private function _proccessWhile( $string )
	{
		/* ... */
		
		$search_array 	= 	array();
		$replace_array 	= 	array();
		
		/* ... */
		
		// I am sorry, but we _must_ do that
		$string = preg_replace( '~\{Des::while}{([^[<].*?)}~ise', '$this->_storeWhileVarName(\'\\1\');', $string );
		
		/* ... */
		
		// If statement _must_ be first
		if ( preg_match( '~\{if (.*)\}~', $string )
			or preg_match( '~if (.*) {~', $string ) )
		{
			$string = $this->_proccessIfStatement( $string, 'while' );
		}
		
		/* ... */
		
		foreach ( $this->_while_var as $var_name )
		{
			$search_array[] 	=	'~\{\{\$' . $var_name . '\[([^[<].*?)\]\}\}~';
			$replace_array[] 	=	'$this->compiler->vars[\'while\'][\'' . $var_name . '\'][$this->x_loop][\\1]';
		
			$search_array[] 	=	'~\{\$' . $var_name . '\[([^[<].*?)\]\}~';
			$replace_array[] 	=	'<?php echo $this->compiler->vars[\'while\'][\'' . $var_name . '\'][$this->x_loop][\\1]; ?>';
		}
		
		/* ... */
		
		$string = preg_replace( $search_array, $replace_array, $string );
		
		/* ... */
		
		$string = str_replace( '{/Des::while}', '<?php $this->x_loop = $this->x_loop + 1; } ?>', $string);
		$string = str_replace( '{Des::while::complete}', '', $string);
		$string = str_replace( '{/Des::while::complete}', '', $string);
		
		/* ... */
		
		$this->_while_var 		= 	null;
		$this->_while_var_num 	= 	0;
		
		/* ... */
		
		return $string;	
	}
	
	/* ... */
	
	private function _storeWhileVarName( $varname )
	{
		$this->_while_var[ $this->_while_var_num ] = $varname;
		
		$this->_while_var_num += 1;
		
		return '<?php $this->x_loop = 0; $this->size_loop = sizeof($this->compiler->vars[\'while\'][\'' . $varname . '\']); while ($this->x_loop < $this->size_loop) { ?>';
	}
	
	/* ... */
	
	private function _proccessForeach( $string )
	{
		/* ... */
		
		$search_array 	= 	array();
		$replace_array 	= 	array();
		
		/* ... */
		
		$string = preg_replace( '~\{Des::foreach}{([^[<].*?)}{([^[<].*?)}~ise', '$this->_storeForeachVarName(\'\\2\',\'\\1\');', $string );
		
		/* ... */
		
		if ( preg_match( '~\{if (.*)\}~', $string )
			or preg_match( '~if (.*) {~', $string ) )
		{
			$string = $this->_ProccessIfStatement( $string, 'foreach' );
		}
		
		/* ... */
		
		foreach ( $this->_foreach_var as $var_name )
		{		
			$search_array[] 	= 	'~\{{\$' . $var_name . '\}}~';
			$replace_array[] 	= 	'$' . $var_name;

			$search_array[] 	=	'~\{{\$' . $var_name . '\[([^[<].*?)\]}}~';
			$replace_array[] 	=	'$' . $var_name . '[\\1]';
			
			$search_array[] 	= 	'~\{\$' . $var_name . '\}~';
			$replace_array[] 	= 	'<?php echo $' . $var_name . '; ?>';
			
			$search_array[] 	=	'~\{\$' . $var_name . '\[([^[<].*?)\]\}~';
			$replace_array[] 	=	'<?php echo $' . $var_name . '[\\1]; ?>';
		}
		
		$search_array[] 	=	'~\{counter}~';
		$replace_array[] 	=	'<?php echo $this->x_loop ?>';
		
		$search_array[] 	=	'~\{{counter}}~';
		$replace_array[] 	=	'$this->x_loop';
		
		/* ... */
		
		$string = preg_replace( $search_array, $replace_array, $string );
		
		/* ... */
		
		$string = str_replace( '{/Des::foreach}', '<?php $this->x_loop += 1; } ?>', $string );
		
		/* ... */
		
		return $string;	
	}
	
	/* ... */
	
	private function _storeForeachVarName( $varname, $oldname )
	{
		$this->_foreach_var[ $this->_foreach_var_num ] = $varname;
		
		$this->_foreach_var_num += 1;
		
		return '<?php foreach ($this->compiler->vars[\'foreach\'][\'' . $oldname . '\'] as $' . $varname . ') { ?>';
	}
	
	/* ... */
	
	private function _proccessIfStatement( $string, $type = null )
	{
		$search_array = array();
		$replace_array = array();
		
		// If statement :
		//					{if $i == 1} Hi {/if}
		//					if ($i == 1) { echo 'Hi'; }
		
		$search_array[] 	= 	'~\{if (.*)}(.*){/if}~'; // TODO : We have a problem here, \\2 may contain "else" or "elseif"
		$replace_array[] 	= 	'<?php if (\\1) { ?> \\2 <?php } ?>';
		
		$search_array[] 	= 	'~\{if (.*)}~';
		$replace_array[] 	= 	'<?php if (\\1) { ?>';
		
		$search_array[] 	= 	'~\{/if}~';
		$replace_array[] 	= 	'<?php } ?>';
		
		// Elseif statement
		$search_array[] 	= 	'~\{elseif (.*)}(.*){/if}~';
		$replace_array[] 	= 	'<?php elseif (\\1) { ?> \\2 <?php } ?>';
		
		$search_array[] 	= 	'~\{elseif (.*)}~';
		$replace_array[] 	= 	'<?php } elseif (\\1) { ?>';
		
		// Else statement
		$search_array[] 	= 	'~\{else}~';
		$replace_array[] 	= 	'<?php } else { ?>';
		
		$string = preg_replace( $search_array, $replace_array, $string );
		
		$string = preg_replace( '~\if (.*) \{~ie','$this->_ProccessIfStatementVariables(\'\\1\',\'' . $type . '\');', $string );
		
		return $string;	
	}
	
	/* ... */
	
	private function _proccessIfStatementVariables( $input, $type = null )
	{
		/* ... */
		
		$string = 'if ' . $input . ' { ';
		
		/* ... */
		
		if ( $type == 'while' )
		{
			foreach ( $this->_while_var as $var_name )
			{
				$search_array[] 	=	'~\{\$' . $var_name . '\[([^[<].*?)\]\}~';
				$replace_array[] 	=	'$this->compiler->vars[\'while\'][\'' . $var_name . '\'][$this->x_loop][\\1]';
			}
		}
		elseif ($type == 'foreach')
		{
			foreach ( $this->_foreach_var as $var_name )
			{
				$search_array[] 	= 	'~\{\$' . $var_name . '\}~';
				$replace_array[] 	= 	'$' . $var_name;

				$search_array[] 	=	'~\{\$' . $var_name . '\[([^[<].*?)\]}~';
				$replace_array[] 	=	'$' . $var_name . '[\\1]';
			}
		}
		
		/* ... */
		
		/** Array **/
		
		// 2D
		$search_array[] 	= 	'~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\[\'([^[<].*?)\'\]\}~';
		$replace_array[] 	= 	'$this->compiler->vars[\'\\1\'][\'\\2\'][\'\\3\']';
		
		// 2D - Without apostrophes
		$search_array[] 	= 	'~\{\$([^[<].*?)\[([^[<].*?)\]\[([^[<].*?)\]\}~';
		$replace_array[] 	= 	'$this->compiler->vars[\'\\1\'][\'\\2\'][\'\\3\']';
		
		// 1D
		$search_array[] 	= 	'~\{\$([^[<].*?)\[\'([^[<].*?)\'\]\}~';
		$replace_array[] 	= 	'$this->compiler->vars[\'\\1\'][\'\\2\']';
		
		// 1D - Without apostrophes
		$search_array[] 	= 	'~\{\$([^[<].*?)\[([^[<].*?)\]\}~';
		$replace_array[] 	= 	'$this->compiler->vars[\'\\1\'][\'\\2\']';
		
		/** End of Array **/
		
		/* ... */
		
		// Variable
		$search_array[] 	= 	'~\{\$([^[<].*?)\}~';
		$replace_array[] 	= 	'$this->compiler->vars[\'\\1\']';
		
		/* ... */
		
		$string = preg_replace( $search_array, $replace_array, $string );
		
		/* ... */
		
		return $string;
	}
	
	/* ... */
}

?>
