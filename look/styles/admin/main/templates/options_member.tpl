<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;member=1&amp;main=1">إعدادات العضويه</a></div>

<br />

<form action="admin.php?page=options&amp;member=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="40%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اعدادات العضويه</td>
</tr>
<tr valign="top">
		<td class="row1">إرسال رسالة تأكيد إذا قام العضو بتغيير بريده</td>
		<td class="row1">
<select name="confirm_on_change_mail" id="select_confirm_on_change_mail">
	{if}{{$_CONF['info_row']['confirm_on_change_mail']}}{if}
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
		<td class="row2">إرسال رسالة تأكيد إذا قام العضو بتغيير كلمة مروره</td>
		<td class="row2">
<select name="confirm_on_change_pass" id="select_confirm_on_change_pass">
	{if}{{$_CONF['info_row']['confirm_on_change_pass']}}{if}
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
		<td class="row1">تفعيل خاصية الغياب</td>
		<td class="row1">
<select name="allow_apsent" id="select_allow_apsent">
	{if}{{$_CONF['info_row']['allow_apsent']}}{if}
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
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
