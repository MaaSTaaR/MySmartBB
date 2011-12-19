<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;fast_reply=1&amp;main=1">{$lang['fast_reply_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;fast_reply=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="40%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['fast_reply_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['can_use_fast_reply']}</td>
		<td class="row1">
<select name="fastreply_allow" id="select_fastreply_allow">
	{if {$_CONF['info_row']['fastreply_allow']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['activate_toolbox']}</td>
		<td class="row2">
<select name="toolbox_show" id="select_toolbox_show">
	{if {$_CONF['info_row']['toolbox_show']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}

</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['activate_smiles']}</td>
		<td class="row1">
<select name="smiles_show" id="select_smiles_show">
	{if {$_CONF['info_row']['smiles_show']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>

</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['activate_icons']}</td>
		<td class="row2">
<select name="icons_show" id="select_icons_show">
	{if {$_CONF['info_row']['icons_show']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>

</tr>
<tr valign="top">
		<td class="row1">{$lang['auto_title_quote']}</td>
		<td class="row1">
<select name="title_quote" id="select_title_quote">
	{if {$_CONF['info_row']['title_quote']}}
		<option value="1" selected="selected">{$lang['common']['yes']}</option>
		<option value="0">{$lang['common']['no']}</option>
	{else}
		<option value="1">{$lang['common']['yes']}</option>
		<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>
</tr>

<tr valign="top">
		<td class="row2">{$lang['activate_topic_control']}</td>
		<td class="row2">
<select name="activate_closestick" id="select_activate_closestick">
	{if {$_CONF['info_row']['activate_closestick']}}
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
