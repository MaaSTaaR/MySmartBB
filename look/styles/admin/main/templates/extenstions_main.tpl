<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=extension&amp;control=1&amp;main=1">الامتدادات</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		الامتداد
		</td>
		<td class="main1">
		اقصى حجم
		</td>
		<td class="main1">
		تحرير
		</td>
		<td class="main1">
		حذف
		</td>
	</tr>
	{Des::while}{ExList}
	<tr align="center">
		<td class="row1">
			{$ExList['Ex']}
		</td>
		<td class="row1">
			{$ExList['max_size']} كيلوبايت
		</td>
		<td class="row1">
			<a href="./admin.php?page=extension&amp;edit=1&amp;main=1&amp;id={$ExList['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=extension&amp;del=1&amp;main=1&amp;id={$ExList['id']}">حذف</a>
		</td>
	</tr>
	{/Des::while}
</table>
