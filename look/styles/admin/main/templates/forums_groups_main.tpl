<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">المنتديات</a> &raquo; صلاحيات المجموعات</div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		عنوان المنتدى
		</td>
		<td class="main1">
		تحكم في صلاحيات المجموعات
		</td>
	</tr>
	{Des::while}{SecList}
	<tr align="center">
		<td class="row1">
			{$SecList['title']}
		</td>
		<td class="row1">
			<a href="./admin.php?page=forums&amp;groups=1&amp;show_group=1&amp;id={$SecList['id']}">تحكم</a>
		</td>
	</tr>
	{/Des::while}
</table>
