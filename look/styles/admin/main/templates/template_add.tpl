<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=template&amp;control=1&amp;main=1">القوالب</a> &raquo; اضافه</div>

<br />

<form action="admin.php?page=template&amp;add=1&amp;start=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اضافة قالب جديد</td>
</tr>
<tr valign="top">
		<td class="row1">اسم ملف القالب</td>
		<td class="row1">

<input type="text" name="filename" id="input_filename" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">القالب للنمط</td>
		<td class="row2">
<select name="style" id="select_style">
{Des::while}{StyleList}
	<option value="{$StyleList['id']}">{$StyleList['style_title']}</option>
{/Des::while}
</select>

</td>
</tr>
<tr valign="top" align="center">
	<td class="row1" colspan="2">محتوى القالب</td>
</tr>
<tr valign="top" align="center">
	<td class="row2" colspan="2">
<textarea name="context" id="textarea_context" rows="20" cols="70" wrap="virtual" dir="ltr"></textarea>&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">

	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
