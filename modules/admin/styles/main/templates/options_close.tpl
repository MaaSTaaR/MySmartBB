<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;ajax=1&amp;close=1">{$lang['close_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;close=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['close_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['close_options']}</td>
		<td class="row1">
<select name="board_close" id="select_board_close">
	{if {$_CONF['info_row']['board_close']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['close_message']}</td>
</tr>
<tr valign="top" align="center">
	<td class="row1" colspan="2">
<textarea name="board_msg" id="textarea_board_msg" rows="10" cols="40" wrap="virtual">{$_CONF['info_row']['board_msg']}</textarea>&nbsp;
</td>

</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
