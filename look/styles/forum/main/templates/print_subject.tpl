<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html dir="rtl" xmlns="http://www.w3.org/1999/xhtml" xml:lang="ar" lang="ar">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<meta name="generator" content="MySmartBB" />
	
	<link rel="stylesheet" href="look/styles/print.css" type="text/css" />
	
	<title> {$Info['title']} - (Powered By MySmartBB)</title>
</head>

<body>
	<br />
	<br />
	
	{template}address_bar_part1{/template}
	<a href="index.php?page=forum&amp;show=1&amp;id={$section_info['id']}{$password}">
	{$section_info['title']}
	</a> {$_CONF['info_row']['adress_bar_separate']} <a href="{$Info['reply_id']}">{$Info['title']}</a>
	{template}address_bar_part2{/template}
	
	<a href="index.php?page=topic&show=1&id={$Info['subject_id']}">إضغط هنا لمشاهدة الموضوع بهيئته الأصلية</a>
	
	<div align="center">
		<table border="0" cellpadding="0" class="print-table" width="95%">
			<tr align="center">
				<td width="30%" class="print-td" style="font-size:14pt">
			كاتب الموضوع: {$Info['display_username']}
				</td>
				<td width="60%" class="print-td">
			بتاريخ: {$Info['native_write_time']}
				</td>
			</tr> 
			<tr>
				<td width="95%" valign="top" colspan="2" class="print-td" align="right">
					<hr />
					{$Info['text']}
	           	</td>		
			</tr>
		</table>
	</div>
	
<br />
