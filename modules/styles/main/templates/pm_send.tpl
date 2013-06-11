<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AddMoreResiver(x)
{
	x += 1;
	
	$(".more_tr").hide();	
	$("#resivers").append('<tr><td class="row1 rows_space">{$lang['receiver_number']}' + x + '</td><td class="row2 rows_space"><input name="to[]" class="to' + x + '" value="" type="text" /></td></tr>');
	$("#resivers").append('<tr class="more_tr"><td class="row1 rows_space" colspan="2" align="center"><button name="more_resiver" class="more_resiver_id" type="button">{$lang['add_more_receiver']}</button></td></tr>');
	
	$(".more_resiver_id").click(function() { AddMoreResiver(x) });
	
	$(".to" + x).focus();
}

function AddMoreAttach(x)
{
	x += 1;
	
	var up_max = {$_CONF['group_info']['upload_attach_num']};
	
	if (x <= up_max)
	{
		$(".more_attach_tr").hide();	
		$("#add_attachements_table").append('<tr align="center"><td class="row1 rows_space">{$lang['file']} #' + x + '</td><td class="row1 rows_space"><input name="files[]" type="file" id="attach' + x + '" size="40" /></td></tr>');
		$("#add_attachements_table").append('<tr align="center" class="more_attach_tr"><td class="row1 rows_space" colspan="2"><input type="button" name="more_attach" class="more_attach_class" value="{$lang['add_another_file']}" /></td></tr>');
		
		$(".more_attach_class").click(function() { AddMoreAttach(x) });
		
		if (x == up_max)
		{
			$(".more_attach_tr").hide();
		}
	}
}

function ShowAttachTable()
{
	if ($("#attach_id").is(":checked"))
	{
		$("#attach_table").fadeIn();
	}
	else
	{
		$("#attach_table").fadeOut();
	}
}

function Ready()
{
	$(".more_resiver_id").click(function() { AddMoreResiver(1) });
	$("#attach_table").hide();
	$("#attach_id").click(ShowAttachTable);
	$(".more_attach_class").click(function() { AddMoreAttach(1) });
}

$(document).ready(Ready);
</script>

{if {$embedded_pm_send_call} != true}
{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">

{template}address_bar_part1{/template}
<a href="{$init_path}pm_list/inbox">{$lang['pm']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['send_pm']}
{template}address_bar_part2{/template}
{/if}

{hook}after_address_bar{/hook}

<form name="topic" method="post" enctype="multipart/form-data" action="{$init_path}pm_send/start">

{template}iconbox{/template}

{hook}after_iconbox{/hook}

<br />

{template}toolbox{/template}

{hook}after_toolbox{/hook}

<br />

{if {$recv_info['pm_senders_msg']} or {$recv_info['away']}}
<table id="pm_away_message_table" border="1" width="50%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		{$lang['information']}
		</td>
	</tr>
	{if {$recv_info['away']}}
	<tr>
		<td class="row1 rows_space">
		{$recv_info['username']} {$lang['away']}
		</td>
		<td class="row2 rows_space">
		{$recv_info['away_msg']}
		</td>
	</tr>
	{/if}
	{if {$recv_info['pm_senders_msg']}}
	<tr>
		<td class="row1 rows_space">
		{$lang['message_from']} {$recv_info['username']}
		</td>
		<td class="row2 rows_space">
		{$recv_info['pm_senders_msg']}
		</td>
	</tr>
	{/if}
</table>
{/if}

{hook}after_pm_away_message_table{/hook}

<br />

<table id="resivers" border="1" width="50%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		{$lang['send_information']}
		</td>
	</tr>
	<tr>
		<td class="row1 rows_space">
			{$lang['receiver']}
		</td>
		<td class="row2 rows_space">
			<input name="to[]" value="{$to}" type="text" />
		</td>
	</tr>
	<tr class="more_tr">
		<td class="row1 rows_space" colspan="2" align="center">
			 <button name="more_resiver" class="more_resiver_id" type="button">{$lang['add_more_receiver']}</button>
		</td>
	</tr>
</table>

{hook}after_receivers_table{/hook}

<br />

<table id="pm_send_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['message_context']}
		</td>
	</tr>
	</tr>
		<td class="row1 rows_space">
			{$lang['message_title']}
		</td>
		<td class="row2 rows_space">
			<input name="title" value="{$send_title}" type="text" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69">{$send_text}</textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="attach" id="attach_id" type="checkbox" /> <label for="attach_id">{$lang['add_attachments']}</a>
		</td>
	</tr>
</table>

<br />

<div id="attach_table">
{template}add_attach_table{/template}
</div>

{hook}after_attach_table{/hook}

<br />

{template}smilebox{/template}

{hook}after_smilebox{/hook}

</form>

{if {$embedded_pm_send_call} != true}
</div>
{/if}

<br />
