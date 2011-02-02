<?php

/** PHP5 **/

(!defined('IN_MYSMARTBB')) ? die() : '';

define('STOP_STYLE',true);
define('LOGIN',true);

define('COMMON_FILE_PATH',dirname(__FILE__) . '/common.module.php');

include('common.php');

define('CLASS_NAME','MySmartLoginMOD');

class MySmartLoginMOD
{
	public function run()
	{
		global $MySmartBB;
		
		/** Normal login **/
		if ( $MySmartBB->_GET[ 'login' ] )
		{
			$this->_startLogin();
		}
		/** **/
		
		/** Login after register **/
		elseif ( $MySmartBB->_GET[ 'register_login' ] )
		{
			$this->_startLogin( true );
		}
		/** **/
		else
		{
			$MySmartBB->func->error( 'المسار المتبع غير صحيح !' );
		}
		
		$MySmartBB->func->getFooter();
	}
	
	/**
	 * Check if the username , password are true, then gives the permisson to the user.
	 *
	 * @param :
	 *			register_login	-> 
	 *								true : to use this function to login after register
	 *								false : to use this function to normal login
	 */
	private function _startLogin( $register_login = false )
	{
		global $MySmartBB;
		
		if ( empty( $MySmartBB->_POST[ 'username' ])
			or empty( $MySmartBB->_POST[ 'password' ] ) )
		{
			$MySmartBB->func->error( 'يرجى تعبئة كافة المعلومات', true );
		}
		
		if ( !$register_login )
		{
			$username = $MySmartBB->func->cleanVariable( $MySmartBB->_POST[ 'username' ], 'trim' );
			$password = $MySmartBB->func->cleanVariable( md5( $MySmartBB->_POST[ 'password' ] ), 'trim' );
		}
		else
		{
			$username = $MySmartBB->func->cleanVariable( $MySmartBB->_GET[ 'username' ], 'trim' );
			$password = $MySmartBB->func->cleanVariable( $MySmartBB->_GET[ 'password' ], 'trim' );
		}
		
		$expire = ( isset( $MySmartBB->_POST[ 'temporary' ] ) and $MySmartBB->_POST[ 'temporary' ] == 'on' ) ? 0 : time() + 31536000;
		
		$isMember = $MySmartBB->member->loginMember( $username, $password, $expire );
		
		$MySmartBB->func->ShowHeader('تسجيل دخول');
		
		if ($isMember != false)
		{
			/* ... */
			
			$MySmartBB->template->assign('username',$username);
			
			$MySmartBB->template->display('login_msg');
			
			/* ... */
			
			if ( $isMember[ 'style' ] != $isMember[ 'style_id_cache' ] )
			{
				$MySmartBB->rec->filter = "id='" . (int) $isMember[ 'style' ] . "'";
				
				$style_cache = $MySmartBB->style->createStyleCache();
					
				$MySmartBB->rec->fields = array( 	'style_cache'	=>	$style_cache,
													'style_id_cache'	=>	$isMember['style']	);
				
				$MySmartBB->rec->filter = "id='" . (int) $isMember['id'] . "'";
													
				$update_cache = $MySmartBB->member->UpdateMember();
			}
			
			/* ... */
			
			$MySmartBB->rec->filter = "user_ip='" . $MySmartBB->_CONF['ip'] . "'";
			
			$MySmartBB->online->deleteOnline();
			
			/* ... */
			
			$url = parse_url( $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      		$url = $url[ 'query' ];
      		$url = explode( '&', $url );
      		$url = $url[ 0 ];

     		$Y_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      		$X_url = explode( '/', $MySmartBB->_SERVER[ 'HTTP_HOST' ] );
      		
      		/* ... */
      		
      		if ( !$register_login )
      		{
      			if ( $url != 'page=logout' 
      				or empty( $url ) 
      				or $url != 'page=login' )
           		{
       				//$MySmartBB->func->goto( $MySmartBB->_SERVER[ 'HTTP_REFERER' ] );
      			}
      			elseif ( $Y_url[ 2 ] != $X_url[ 0 ] 
      					or $url == 'page=logout' 
      					or $url == 'page=login' )
           		{
       				//$MySmartBB->func->goto( 'index.php' );
      			}
      		}
      		else
      		{
      			//$MySmartBB->func->goto( 'index.php' );
      		}
		}
		else
		{
			$MySmartBB->func->msg('كلمة المرور او اسم المستخدم غير صحيحين');
		}
	}
}

?>
