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

function Ready()
{
	$(".more_resiver_id").click(function() { AddMoreResiver(1) });
}

$(document).ready(Ready);
</script>

{template}address_bar_part1{/template}
<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> {$_CONF['info_row']['adress_bar_separate']} إرسال رساله خاصه
{template}address_bar_part2{/template}

<form name="topic" method="post" action="index.php?page=pm&amp;send=1&amp;start=1">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

{if {{$SHOW_MSG}}}
<div align="center"><strong>{$MSG}</strong></div>
{/if}

<br />

{if {{$SHOW_MSG1}}}
<div align="center">
<strong>{$to} غائب حاليا
<br />
سبب الغياب: {$MSG1}</strong>
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
</table>

<br />

{template}smilebox{/template}

</form>

<br />
