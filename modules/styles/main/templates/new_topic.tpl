<script src="includes/js/jquery.js"></script>

<script language="javascript">                
function ShowPollTable()
{
	if ($("#poll_id").is(":checked"))
	{
		$("#poll_table").fadeIn();
	}
	else
	{
		$("#poll_table").fadeOut();
	}
}

function AddMoreAnswers(x)
{
	x += 1;
	
	$(".more_tr").hide();	
	$("#poll_question_answers").append('<tr align="center"><td class="row1 rows_space">{$lang['poll_answer']} #' + x + '</td><td class="row1 rows_space"><input name="answers[]" type="text" id="answer' + x + '" /></td></tr>');
	$("#poll_question_answers").append('<tr align="center" class="more_tr"><td class="row1 rows_space" colspan="2"><input type="button" name="more_answers" class="more_answers_class" value="{$lang['add_another_answer']}" /></td></tr>');
	
	$("#answer" + x).focus();
	
	$(".more_answers_class").click(function() { AddMoreAnswers(x) });
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

function AddMoreTags(x)
{
	x += 1;
	
	$(".more_tag_tr").hide();	
	$("#add_tags_table").append('<tr align="center"><td class="row1 rows_space">{$lang['tag']} #' + x + '</td><td class="row1 rows_space"><input name="tags[]" type="text" id="tag' + x + '" size="40" /></td></tr>');
	$("#add_tags_table").append('<tr align="center" class="more_tag_tr"><td class="row1 rows_space" colspan="2"><input type="button" name="more_tags" class="more_tags_class" value="{$lang['add_another_tag']}" /></td></tr>');
		
	$("#tag" + x).focus();
	
	$(".more_tags_class").click(function() { AddMoreTags(x) });
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
	$("#poll_table").hide();
	$("#poll_id").click(ShowPollTable);
	$(".more_answers_class").click(function() { AddMoreAnswers(4) });
	
	$(".more_tags_class").click(function() { AddMoreTags(1) });
	
	$("#attach_table").hide();
	$("#attach_id").click(ShowAttachTable);
	$(".more_attach_class").click(function() { AddMoreAttach(1) });
}

$(document).ready(Ready);
</script>

{template}address_bar_part1{/template}
<a href="index.php?page=forum&amp;show=1&amp;id={$id}{$password}">
	{$section_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['add_new_topic']}
{template}address_bar_part2{/template}

{hook}after_address_bar{/hook}

<br />

<form name="topic" method="post" enctype="multipart/form-data" action="index.php?page=new_topic&amp;start=1&amp;id={$id}{$password}">

{template}iconbox{/template}

{hook}after_iconbox{/hook}

<br />

{if {$section_info['usesmartcode_allow']} != 0}
{template}toolbox{/template}
<br />
{/if}

{hook}after_toolbox{/hook}

{template}smilebox{/template}

{hook}after_smilebox{/hook}

<br />

<div id="poll_table">
{template}add_poll_table{/template}
</div>

<table id="new_topic_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['topic_context']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			{$lang['topic_title']} {$lang['common']['colon']} <input name="title" type="text" />
		</td>
		<td class="row1 rows_space">
			{$lang['topic_description']} <small>{$lang['optional']}</small> : <input name="describe" type="text" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" id="text_id" cols="69"></textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="poll" id="poll_id" type="checkbox" /> <label for="poll_id">{$lang['add_poll']}</a>
		</td>
	</tr>
	{if {$upload_attach}}
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="attach" id="attach_id" type="checkbox" /> <label for="attach_id">{$lang['add_attachments']}</a>
		</td>
	</tr>
	{/if}
</table>

<br />

{hook}after_new_topic_table{/hook}

<div id="attach_table">
{template}add_attach_table{/template}
</div>

<br />

{if {$Admin}}
<table id="topic_management_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		{$lang['management_options']}
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="stick" id="stick_id" type="checkbox" /> <label for="stick_id">{$lang['stick_subject']}</label>
			<br />
			<input name="close" id="close_id" type="checkbox" /> <label for="close_id">{$lang['close_subject']}</label>
		</td>
	</tr>
</table>
<br />
{/if}

{hook}after_management_table{/hook}

<div id="tags_table">
{template}add_tags_table{/template}
</div>

<br />

</form>

<br />
