<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">{$lang['sections']}</a> &raquo; {$lang['common']['edit']} : {$Inf['title']}</div>

<br />
		
<form action="admin.php?page=sections_edit&amp;start=1&amp;id={$Inf['id']}" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['edit_section']} : {$Inf['title']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['section_title']}</td>
		<td class="row1">

<input type="text" name="name" id="input_name" value="{$Inf['title']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['section_sort']}</td>
		<td class="row2">
<input type="text" name="sort" id="input_sort" value="{$Inf['sort']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>

</tr>
</table><br />
</form>

