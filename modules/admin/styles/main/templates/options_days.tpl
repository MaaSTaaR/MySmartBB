<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;close_days=1&amp;main=1">الايام المسموح للزوار دخول المنتدى بها</a></div>

<br />

<form action="admin.php?page=options&amp;close_days=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">الايام المسموح للزوار دخول المنتدى بها</td>
</tr>
<tr valign="top">
		<td class="row1">السبت</td>
		<td class="row1">
<select name="Sat" id="select_Sat">
	{if {$_CONF['info_row']['Sat']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">الاحد</td>
		<td class="row2">
<select name="Sun" id="select_Sun">
	{if {$_CONF['info_row']['Sun']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
	{/if}

</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">الاثنين</td>
		<td class="row1">
<select name="Mon" id="select_Mon">
	{if {$_CONF['info_row']['Mon']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
	{/if}
</select>

</td>
</tr>
<tr valign="top">
		<td class="row2">الثلاثاء</td>
		<td class="row2">
<select name="Tue" id="select_Tue">
	{if {$_CONF['info_row']['Tue']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
	{/if}
</select>
</td>

</tr>
<tr valign="top">
		<td class="row1">الاربعاء</td>
		<td class="row1">
<select name="Wed" id="select_Wed">
	{if {$_CONF['info_row']['Wed']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
	{/if}
</select>
</td>
</tr>

<tr valign="top">
		<td class="row2">الخميس</td>
		<td class="row2">
<select name="Thu" id="select_Thu">
	{if {$_CONF['info_row']['Thu']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">

		<td class="row1">الجمعه</td>
		<td class="row1">
<select name="Fri" id="select_Fri">
	{if {$_CONF['info_row']['Fri']}}
		<option value="1" selected="selected">مسموح</option>
		<option value="0">غير مسموح</option>
	{else}
		<option value="1">مسموح</option>
		<option value="0" selected="selected">غير مسموح</option>
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