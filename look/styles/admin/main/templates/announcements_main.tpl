<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=announcement&amp;control=1&amp;main=1">الاعلانات الاداريه</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		العنوان
		</td>
		<td class="main1 rows_space">
		الكاتب
		</td>
		<td class="main1 rows_space">
		تاريخ الاضافه
		</td>
		<td class="main1 rows_space">
		تحرير
		</td>
		<td class="main1 rows_space">
		حذف
		</td>
	</tr>
	{Des::while}{AnnList}
	<tr align="center">
		<td class="row1">
			<a href="index.php?page=announcement&amp;show=1&amp;id={$AnnList['id']}" target="_blank">{$AnnList['title']}</a>
		</td>
		<td class="row1">
			<a href="index.php?page=profile&amp;show=1&amp;username={$AnnList['writer']}" target="_blank">{$AnnList['writer']}</a>
		</td>
		<td class="row1">
			{$AnnList['date']}
		</td>
		<td class="row1">
			<a href="admin.php?page=announcement&amp;edit=1&amp;main=1&amp;id={$AnnList['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=announcement&amp;del=1&amp;main=1&amp;id={$AnnList['id']}">حذف</a>
		</td>
	</tr>
	{/Des::while}
</table>
