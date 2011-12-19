<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;close_days=1&amp;main=1">{$lang['visitors_allowed_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;close_days=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['visitors_allowed_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['sat']}</td>
		<td class="row1">
<select name="Sat" id="select_Sat">
	{if {$_CONF['info_row']['Sat']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['sun']}</td>
		<td class="row2">
<select name="Sun" id="select_Sun">
	{if {$_CONF['info_row']['Sun']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
	{/if}

</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['mon']}</td>
		<td class="row1">
<select name="Mon" id="select_Mon">
	{if {$_CONF['info_row']['Mon']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
	{/if}
</select>

</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['tue']}</td>
		<td class="row2">
<select name="Tue" id="select_Tue">
	{if {$_CONF['info_row']['Tue']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
	{/if}
</select>
</td>

</tr>
<tr valign="top">
		<td class="row1">{$lang['wed']}</td>
		<td class="row1">
<select name="Wed" id="select_Wed">
	{if {$_CONF['info_row']['Wed']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
	{/if}
</select>
</td>
</tr>

<tr valign="top">
		<td class="row2">{$lang['thu']}</td>
		<td class="row2">
<select name="Thu" id="select_Thu">
	{if {$_CONF['info_row']['Thu']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">

		<td class="row1">{$lang['fri']}</td>
		<td class="row1">
<select name="Fri" id="select_Fri">
	{if {$_CONF['info_row']['Fri']}}
		<option value="1" selected="selected">{$lang['common']['allowed']}</option>
		<option value="0">{$lang['common']['not_allowed']}</option>
	{else}
		<option value="1">{$lang['common']['allowed']}</option>
		<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
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
