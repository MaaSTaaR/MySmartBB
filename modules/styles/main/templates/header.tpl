<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html dir="{$lang_info['direction']}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_info['lang']}" lang="{$lang_info['lang']}">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<meta name="generator" content="MySmartBB" />

	<link rel="stylesheet" href="{$style_path}" type="text/css" />
	
	<link rel="alternate" type="application/rss+xml" title="{$lang['common']['latest_topics_rss']}" href="index.php?page=rss&amp;subject=1" />
	
	{if {$SECTION_RSS}}
	<link rel="alternate" type="application/rss+xml" title="{$lang['common']['forum_rss']}" href="index.php?page=rss&amp;section=1&amp;id={$SECTION_ID}" />
	{/if}
	
	<title>{$title} - (Powered By MySmartBB)</title>
	
	{hook}inside_header{/hook}
	
</head>

<body>

	{if JAVASCRIPT_SMARTCODE}
	<script src="includes/js/SmartCode.js"></script>
	{/if}
	{if {$JQUERY}}
	<script src="includes/js/jquery.js"></script>
	{/if}

	<div id="main">
		
		<!-- -->
		
		<div id="header">
			<div class="right_side">
				<!-- <img border="0" src="{$image_path}/logo.jpg" alt="" /> -->
			</div>
			
			<div class="left_side">
				<div class="menu_box main2">
					<a href="{$init_path}">{$lang['common']['home']}</a>
				</div>
				
				{hook}menu_after_home{/hook}
				
				<div class="menu_box main2">
					{if {$_CONF['member_permission']}}
						<a href="{$init_path}usercp">{$lang['common']['conrol_panel']}</a>
					{else}
						<a href="{$init_path}register">{$lang['common']['register']}</a>
					{/if}
				</div>
				
				<div class="menu_box main2">
					<a href="{$init_path}static">{$lang['common']['statistics']}</a>
				</div>
				
				<div class="menu_box main2">
					<a href="{$init_path}member_list">{$lang['common']['memberlist']}</a>
				</div>
				
				<div class="menu_box main2">
					<a href="{$init_path}search">{$lang['common']['search']}</a>
				</div>
				
				{hook}menu_befor_logout{/hook}
				
				{if {$_CONF['member_permission']}}
					<div class="menu_box main2">
						<a href="{$init_path}logout">{$lang['common']['logout']}</a>
					</div>
				{/if}
			</div>
		</div>
		
		<!-- -->
		
		<div id="info_bar" align="center">
			{if !{$_CONF['member_permission']}}
			{hook}before_login_box{/hook}
			<form method="post" action="{$init_path}login">
		    {$lang['common']['username']} 
			<input type="text" name="username" />
          	{$lang['common']['password']}
          	<input type="password" name="password" />
          		
          		<input type="checkbox" name="temporary" value="on" id="fp1" />
          		<label for="fp1">{$lang['common']['temporary_login']}</label>
          			
          		<input type="submit" value="{$lang['common']['submit']}" />
          		،
          		<a href="{$init_path}forget">{$lang['common']['forgot_password']}</a>
          	</form>
          	{hook}after_login_box{/hook}
          	{else}
          		{$lang['common']['hello_member']} 
          		<a href="{$init_path}usercp">
          		{$_CONF['member_row']['username']}
          		</a> | {$lang['common']['your_last_visit']}  {$_COOKIE['MySmartBB_lastvisit']} 
          		{if {$_CONF['info_row']['pm_feature']}}
          		|
          		{if {$_CONF['member_row']['unread_pm']} == 0}
         			<a href="{$init_path}pm_list&amp;list=1&amp;folder=inbox">{$lang['common']['no_new_pm']}</a>
         		{/if}
         		{if {$_CONF['member_row']['unread_pm']} > 0}
         			<a class="unreadpm" href="{$init_path}pm_list&amp;list=1&amp;folder=inbox">{$lang['common']['you_have']} {$_CONF['member_row']['unread_pm']} {$lang['common']['new_pm']}</a>
         		{/if}
         		{/if}
         		{hook}inside_user_info_box{/hook}
          	{/if}
		</div>
		
		<!-- -->
		
		{if {$_CONF['temp']['ads_show']}}	
		<div class="box" align="center">
			<a href="{$init_path}ads/{$_CONF['rows']['AdsInfo']['id']}" target="_blank">
				<img src="{$_CONF['rows']['AdsInfo']['picture']}" 
					{if {$_CONF['AdsInfo']['width']} != 0 and {$_CONF['AdsInfo']['width']} != ''}
					width="{$_CONF['rows']['AdsInfo']['width']}"
					{/if}
					{if {$_CONF['AdsInfo']['height']} != 0 and {$_CONF['AdsInfo']['height']} != ''}
					height="{$_CONF['rows']['AdsInfo']['height']}"
					{/if} 
					alt="{$_CONF['rows']['AdsInfo']['sitename']}" border="0" />
			</a>
		</div>
		{/if}
		
		<div id="context" class="{$_CONF['align']}_side">
			
			<br />
