<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=smile&amp;control=1&amp;main=1">الابتسامات</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">الابتسامه</td>

	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
{Des::while}{SmlList}
<tr valign="top" align="center">
	<td class="row1"><img src="{$SmlList['smile_path']}" alt="" /></td>
	<td class="row1"><a href="./admin.php?page=smile&amp;edit=1&amp;main=1&amp;id={$SmlList['id']}">تحرير</a></td>
	<td class="row1"><a href="./admin.php?page=smile&amp;del=1&amp;main=1&amp;id={$SmlList['id']}">حذف</a></td>
</tr>
{/Des::while}
</table>
