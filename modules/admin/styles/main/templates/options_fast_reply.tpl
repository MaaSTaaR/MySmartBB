<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;fast_reply=1&amp;main=1">إعدادات الرد السريع</a></div>

<br />

<form action="admin.php?page=options&amp;fast_reply=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="40%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">إعدادات الرد السريع</td>
</tr>
<tr valign="top">
		<td class="row1">امكانية استخدام الرد السريع</td>
		<td class="row1">
<select name="fastreply_allow" id="select_fastreply_allow">
	{if {$_CONF['info_row']['fastreply_allow']}}
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
		<td class="row2">تفعيل صندوق الأدوات</td>
		<td class="row2">
<select name="toolbox_show" id="select_toolbox_show">
	{if {$_CONF['info_row']['toolbox_show']}}
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
		<td class="row1">تفعيل الابتسامات</td>
		<td class="row1">
<select name="smiles_show" id="select_smiles_show">
	{if {$_CONF['info_row']['smiles_show']}}
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
		<td class="row2">تفعيل الأيقونات</td>
		<td class="row2">
<select name="icons_show" id="select_icons_show">
	{if {$_CONF['info_row']['icons_show']}}
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
		<td class="row1">اقتباس عنوان الموضوع تلقائياً في عنوان الرد</td>
		<td class="row1">
<select name="title_quote" id="select_title_quote">
	{if {$_CONF['info_row']['title_quote']}}
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
		<td class="row2">تفعيل (إغلاق/تثبيت الموضوع) في الرد السريع</td>
		<td class="row2">
<select name="activate_closestick" id="select_activate_closestick">
	{if {$_CONF['info_row']['activate_closestick']}}
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
