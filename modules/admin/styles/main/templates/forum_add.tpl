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

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">{$lang['forums']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=forums_add&amp;start=1" method="post">
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['basic_information']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			{$lang['forum_name']}
			</td>
			<td class="row1">
				<input type="text" name="name" id="input_name" value="" size="30" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2">
			{$lang['sort']}
			</td>
			<td class="row2">
				<select name="order_type" id="order_type_id">
					<option value="auto" selected="selected">{$lang['automatic_sort']}</option>
					<option value="manual">{$lang['manual_sort']}</option>
				</select>
				<input type="text" name="sort" id="sort_id" value="" size="5" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2">
			{$lang['position']}
			</td>
			<td class="row2">
				<select name="parent" id="select_parent">
				{Des::foreach}{forums_list}{forum}
    			{if {$forum['parent']} == 0}
					<option value="{$forum['id']}" class="main_section">- {$forum['title']}</option>
				{else}
					<option value="{$forum['id']}">-- {$forum['title']}</option>
				{/if}
				{/Des::foreach}
				</select>
			</td>
		</tr>
	</table>

	<br />
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['description']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="describe" id="textarea_describe" rows="5" cols="40" wrap="virtual" dir="rtl"></textarea>
			</td>
		</tr>
	</table>
	
	<br />

	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="4">
			{$lang['permissions_shorcut']}
			</td>
		</tr>
		<tr align="center">
			<td class="main2">
			{$lang['group']}
			</td>
			<td class="main2">
			{$lang['can_view_sections']}
			</td>
			<td class="main2">
			{$lang['write_topic']}
			</td>
			<td class="main2">
			{$lang['write_reply']}
			</td>
		</tr>
		{DB::getInfo}{$group_res}{$groups}
		<tr align="center">
			<td class="row1">
				{$groups['title']}
			</td>
			<td class="row2">
				{$lang['can_view_sections']} : 
				<select name="groups[{$groups['id']}][view_section]" id="select_view_section">
					{if {$groups['view_section']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
			<td class="row1">
				{$lang['write_topic']} : 
				<select name="groups[{$groups['id']}][write_subject]" id="select_write_subject">
				{if {$groups['write_subject']}}
				<option value="1" selected="selected">{$lang['common']['yes']}</option>
				<option value="0">{$lang['common']['no']}</option>
				{else}
				<option value="1">{$lang['common']['yes']}</option>
				<option value="0" selected="selected">{$lang['common']['no']}</option>
				{/if}
				</select>
			</td>
			<td class="row2">
				{$lang['write_reply']} : 
				<select name="groups[{$groups['id']}][write_reply]" id="select_write_reply">
				{if {$groups['write_reply']}}
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
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
</form>
