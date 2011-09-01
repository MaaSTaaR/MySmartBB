<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AddMoreResiver(x)
{
	x += 1;
	
	$(".more_tr").hide();	
	$("#resivers").append('<tr><td class="row1 rows_space">المُستقبل # ' + x + '</td><td class="row2 rows_space"><input name="to[]" class="to' + x + '" value="" type="text" /></td></tr>');
	$("#resivers").append('<tr class="more_tr"><td class="row1 rows_space" colspan="2" align="center"><button name="more_resiver" class="more_resiver_id" type="button">اضف المزيد من المُستقبلين</button></td></tr>');
	
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
	$(".more_resiver_id").click(function() { AddMoreResiver(1) });
	$("#attach_table").hide();
	$("#attach_id").click(ShowAttachTable);
	$(".more_attach_class").click(function() { AddMoreAttach(1) });
}

$(document).ready(Ready);
</script>

{if {$embedded_pm_send_call} != true}
{template}usercp_menu{/template}

<div class="usercp_context">

{template}address_bar_part1{/template}
<a href="index.php?page=pm_list&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> {$_CONF['info_row']['adress_bar_separate']} إرسال رساله خاصه
{template}address_bar_part2{/template}
{/if}

<form name="topic" method="post" enctype="multipart/form-data" action="index.php?page=pm_send&amp;send=1&amp;start=1">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

{if {$is_sender_msg}}
<div align="center"><strong>{$senders_msg}</strong></div>
{/if}

<br />

{if {$is_away_msg}}
<div align="center">
<strong>{$to} غائب حاليا
<br />
سبب الغياب: {$away_msg}</strong>
</div>
<br />
{/if}

<table id="resivers" border="1" width="50%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		بيانات الارسال
		</td>
	</tr>
	<tr>
		<td class="row1 rows_space">
			 المُستقبل
		</td>
		<td class="row2 rows_space">
			<input name="to[]" value="{$to}" type="text" />
		</td>
	</tr>
	<tr class="more_tr">
		<td class="row1 rows_space" colspan="2" align="center">
			 <button name="more_resiver" class="more_resiver_id" type="button">اضف المزيد من المُستقبلين</button>
		</td>
	</tr>
</table>

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الرساله
		</td>
	</tr>
	</tr>
		<td class="row1 rows_space">
			عنوان الرسالة 
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

<div id="attach_table">
{template}add_attach_table{/template}
</div>

<br />

{template}smilebox{/template}

</form>

{if {$embedded_pm_send_call} != true}
</div>
{/if}

<br />
