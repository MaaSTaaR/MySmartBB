<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=groups&amp;control=1&amp;main=1">المجموعات</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		المجموعه
		</td>
		<td class="main1 rows_space">
		تحرير
		</td>
		<td class="main1 rows_space">
		حذف
		</td>
	</tr>
	{DB::getInfo}{$groups}
	<tr align="center">
		<td class="row1">
			{$groups['h_title']}
		</td>
		<td class="row1">
			<a href="admin.php?page=groups_edit&amp;main=1&amp;id={$groups['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=groups_del&amp;main=1&amp;id={$groups['id']}">حذف</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
