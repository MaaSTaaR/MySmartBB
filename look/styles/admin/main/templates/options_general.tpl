<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;general=1&amp;main=1">إعدادات عامه</a></div>

<br />

<form action="admin.php?page=options&amp;general=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اعدادات عامه</td>
</tr>
<tr valign="top">
		<td class="row1">اسم المنتدى</td>
		<td class="row1">
<input type="text" name="title" id="input_title" value="{$_CONF['info_row']['title']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">بريد الارسال</td>
		<td class="row2">
<input type="text" name="send_email" id="input_send_email" value="{$_CONF['info_row']['send_email']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">بريد الاستقبال</td>
		<td class="row1">
<input type="text" name="admin_email" id="input_admin_email" value="{$_CONF['info_row']['admin_email']}" size="30" />&nbsp;
</td>
</tr>

<tr valign="top">
		<td class="row2">إظهار اسماء الزوار في قائمة المتواجدين</td>
		<td class="row2">
			<select name="guest_online" id="select_guest_online">
				{if}{{$_CONF['info_row']['show_onlineguest']}}{if}
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
