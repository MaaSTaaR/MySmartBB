<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=usertitle&amp;control=1&amp;main=1">مسميات الاعضاء</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">المسمى</td>
	<td class="main1">المشاركات</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
{Des::while}{UTList}
<tr valign="top" align="center">
	<td class="row1">{#UTList['usertitle']#}</td>
	<td class="row1">{#UTList['posts']#}</td>
	<td class="row1"><a href="admin.php?page=usertitle&amp;edit=1&amp;main=1&amp;id={#UTList['id']#}">تحرير</a></td>
	<td class="row1"><a href="admin.php?page=usertitle&amp;del=1&amp;main=1&amp;id={#UTList['id']#}">حذف</a></td>
</tr>
{/Des::while}
</table>
