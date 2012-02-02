<?php

define( 'PLUGIN_CLASS_NAME', 'MySmartMicroblog' );

require_once( 'plugins/interface.class.php' );

class PLUGIN_CLASS_NAME implements PluginInterface
{
	public function info()
	{
		return array(	'title'			=>	'Microblogging Plugin',
						'description'	=>	'Let your member to create a small blog in their profile',
						'author'		=>	'Mohammed Q. Hussain',
						'license'		=>	'GNU GPL'	);
	}
	
	public function hooks()
	{
	    return array( 	'show_profile_end' 	=> 'getLastPost'	);
	}
	
	public function activate()
	{
	    require_once( 'includes/systems/MySmartTemplateModifier.class.php' );
	    
	    // ... //
	    
	    // ~ Edit the template "profile ~ //
	    $profile = new MySmartTemplateModifier( 'profile' );
	    
	    $profile->openTable( 'profile_main_table' );
	    
	    $html = '<tr id="plugin_mysmartmicroblog_link_row" align="center">' . "\n";
	    $html .= '<td class="row1" width="20%">المدوّنة المُصغرة</td>' . "\n";
	    $html .= '<td class="row1" width="30%"><a href="">هنا</a></td>' . "\n";
	    $html .= '</tr>' . "\n";
	    
	    $profile->getTable()->addRowAtEnd( $html );
	    
	    $profile->closeTable();
	    
	    $profile->openHook( 'after_main_table' );
	    
	    $html = '<table id="plugin_mysmartmicroblog_last_post_table" align="center" class="t_style_b" border="1" width="60%">' . "\n";
	    $html .= '<tr align="center">' . "\n";
		$html .= '<td class="main1 rows_space" width="60%">' . "\n";
		$html .= 'التدوينة الأخيره' . "\n";
		$html .= '</td>' . "\n";
	    $html .= '</tr>' . "\n";
	    $html .= '<tr align="center">' . "\n";
		$html .= '<td class="row1" width="30%">' . "\n";
		$html .= '{if {$mysmartmicroblog_no_posts} == \'true\'}' . "\n";
		$html .= 'لا توجد تدوينات' . "\n";
		$html .= '{else}' . "\n";
		$html .= '{$mysmartmicroblog_post[\'context\']}' . "\n";
		$html .= '{/if}' . "\n";
		$html .= '</td>' . "\n";
	    $html .= '</tr>' . "\n";
        $html .= '</table><br id="plugin_mysmartmicroblog_last_post_br"></br>' . "\n";
	    
	    $profile->getHook()->addContent( $html );
	    
	    $profile->closeHook();
	    
	    $profile->save();
	    
	    // ... //
	    
	    // ~ Edit the template "usercp_menu ~ //
	    
	    $menu = new MySmartTemplateModifier( 'usercp_menu' );
	    
	    $menu->openHook( 'end_of_member_options' );
	    
        $html = '<tr id="plugin_mysmartmicroblog_options_head">' . "\n";
     	$html .= '<td class="main2 rows_space" align="center">' . "\n";
     	$html .= 'مدونتك المُصغّرة' . "\n";
     	$html .= '</td>' . "\n";
     	$html .= '</tr>' . "\n";
     	$html .= '<tr id="plugin_mysmartmicroblog_options_add">' . "\n";
     	$html .= '<td class="row1" align="center">' . "\n";
     	$html .= '<a href="">تدوينة جديدة</a>' . "\n";
     	$html .= '</td>' . "\n";
     	$html .= '</tr>' . "\n";
     	$html .= '<tr id="plugin_mysmartmicroblog_options_show">' . "\n";
     	$html .= '<td class="row1" align="center">' . "\n";
     	$html .= '<a href="">المدونة</a>' . "\n";
     	$html .= '</td>' . "\n";
     	$html .= '</tr>' . "\n";
	    
	    $menu->getHook()->addContent( $html );
	    
	    $menu->closeHook();
	    
	    $menu->save();
	    
	    // ... //
	}
	
	public function deactivate()
	{
	    require_once( 'includes/systems/MySmartTemplateModifier.class.php' );
	    
	    $profile = new MySmartTemplateModifier( 'profile' );
	    
	    $profile->removeByID( 'plugin_mysmartmicroblog_link_row', 'tr' );
	    $profile->removeByID( 'plugin_mysmartmicroblog_last_post_table', 'table' );
	    $profile->removeByID( 'plugin_mysmartmicroblog_last_post_br', 'br' );
	    
	    $profile->save();
	    
	    // ... //
	    
	    $menu = new MySmartTemplateModifier( 'usercp_menu' );
	    
	    $menu->removeByID( 'plugin_mysmartmicroblog_options_head', 'tr' );
	    $menu->removeByID( 'plugin_mysmartmicroblog_options_add', 'tr' );
	    $menu->removeByID( 'plugin_mysmartmicroblog_options_show', 'tr' );
	    
	    $menu->save();
	}
	
	public function install()
	{
	    global $MySmartBB;
	    
	    $MySmartBB->rec->table = $MySmartBB->getPrefix() . 'MySmartMicroblog_posts';
	    $MySmartBB->rec->fields = array(    'id'            =>  'INT( 9 ) NOT NULL AUTO_INCREMENT PRIMARY KEY',
	                                        'member_id'     =>  'INT( 9 ) NOT NULL',
	                                        'context'       =>  'TEXT NOT NULL',
	                                        'date'          =>  'VARCHAR( 255 ) NOT NULL'  );
        
        $create_table = $MySmartBB->rec->createTable();
        
        if ( $create_table )
        {
            $MySmartBB->func->msg( 'تم إنشاء الجدول MySmartMicroblog_posts' );
        }
	}
	
	public function uninstall()
	{
	    global $MySmartBB;
	    
	    $MySmartBB->rec->table = $MySmartBB->getPrefix() . 'MySmartMicroblog_posts';
        
        $drop_table = $MySmartBB->rec->dropTable();
        
        if ( $drop_table )
        {
            $MySmartBB->func->msg( 'تم إنشاء الجدول MySmartMicroblog_posts' );
        }
	}
	
	// ~ Hooks ~ //
	
	public function getLastPost()
	{
	    global $MySmartBB;
	    
	    $MySmartBB->rec->table = $MySmartBB->getPrefix() . 'MySmartMicroblog_posts';
	    $MySmartBB->rec->filter = "member_id='" . $MySmartBB->_CONF[ 'template' ][ 'MemberInfo' ][ 'id' ] . "'";
	    $MySmartBB->rec->order = "id DESC";
	    
	    $post_info = $MySmartBB->rec->getInfo();
	    
	    if ( !$post_info )
	    {
	        $MySmartBB->template->assign( 'mysmartmicroblog_no_posts', 'true' );
	    }
	    else
	    {
	        $MySmartBB->template->assign( 'mysmartmicroblog_no_posts', 'false' );
	        $MySmartBB->template->assign( 'mysmartmicroblog_post', $post_info );
	    }
	}
}

?>
