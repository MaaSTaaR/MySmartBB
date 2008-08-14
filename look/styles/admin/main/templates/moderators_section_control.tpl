<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">المشرفين</a> &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">تحكم</a> &raquo; {$Section['title']}</div>

<br />

<table width="80%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="40%">
		المشرف
		</td>
		<td class="main1 rows_space" width="20%">
		تحرير
		</td>
		<td class="main1 rows_space" width="20%">
		إلغاء الاشراف
		</td>
	</tr>
	{Des::while}{ModeratorsList}
	<tr align="center">
		<td class="row1" width="40%">
			<a href="index.php?page=profile&show=1&id={#ModeratorsList['member_id']#}" target="_blank">{#ModeratorsList['username']#}</a>
		</td>
		<td class="row1" width="20%">
			<a href="admin.php?page=moderators&amp;edit=1&amp;main=1&amp;id={#ModeratorsList['id']#}">تحرير</a>
		</td>
		<td class="row1" width="20%">
			<a href="admin.php?page=moderators&amp;del=1&amp;main=1&amp;id={#ModeratorsList['id']#}">إلغاء الاشراف</a>
		</td>
	</tr>
	{/Des::while}
</table>
