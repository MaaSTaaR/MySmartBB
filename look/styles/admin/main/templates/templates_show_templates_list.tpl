<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=template&amp;control=1&amp;main=1">القوالب</a> &raquo; قوالب {$StyleInfo['title']}</div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">اسم القالب</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
{Des::foreach}{TemplatesList}{template}
<tr valign="top" align="center">
	<td class="row1">{$template['filename']}</td>
	<td class="row1"><a href="./admin.php?page=template&amp;edit=1&amp;main=1&amp;filename={$template['filename']}&amp;id={$StyleInfo['id']}">تحرير</a></td>
	<td class="row1"><a href="./admin.php?page=template&amp;del=1&amp;main=1&amp;filename={$template['filename']}&amp;id={$StyleInfo['id']}">حذف</a></td>
</tr>
{/Des::foreach}
</table>
