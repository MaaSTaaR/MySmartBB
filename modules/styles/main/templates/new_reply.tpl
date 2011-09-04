<script src="includes/js/jquery.js"></script>

<script language="javascript">
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
	$("#attach_table").hide();
	$("#attach_id").click(ShowAttachTable);
	$(".more_attach_class").click(function() { AddMoreAttach(1) });
}

$(document).ready(Ready);
</script>

{template}address_bar_part1{/template}
<a href="index.php?page=forum&amp;show=1&amp;id={$section_info['id']}{$password}">
{$section_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']}
<a href="index.php?page=topic&amp;show=1&amp;id={$id}{$password}">
{$subject_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']}
 اضافة رد جديد
{template}address_bar_part2{/template}

<br />

<form name="topic" method="post" enctype="multipart/form-data" action="index.php?page=new_reply&amp;start=1&amp;id={$id}{$password}">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الرد
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			عنوان الرد : <input name="title" type="text" />
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
			<input name="attach" id="attach_id" type="checkbox" /> <label for="attach_id">اضافة مرفقات</a>
		</td>
	</tr>
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
			<input name="stick" id="stick_id" type="checkbox" {if {$subject_info['stick']}}checked="checked"{/if} /> <label for="stick_id">تثبيت الموضوع</label>
			<br />
			<input name="close" id="close_id" type="checkbox" {if {$subject_info['close']}}checked="checked"{/if} /> <label for="close_id">إغلاق الموضوع</label>
		</td>
	</tr>
</table>
{/if}

<div id="attach_table">
{template}add_attach_table{/template}
</div>

<br />

{template}smilebox{/template}

</form>

<br />
