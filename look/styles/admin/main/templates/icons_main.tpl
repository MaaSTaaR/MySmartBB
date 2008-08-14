<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=icon&amp;control=1&amp;main=1">الايقونات</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">الايقونه</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
</tr>
{Des::while}{IcnList}
<tr valign="top" align="center">
	<td class="row1"><img src="{$IcnList['smile_path']}" alt="{$IcnList['smile_path']}" /></td>
	<td class="row1"><a href="./admin.php?page=icon&amp;edit=1&amp;main=1&amp;id={$IcnList['id']}">تحرير</a></td>
	<td class="row1"><a href="./admin.php?page=icon&amp;del=1&amp;main=1&amp;id={$IcnList['id']}">حذف</a></td>
</tr>
{/Des::while}
</table>
