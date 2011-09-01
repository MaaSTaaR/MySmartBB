<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">الاقسام الرئيسيه</a> &raquo; تحرير : {$Inf['title']}</div>

<br />
		
<form action="admin.php?page=sections_edit&amp;start=1&amp;id={$Inf['id']}" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تحرير قسم رئيسي : {$Inf['title']}</td>
</tr>
<tr valign="top">
		<td class="row1">اسم القسم</td>
		<td class="row1">

<input type="text" name="name" id="input_name" value="{$Inf['title']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">ترتيبه</td>
		<td class="row2">
<input type="text" name="sort" id="input_sort" value="{$Inf['sort']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>

</tr>
</table><br />
</form>

