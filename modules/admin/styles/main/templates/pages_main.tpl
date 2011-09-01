<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=pages&amp;control=1&amp;main=1">الصفحات الخارجيه</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">اسم الصفحه</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
{DB::getInfo}{$PagesList}
<tr valign="top" align="center">
	<td class="row1"><a href="index.php?page=pages&amp;show=1&amp;id={$PagesList['id']}">{$PagesList['title']}</a></td>
	<td class="row1"><a href="admin.php?page=pages&amp;edit=1&amp;main=1&amp;id={$PagesList['id']}">تحرير</a></td>
	<td class="row1"><a href="admin.php?page=pages&amp;del=1&amp;main=1&amp;id={$PagesList['id']}">حذف</a></td>
</tr>
{/DB::getInfo}
</table>
