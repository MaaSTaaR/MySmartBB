<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;ajax=1&amp;main=1">إعدادات تقنية AJAX</a></div>

<br />

<form action="admin.php?page=options&amp;ajax=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">إعدادات تقنية AJAX</td>
</tr>
<tr valign="top">
		<td class="row1">تنشيطها في صفحة البحث</td>
		<td class="row1">
<select name="ajax_search" id="select_ajax_search">
	{if {$_CONF['info_row']['ajax_search']}}
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
		<td class="row2">تنشيطها في صفحة التسجيل</td>
		<td class="row2">
<select name="ajax_register" id="select_ajax_register">
	{if {$_CONF['info_row']['ajax_register']}}
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
		<td class="row1">تنشيطها في الرد السريع</td>
		<td class="row1">
<select name="ajax_freply" id="select_ajax_freply">
	{if {$_CONF['info_row']['ajax_freply']}}
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
	<input class="submit" type="submit" value="   موافق   " name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
