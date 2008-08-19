<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=template&amp;control=1&amp;main=1">القوالب</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">اسم النمط</td>

	<td class="main1">القوالب</td>
</tr>
{Des::while}{StyleList}
<tr valign="top" align="center">
	<td class="row1">{$StyleList['style_title']}</td>
	<td class="row1"><a href="./admin.php?page=template&amp;control=1&amp;show=1&amp;id={$StyleList['id']}">عرض</a></td>
</tr>
{/Des::while}
</table>
