<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html dir="{$lang_info['direction']}" xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_info['lang']}" lang="{$lang_info['lang']}">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<meta name="generator" content="MySmartBB" />
	
	<link rel="stylesheet" href="modules/styles/print.css" type="text/css" />
	
	<title> {$Info['title']} - (Powered By MySmartBB)</title>
</head>

<body>
	<br />
	<br />
	
	{template}address_bar_part1{/template}
	<a href="{$init_path}forum/{$section_info['id']}/{$section_info['title']}{$password}">
	{$section_info['title']}
	</a> {$_CONF['info_row']['adress_bar_separate']} <a href="{$Info['reply_id']}">{$Info['title']}</a>
	{template}address_bar_part2{/template}
	
	{hook}after_adress_bar{/hook}
	
	<a href="{$init_path}topic/{$Info['subject_id']}/{$Info['title']}">{$lang['original_view']}</a>
	
	<div align="center">
		<table id="topic_view_table" border="0" cellpadding="0" class="print-table" width="95%">
			<tr align="center">
				<td width="30%" class="print-td" style="font-size:14pt">
			    {$lang['writer_information']} {$lang['common']['colon']} {$Info['display_username']}
				</td>
				<td width="60%" class="print-td">
			    {$lang['on_date']} {$lang['common']['colon']} {$Info['native_write_time']}
				</td>
			</tr> 
			<tr>
				<td width="95%" valign="top" colspan="2" class="print-td">
					<hr />
					{$Info['text']}
	           	</td>		
			</tr>
		</table>
	</div>
	
	{hook}after_topic_view_table{/hook}
	
<br />
