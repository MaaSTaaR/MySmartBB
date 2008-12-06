<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;topics=1&amp;main=1">إعدادات المواضيع و الردود</a></div>

<br />

<form action="admin.php?page=options&amp;topics=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اعدادات المواضيع و الردود</td>
</tr>
<tr valign="top">
		<td class="row1">أقل عدد من الحروف في الموضوع او الرد</td>
		<td class="row1">
<input type="text" name="post_text_min" id="input_post_text_min" value="{$_CONF['info_row']['post_text_min']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">أقصى عدد من الحروف في الموضوع او الرد</td>
		<td class="row2">
<input type="text" name="post_text_max" id="input_post_text_max" value="{$_CONF['info_row']['post_text_max']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">اقل عدد من الحروف لعنوان الموضوع او الرد</td>
		<td class="row1">
<input type="text" name="post_title_min" id="input_post_title_min" value="{$_CONF['info_row']['post_title_min']}" size="30" />&nbsp;
</td>
</tr>

<tr valign="top">
		<td class="row2">اقصى عدد من الحروف لعنوان الموضوع او الرد</td>
		<td class="row2">
<input type="text" name="post_title_max" id="input_post_title_max" value="{$_CONF['info_row']['post_title_max']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">الوقت المحدد لإمكانية تعديل الردود أو المواضيع (بالدقائق)</td>
		<td class="row1">
<input type="text" name="time_out" id="input_time_out" value="{$_CONF['info_row']['time_out']}" size="30" />&nbsp;
</td>

</tr>
<tr valign="top">
		<td class="row2">عدد الثواني بين كل مشاركة وأخرى للعضو</td>
		<td class="row2">
<input type="text" name="floodctrl" id="input_floodctrl" value="{$_CONF['info_row']['floodctrl']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">تفعيل خاصية المواضيع المتشابهه</td>
		<td class="row1">
<select name="samesubject_show" id="select_samesubject_show">
	{if {$_CONF['info_row']['samesubject_show']}}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">عرض محتوى الموضوع في جميع الصفحات</td>
		<td class="row2">
<select name="show_subject_all" id="select_show_subject_all">
	{if {$_CONF['info_row']['show_subject_all']}}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">تفعيل خاصية تصغير الصور تلقائياً</td>
		<td class="row1">
<select name="resize_imagesAllow" id="select_resize_imagesAllow">
	{if {$_CONF['info_row']['resize_imagesAllow']}}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">عرض الصورة الإفتراضي</td>
		<td class="row2">
<input type="text" name="default_imagesW" id="input_default_imagesW" value="{$_CONF['info_row']['default_imagesW']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">طول الصورة الإفتراضي</td>
		<td class="row1">

<input type="text" name="default_imagesH" id="input_default_imagesH" value="{$_CONF['info_row']['default_imagesH']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>

