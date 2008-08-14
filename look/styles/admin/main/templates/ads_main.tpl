<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=ads&amp;control=1&amp;main=1">الاعلانات التجاريه</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		اسم الموقع
		</td>
		<td class="main1 rows_space">
		تحرير
		</td>
		<td class="main1 rows_space">
		حذف
		</td>
	</tr>
	{Des::while}{AdsList}
	<tr align="center">
		<td class="row1">
			{$AdsList['sitename']}
		</td>
		<td class="row1">
			<a href="admin.php?page=ads&amp;edit=1&amp;main=1&amp;id={$AdsList['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=ads&amp;del=1&amp;main=1&amp;id={$AdsList['id']}">حذف</a>
		</td>
	</tr>
	{/Des::while}
</table>
