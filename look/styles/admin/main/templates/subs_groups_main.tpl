<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sub&amp;control=1&amp;main=1">المنتديات الفرعيه</a> &raquo; صلاحيات المجموعات</div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">عنوان المنتدى</td>
	<td class="main1">تحكم في صلاحيات المجموعات</td>
</tr>
{Des::while}{SecList}
<tr valign="top" align="center">
	<td class="row1">{#SecList['title']#}</td>
	<td class="row1"><a href="./admin.php?page=forums&amp;groups=1&amp;show_group=1&amp;id={#SecList['id']#}">تحكم</a></td>
</tr>
{/Des::while}
</table>
