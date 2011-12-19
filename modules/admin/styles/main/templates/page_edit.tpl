<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=pages&amp;control=1&amp;main=1">{$lang['pages']}</a> &raquo; {$lang['common']['edit']} : {$Inf['title']}</div>

<br />

<form action="admin.php?page=pages&amp;edit=1&amp;start=1&amp;id={$Inf['id']}"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['common']['edit']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['page_title']}</td>
		<td class="row1">

<input type="text" name="name" id="input_name" value="{$Inf['title']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['page_code']}</td>
		<td class="row2">
<textarea name="text" id="textarea_text" rows="10" cols="40" wrap="virtual" dir="rtl">{$Inf['html_code']}</textarea>&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">

	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
