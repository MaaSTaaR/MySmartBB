<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">{$lang['sections']}</a> &raquo; {$lang['control_permissions']} : {$Inf['title']}</div>

<br />

<form action="admin.php?page=sections_groups&amp;start=1&amp;id={$Inf['id']}" method="post">

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['group']}</td>
	<td class="main1">{$lang['can_view_section']}</td>
</tr>
{DB::getInfo}{$SecGroupList}
<tr valign="top" align="center">
	<td class="row1">{$SecGroupList['group_name']}</td>
	<td class="row2">{$lang['can_view_section']} : 
<select name="groups[{$SecGroupList['group_id']}][view_section]" id="select_view_section">
	{if {$SecGroupList['view_section']}}
	<option value="1" selected="selected">{$lang['common']['yes']}</option>
	<option value="0">{$lang['common']['no']}</option>
	{else}
	<option value="1">{$lang['common']['yes']}</option>
	<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>
</tr>
{/DB::getInfo}
</table><br />

<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
