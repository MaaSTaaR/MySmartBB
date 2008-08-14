<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=avatar&amp;control=1&amp;main=1">الصور الشخصيه</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		الصوره
		</td>
		<td class="main1 rows_space">
		تحرير
		</td>
		<td class="main1 rows_space">
		حذف
		</td>
	</tr>
	{Des::while}{AvrList}
	<tr align="center">
		<td class="row1">
			<img src="{$AvrList['avatar_path']}" alt="{$AvrList['avatar_path']}" />
		</td>
		<td class="row1">
			<a href="./admin.php?page=avatar&amp;edit=1&amp;main=1&amp;id={$AvrList['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=avatar&amp;del=1&amp;main=1&amp;id={$AvrList['id']}">حذف</a>
		</td>
	</tr>
	{/Des::while}
</table>
