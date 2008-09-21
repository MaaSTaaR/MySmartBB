<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">الاقسام الرئيسيه</a> &raquo; التحكم في صلاحيات المجموعات للقسم : {$Inf['title']}</div>

<br />

<form action="admin.php?page=sections&amp;groups=1&amp;control_group=1&amp;start=1&amp;id={$Inf['id']}"  name="myform" method="post">

{Des::while}{SecGroupList}
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="row1" colspan="2"><strong>{$SecGroupList['group_name']}</strong></td>
</tr>
<tr valign="top">
		<td class="row1">إمكانية عرض القسم</td>
		<td class="row1">
<select name="groups[{#SecGroupList['group_id']#}][view_section]" id="select_view_section">
	{if {$SecGroupList['view_section']}}
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
{/Des::while}
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
