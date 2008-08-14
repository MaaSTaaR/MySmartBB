<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">الاعضاء</a> &raquo; <a href="admin.php?page=member&amp;search=1&amp;main=1">بحث</a> &raquo; نتيجة البحث</div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">

<tr valign="top" align="center">
	<td class="main1">اسم المستخدم</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
<tr valign="top" align="center">
	<td class="row1"><a href="./index.php?page=profile&amp;show=1&amp;id={$Inf['id']}" target="_blank">{$Inf['username']}</a></td>
	<td class="row1"><a href="./admin.php?page=member&amp;edit=1&amp;main=1&amp;id={$Inf['id']}"">تحرير</a></td>
	<td class="row1"><a href="./admin.php?page=member&amp;del=1&amp;main=1&amp;id={$Inf['id']}"">حذف</a></td>
</tr>

</table>
