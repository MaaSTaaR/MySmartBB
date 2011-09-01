<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;register=1&amp;main=1">إعدادات التسجيل</a></div>

<br />

<form action="admin.php?page=options&amp;register=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اعدادات التسجيل</td>
</tr>
<tr valign="top">
		<td class="row1">اغلاق التسجيل</td>
		<td class="row1">
<select name="reg_close" id="select_reg_close">
	{if {$_CONF['info_row']['reg_close']}}
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
		<td class="row2">المجموعه الافتراضيه عند التسجيل</td>
		<td class="row2">
<select name="def_group" id="select_def_group">
	{DB::getInfo}{$group_res}{$GroupList}
	{if {$_CONF['info_row']['def_group']} == {$GroupList['id']}}
	<option value="{$GroupList['id']}" selected="selected">{$GroupList['title']}</option>
	{else}
	<option value="{$GroupList['id']}">{$GroupList['title']}</option>
	{/if}
	{/DB::getInfo}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">المجموعه الافتراضيه عند التفعيل</td>
		<td class="row1">
<select name="adef_group" id="select_adef_group">
	{DB::getInfo}{$group_res}{$GroupList}
	{if {$_CONF['info_row']['adef_group']} == {$GroupList['id']}}
	<option value="{$GroupList['id']}" selected="selected">{$GroupList['title']}</option>
	{else}
	<option value="{$GroupList['id']}">{$GroupList['title']}</option>
	{/if}
	{/DB::getInfo}
</select>
</td>

</tr>
<tr valign="top">
		<td class="row2">تفعيل شروط التسجيل</td>
		<td class="row2">
<select name="reg_o" id="select_reg_o">
	{if {$_CONF['info_row']['reg_o']}}
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
		<td class="row1">أقل عدد من حروف إسم العضو</td>
		<td class="row1">
<input type="text" name="reg_less_num" id="input_reg_less_num" value="{$_CONF['info_row']['reg_less_num']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">أقصى عدد من حروف إسم العضو</td>
		<td class="row2">
<input type="text" name="reg_max_num" id="input_reg_max_num" value="{$_CONF['info_row']['reg_max_num']}" size="30" />&nbsp;
</td>

</tr>
<tr valign="top">
		<td class="row1">أقل عدد حروف كلمة المرور</td>
		<td class="row1">
<input type="text" name="reg_pass_min_num" id="input_reg_pass_min_num" value="{$_CONF['info_row']['reg_pass_min_num']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">أقصى عدد من الحروف كلمة المرور</td>
		<td class="row2">
<input type="text" name="reg_pass_max_num" id="input_reg_pass_max_num" value="{$_CONF['info_row']['reg_pass_max_num']}" size="30" />&nbsp;

</td>
</tr>
</table><br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">الايام المسموح للزوار التسجيل بها</td>
</tr>
<tr valign="top">
		<td class="row1">السبت</td>
		<td class="row1">
<select name="Sat" id="select_Sat">
	{if {$_CONF['info_row']['reg_Sat']}}
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
	{if {$_CONF['info_row']['reg_Sun']}}
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
	{if {$_CONF['info_row']['reg_Mon']}}
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
	{if {$_CONF['info_row']['reg_Tue']}}
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
	{if {$_CONF['info_row']['reg_Wed']}}
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
	{if {$_CONF['info_row']['reg_Thu']}}
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
	{if {$_CONF['info_row']['reg_Fri']}}
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
	<input class="submit" type="submit" value="   موافق   " name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
