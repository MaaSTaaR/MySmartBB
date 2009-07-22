<script src="includes/js/jquery.js"></script>
{if {$_CONF['info_row']['wysiwyg_topic']}}
<script src="includes/js/jquery.wysiwyg.js"></script>
{/if}

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
	
	$("#poll_answers_count_id").val(x);
	$(".more_tr").hide();	
	$("#poll_question_answers").append('<tr align="center"><td class="row1 rows_space">الجواب #' + x + '</td><td class="row1 rows_space"><input name="answer[]" type="text" id="answer' + x + '" /></td></tr>');
	$("#poll_question_answers").append('<tr align="center" class="more_tr"><td class="row1 rows_space" colspan="2"><input type="button" name="more_answers" class="more_answers_class" value="اضف جواب آخر" /></td></tr>');
	
	$("#answer" + x).focus();
	
	$(".more_answers_class").click(function() { AddMoreAnswers(x) });
}

function AddMoreTags(x)
{
	x += 1;
	
	$(".more_tag_tr").hide();	
	$("#add_tags_table").append('<tr align="center"><td class="row1 rows_space">العلامه #' + x + '</td><td class="row1 rows_space"><input name="tags[]" type="text" id="tag' + x + '" size="40" /></td></tr>');
	$("#add_tags_table").append('<tr align="center" class="more_tag_tr"><td class="row1 rows_space" colspan="2"><input type="button" name="more_tags" class="more_tags_class" value="اضف علامه اخرى" /></td></tr>');
		
	$("#tag" + x).focus();
	
	$(".more_tags_class").click(function() { AddMoreTags(x) });
}

function AddMoreAttach(x)
{
	x += 1;
	
	var up_max = {$_CONF['group_info']['upload_attach_num']};
	
	if (x <= up_max)
	{
		$(".more_attach_tr").hide();	
		$("#add_attach_table").append('<tr align="center"><td class="row1 rows_space">ملف #' + x + '</td><td class="row1 rows_space"><input name="files[]" type="file" id="attach' + x + '" size="40" /></td></tr>');
		$("#add_attach_table").append('<tr align="center" class="more_attach_tr"><td class="row1 rows_space" colspan="2"><input type="button" name="more_attach" class="more_attach_class" value="اضف ملف آخر" /></td></tr>');
		
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
</a> {$_CONF['info_row']['adress_bar_separate']} اضافة موضوع جديد
{template}address_bar_part2{/template}

<br />

<form name="topic" method="post" enctype="multipart/form-data" action="index.php?page=new_topic&amp;start=1&amp;id={$id}{$password}">

<input name="poll_answers_count" id="poll_answers_count_id" type="hidden" value="4">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الموضوع
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			عنوان الموضوع : <input name="title" type="text" />
		</td>
		<td class="row1 rows_space">
			وصف الموضوع <small>(اختياري)</small> : <input name="describe" type="text" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" id="text_id" cols="69"></textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="موافق" />
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="poll" id="poll_id" type="checkbox" /> <label for="poll_id">اضافة تصويت</a>
		</td>
	</tr>
	{if {$upload_attach}}
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="attach" id="attach_id" type="checkbox" /> <label for="attach_id">اضافة مرفقات</a>
		</td>
	</tr>
	{/if}
</table>

<br />

{if {$Admin}}
<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		خيارات إدارة الموضوع
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="stick" id="stick_id" type="checkbox" /> <label for="stick_id">تثبيت الموضوع</label>
			<br />
			<input name="close" id="close_id" type="checkbox" /> <label for="close_id">إغلاق الموضوع</label>
		</td>
	</tr>
</table>
<br />
{/if}

<div id="tags_table">
{template}add_tags_table{/template}
</div>

<div id="poll_table">
{template}add_poll_table{/template}
</div>

<div id="attach_table">
{template}add_attach_table{/template}
</div>

<br />

{template}smilebox{/template}

</form>

<br />

{if {$_CONF['info_row']['wysiwyg_topic']}}
<script language="javascript">
$("#text_id").wysiwyg();
</script>
{/if}
