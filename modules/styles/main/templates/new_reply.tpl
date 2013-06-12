<script language="javascript">
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
	$("#attach_table").hide();
	$("#attach_id").click(ShowAttachTable);
	$(".more_attach_class").click(function() { AddMoreAttach(1) });
}

$(document).ready(Ready);
</script>

{template}address_bar_part1{/template}
<a href="{$init_path}forum/
{$section_info['id']}/
{$section_info['title']}">
{$section_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']}
<a href="{$init_path}topic/
{$id}/
{$subject_info['title']}">
{$subject_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']}
{$lang['add_new_reply']}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

<form name="topic" method="post" enctype="multipart/form-data" action="{$init_path}new_reply/start/{$id}">

{template}iconbox{/template}

{hook}after_iconbox{/hook}

<br />

{if {$section_info['usesmartcode_allow']} != 0}
{template}toolbox{/template}
{/if}

{hook}after_toolbox{/hook}

<br />

{template}smilebox{/template}

{hook}after_smilebox{/hook}

<br />
<table id="add_reply_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['reply_context']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			{$lang['reply_title']} {$lang['common']['colon']} <input name="title" type="text" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" id="text_id" cols="69"></textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']} " />
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="attach" id="attach_id" type="checkbox" /> <label for="attach_id">{$lang['add_attachments']}</a>
		</td>
	</tr>
</table>

<br />

{hook}after_add_reply_table{/hook}

<div id="attach_table">
{template}add_attach_table{/template}
</div>

{hook}after_add_attachements_table{/hook}

{if {$Admin}}
<br />
<table id="topic_management_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		{$lang['management_options']}
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="stick" id="stick_id" type="checkbox" {if {$subject_info['stick']}}checked="checked"{/if} /> <label for="stick_id">{$lang['stick_subject']}</label>
			<br />
			<input name="close" id="close_id" type="checkbox" {if {$subject_info['close']}}checked="checked"{/if} /> <label for="close_id">{$lang['close_subject']}</label>
		</td>
	</tr>
</table>
{/if}

{hook}after_topic_management_table{/hook}

</form>

<br />
