<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;avatar=1&amp;main=1">إعدادات الصور الشخصيه</a></div>

<br />

<form action="admin.php?page=options&amp;avatar=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اعدادات الصور الشخصيه</td>
</tr>
<tr valign="top">
		<td class="row1">تفعيل الصور الشخصية</td>
		<td class="row1">
<select name="allow_avatar" id="select_allow_avatar">
	{if}{{$_CONF['info_row']['allow_avatar']}}{if}
		<option value="1" selected="selected">نعم</option>
		<option value="0">لا</option>
	{/comif}
	{else}
		<option value="1">نعم</option>
		<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">السماح بتحميل الصور من حاسوب المستخدم</td>
		<td class="row2">
<select name="upload_avatar" id="select_upload_avatar">
	{if}{{$_CONF['info_row']['upload_avatar']}}{if}
		<option value="1" selected="selected">نعم</option>
		<option value="0">لا</option>
	{/comif}
	{else}
		<option value="1">نعم</option>
		<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">اقصى عرض للصور الشخصية</td>
		<td class="row1">
<input type="text" name="max_avatar_width" id="input_max_avatar_width" value="{$_CONF['info_row']['max_avatar_width']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">اقصى ارتفاع للصور الشخصية</td>
		<td class="row2">

<input type="text" name="max_avatar_height" id="input_max_avatar_height" value="{$_CONF['info_row']['max_avatar_height']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
