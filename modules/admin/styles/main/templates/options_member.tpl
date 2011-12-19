<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;member=1&amp;main=1">{$lang['membership_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;member=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="40%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['membership_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['activate_away_feature']}</td>
		<td class="row1">
<select name="allow_apsent" id="select_allow_apsent">
	{if {$_CONF['info_row']['allow_apsent']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
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
