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
	<table width="90%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			اضافة منتدى جديد
			</td>
		</tr>
		<tr>
			<td class="row1">
			اسم المنتدى
			</td>
			<td class="row1">
				<input type="text" name="name" id="input_name" value="" size="30" />
			</td>
		</tr>
		<tr>
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
			<td class="main1" colspan="2">
			صورة المنتدى
			</td>
		</tr>

		<tr>
			<td class="row1">
			السماح بظهور صوره للمنتدى
			</td>
			<td class="row1">
				<select name="use_section_picture" id="select_use_section_picture">
					<option value="1" >نعم</option>
					<option value="0" selected="selected">لا</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="row2">
			صورة المنتدى
			</td>
			<td class="row2">
				<input type="text" name="section_picture" id="input_section_picture" value="" size="30" />
			</td>
		</tr>

		<tr>
			<td class="row1">
			مكان صورة المنتدى
			</td>
			<td class="row1">
				<select name="sectionpicture_type" id="select_sectionpicture_type">
					<option value="1">مكان ايقونة المنتدى</option>
					<option value="2" selected="selected">فوق الوصف الخاص بالمنتدى</option>
				</select>
			</td>
		</tr>
		
		<tr align="center">
			<td class="main1" colspan="2">
			تواجد المنتدى
			</td>
		</tr>

		<tr>
			<td class="row2">
			القسم الاساسي
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

		<tr align="center">
			<td class="main1" colspan="2">
			نوع المنتدى
			</td>
		</tr>
		<tr>
			<td class="row1">
			المنتدى عباره عن وصله
			</td>
			<td class="row1">
				<select name="linksection" id="select_linksection">
					<option value="1" >نعم</option>
					<option value="0" selected="selected">لا</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="row2">
			الوصله
			</td>
			<td class="row2">
				<input type="text" name="linksite" id="input_linksite" value="" size="30" />
			</td>
		</tr>

		<tr align="center">
			<td class="main1" colspan="2">
			خيارات
			</td>
		</tr>
		
		<tr>
			<td class="row1">
			كلمه سريه للمنتدى
			</td>
			<td class="row1">
				<input type="text" name="section_password" id="input_section_password" value="" size="30" />
			</td>
		</tr>
		
		<tr>
			<td class="row2">
			عرض التواقيع في المنتدى
			</td>
			<td class="row2">
				<select name="show_sig" id="select_show_sig">
					<option value="1"  selected="selected">نعم</option>
					<option value="0" >لا</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="row1">
			منع تكرار التواقيع في المنتدى
			</td>
			<td class="row1">
				<select name="sig_iteration" id="select_sig_iteration">
					<option value="1" >نعم</option>
					<option value="0"  selected="selected">لا</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="row2">
			امكانية استخدام SmartCode
			</td>
			<td class="row2">
				<select name="usesmartcode_allow" id="select_usesmartcode_allow">
					<option value="1"  selected="selected">نعم</option>
					<option value="0" >لا</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="row1">
			حالة عرض الموضوع
			</td>
			<td class="row1">
				<select name="subject_order" id="select_subject_order">
					<option value="1"  selected="selected">صاحب الردود الجديده في الاعلى</option>
					<option value="2" >الموضوع الجديد في الاعلى</option>
					<option value="3" >الموضوع القديم في الاعلى</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="row2">
			إخفاء المواضيع عن غير اصحابها
			</td>
			<td class="row2">
				<select name="hide_subject" id="select_hide_subject">
					<option value="1" >نعم</option>
					<option value="0"  selected="selected">لا</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="row1">
			قسم سرّي اي لا يتم عرض مواضيع هذا القسم في الاماكن العامّه
			</td>
			<td class="row1">
				<select name="sec_section" id="select_sec_section">
					<option value="1" >نعم</option>
					<option value="0"  selected="selected">لا</option>
				</select>
			</td>
		</tr>
		
		<tr align="center">
			<td class="main1" colspan="2">
			الوصف
			</td>
		</tr>
		
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="describe" id="textarea_describe" rows="10" cols="40" wrap="virtual" dir="rtl"></textarea>
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
		نص يظهر اعلى المنتدى (يمكنك استخدام HTML)
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="head" rows="10" cols="40" wrap="virtual" dir="rtl"></textarea>
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
		نص يظهر اسفل المنتدى(يمكنك استخدام HTML)
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="foot" rows="10" cols="40" wrap="virtual" dir="rtl"></textarea>
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

	<div align="center">
		<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" />
	</div>

</form>
