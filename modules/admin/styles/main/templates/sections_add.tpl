<script src="includes/js/jquery.js"></script>

<script language="javascript">

function OrderChange()
{
	value = $("#order_type_id").val();
	
	if (value == 'manual')
	{
		$("#sort_id").show();
	}
	else
	{
		$("#sort_id").hide();
	}
}

function Ready()
{
	value = $("#order_type_id").val();
	
	if (value == 'manual')
	{
		$("#sort_id").show();
	}
	else
	{
		$("#sort_id").hide();
	}
	
	$("#order_type_id").change(OrderChange);
}

$(document).ready(Ready);

</script>

<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">{$lang['sections']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=sections_add&amp;start=1" method="post">

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['add_section']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['section_title']}</td>
		<td class="row1">
<input type="text" name="name" id="input_name" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['section_sort']}</td>

		<td class="row2">
			<select name="order_type" id="order_type_id">
				<option value="auto" selected="selected">{$lang['auto_sort']}</option>
				<option value="manual">{$lang['manual_sort']}</option>
			</select>
			<input type="text" name="sort" id="sort_id" value="" size="5" />
</td>
</tr>
</table><br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="4">{$lang['permissions_shorcut']}</td>
</tr>
<tr valign="top" align="center">
	<td class="main2">{$lang['group']}</td>
	<td class="main2">{$lang['can_view_sections']}</td>
</tr>
{DB::getInfo}{$groups}
<tr valign="top" align="center">
	<td class="row1">{$groups['title']}</td>
	<td class="row2">{$lang['can_view_sections']} : <select name="groups[{$groups['id']}][view_section]" id="select_view_section">
	{if {$groups['view_section']}}
	<option value="1" selected="selected">{$lang['common']['yes']}</option>
	<option value="0">{$lang['common']['no']}</option>
	{else}
	<option value="1">{$lang['common']['yes']}</option>
	<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select></td>
</tr>
{/DB::getInfo}
</table><br />

<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />

</form>
