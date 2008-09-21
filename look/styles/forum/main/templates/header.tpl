<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ar" lang="ar">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<meta name="generator" content="MySmartBB" />

	<link rel="stylesheet" href="{$style_path}" type="text/css" />
	
	<link rel="alternate" type="application/rss+xml" title="خلاصة آخر المواضيع النشيطه" href="index.php?page=rss&amp;subject=1" />
	
	{if {$SECTION_RSS}}
	<link rel="alternate" type="application/rss+xml" title="خلاصة آخر المواضيع في هذا القسم" href="index.php?page=rss&amp;section=1&amp;id={$SECTION_ID}" />
	{/if}
	
	<title>{$title} - (Powered By MySmartBB)</title>
	
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
				<img border="0" src="{$image_path}/logo.jpg" alt="" /> 
			</div>
			
			<div class="left_side">
				<div class="menu_box main2">
					<a href="index.php">الرئيسيه</a>
				</div>
				
				<div class="menu_space"></div>
				
				<div class="menu_box main2">
					{if {$_CONF['member_permission']}}
						<a href="index.php?page=usercp&amp;index=1">لوحة التحكم</a>
					{else}
						<a href="index.php?page=register&amp;index=1">التسجيل</a>
					{/if}
				</div>
				
				<div class="menu_space"></div>
				
				<div class="menu_box main2">
					<a href="index.php?page=static&amp;index=1">احصائيات</a>
				</div>
				
				<div class="menu_space"></div>
				
				<div class="menu_box main2">
					<a href="index.php?page=member_list&amp;index=1">قائمة الاعضاء</a>
				</div>
				
				<div class="menu_space"></div>
				
				<div class="menu_box main2">
					<a href="index.php?page=search&amp;index=1">بحث</a>
				</div>
				
				{if {$_CONF['member_permission']}}
					<div class="menu_space"></div>
					
					<div class="menu_box main2">
						<a href="index.php?page=logout&amp;index=1">تسجيل خروج</a>
					</div>
				{/if}
			</div>
		</div>
		
		<!-- -->
		
		<div id="info_bar" align="center">
			{if !{$_CONF['member_permission']}}
			<form method="post" action="index.php?page=login&amp;login=1">
			اسم المستخدم 
			<input type="text" name="username" />
          		كلمة المرور 
          	<input type="password" name="password" />
          		
          		<input type="checkbox" name="temporary" value="on" id="fp1" />
          		<label for="fp1">دخول مؤقت </label>
          			
          		<input type="submit" value="دخول" />
          		،
          		<a href="index.php?page=forget&amp;index=1">استرجاع كلمة المرور</a>
          	</form>
          	{else}
          		مرحباً بك يا <a href="index.php?page=usercp&amp;index=1">{$_CONF['member_row']['username']}</a> | آخر زياره لك بتاريخ  {$_COOKIE['MySmartBB_lastvisit']} |
          		{if {$_CONF['rows']['member_row']['unread_pm']} == 0}
         			<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">لا يوجد لديك رسالة خاصة جديدة !</a>
         		{/if}
         		{if {$_CONF['rows']['member_row']['unread_pm']} > 0}
         			<a class="new_pm" href="index.php?page=pm&amp;list=1&amp;folder=inbox">يوجد لديك {$_CONF['rows']['member_row']['unread_pm']} رساله جديده</a>
         		{/if}
          	{/if}
		</div>
		
		<!-- -->
		
		{if {$_CONF['temp']['ads_show']}}	
		<div class="box" align="center">
			<a href="index.php?page=ads&amp;goto=1&amp;id={$_CONF['rows']['AdsInfo']['id']}" target="_blank">
				<img src="{$_CONF['rows']['AdsInfo']['picture']}" 
					{if {$_CONF['rows']['AdsInfo']['width']} != 0 and {$_CONF['rows']['AdsInfo']['width']} != ''}
					width="{$_CONF['rows']['AdsInfo']['width']}"
					{/if}
					{if {$_CONF['rows']['AdsInfo']['height']} != 0 and {$_CONF['rows']['AdsInfo']['height']} != ''}
					height="{$_CONF['rows']['AdsInfo']['height']}"
					{/if} 
					alt="{$_CONF['rows']['AdsInfo']['sitename']}" border="0" />
			</a>
		</div>
		{/if}
		
		<div id="context">
			
			<br />
