<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=style&amp;control=1&amp;main=1">الانماط</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">اسم النمط</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
{Des::while}{StlList}
<tr valign="top" align="center">
	<td class="row1">{$StlList['style_title']}</td>
	<td class="row1"><a href="./admin.php?page=style&amp;edit=1&amp;main=1&amp;id={$StlList['id']}">تحرير</a></td>
	<td class="row1"><a href="./admin.php?page=style&amp;del=1&amp;main=1&amp;id={$StlList['id']}">حذف</a></td>

</tr>
{/Des::while}
</table>
