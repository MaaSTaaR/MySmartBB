<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=cp_options&amp;index=1">إعدادات لوحة التحكم</a> &raquo; <a href="admin.php?page=cp_options&amp;ajax=1&amp;main=1">إعدادات تقنية AJAX</a></div>

<br />

<form action="admin.php?page=cp_options&amp;ajax=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">التحكم في الاقسام الرئيسيه</td>
</tr>
<tr valign="top">
		<td class="row1">تنشيطها في صفحة التحكم لتغيير الاسم</td>
		<td class="row1">
<select name="admin_ajax_main_rename" id="select_admin_ajax_main_rename">
	{if {{$_CONF['info_row']['admin_ajax_main_rename']}}}
		<option value="1" selected="selected">نعم</option>
		<option value="0">لا</option>
	{else}
		<option value="1">نعم</option>
		<option value="0" selected="selected">لا</option>
	{/if}
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



