<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['members']}</a> &raquo; {$lang['search']}</div>

<br />

<form action="admin.php?page=member_search&amp;start=1" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['find_member']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['keyword']}</td>
		<td class="row1">
<input type="text" name="keyword" id="input_keyword" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">{$lang['search_by']}</td>
		<td class="row2">
<select name="search_by" id="select_search_by">
	<option value="username" >{$lang['username']}</option>
	<option value="email" >{$lang['email']}</option>
	<option value="mid" >{$lang['member_id']}</option>
</select>
</td>

</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
