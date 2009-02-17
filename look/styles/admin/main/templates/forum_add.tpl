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

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">المنتديات</a> &raquo; اضافه</div>

<br />

<form action="admin.php?page=forums&amp;add=1&amp;start=1" method="post">
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			المعلومات الاساسيه
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			اسم المنتدى
			</td>
			<td class="row1">
				<input type="text" name="name" id="input_name" value="" size="30" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2">
			ترتيبه
			</td>
			<td class="row2">
				<select name="order_type" id="order_type_id">
					<option value="auto" selected="selected">ترتيب آلي</option>
					<option value="manual">ترتيب يدوي</option>
				</select>
				<input type="text" name="sort" id="sort_id" value="" size="5" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2">
			تواجد المنتدى
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
			وصف المنتدى
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
			الصلاحيات المختصره
			</td>
		</tr>
		<tr align="center">
			<td class="main2">
			المجموعه
			</td>
			<td class="main2">
			امكانية عرض الاقسام
			</td>
			<td class="main2">
			كتابة موضوع
			</td>
			<td class="main2">
			كتابة رد
			</td>
		</tr>
		{Des::while}{groups}
		<tr align="center">
			<td class="row1">
				{$groups['title']}
			</td>
			<td class="row2">
				امكانية عرض الاقسام : 
				<select name="groups[{$groups['id']}][view_section]" id="select_view_section">
					{if {$groups['view_section']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
					{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
					{/if}
				</select>
			</td>
			<td class="row1">
				كتابة موضوع : 
				<select name="groups[{$groups['id']}][write_subject]" id="select_write_subject">
				{if {$groups['write_subject']}}
				<option value="1" selected="selected">نعم</option>
				<option value="0">لا</option>
				{else}
				<option value="1">نعم</option>
				<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
			<td class="row2">
				كتابة رد : 
				<select name="groups[{$groups['id']}][write_reply]" id="select_write_reply">
				{if {$groups['write_reply']}}
				<option value="1" selected="selected">نعم</option>
				<option value="0">لا</option>
				{else}
				<option value="1">نعم</option>
				<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		{/Des::while}
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
</form>
