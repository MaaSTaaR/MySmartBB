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

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">الاقسام الرئيسيه</a> &raquo; اضافة قسم رئيسي</div>

<br />

<form action="admin.php?page=sections_add&amp;start=1" method="post">

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اضافة قسم رئيسي جديد</td>
</tr>
<tr valign="top">
		<td class="row1">اسم القسم</td>
		<td class="row1">
<input type="text" name="name" id="input_name" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">ترتيبه</td>

		<td class="row2">
			<select name="order_type" id="order_type_id">
				<option value="auto" selected="selected">ترتيب آلي</option>
				<option value="manual">ترتيب يدوي</option>
			</select>
			<input type="text" name="sort" id="sort_id" value="" size="5" />
</td>
</tr>
</table><br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="4">الصلاحيات المختصره</td>
</tr>
<tr valign="top" align="center">
	<td class="main2">المجموعه</td>
	<td class="main2">امكانية عرض الاقسام</td>
</tr>
{DB::getInfo}{$groups}
<tr valign="top" align="center">
	<td class="row1">{$groups['title']}</td>
	<td class="row2">امكانية عرض الاقسام : <select name="groups[{$groups['id']}][view_section]" id="select_view_section">
	{if {$groups['view_section']}}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/if}
</select></td>
</tr>
{/DB::getInfo}
</table><br />

<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />

</form>