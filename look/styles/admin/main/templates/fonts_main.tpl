<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1">الخطوط</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		اسم الخط
		</td>
		<td class="main1">
		تحرير
		</td>
		<td class="main1">
		حذف
		</td>
	</tr>
	{Des::while}{FntList}
	<tr align="center">
		<td class="row1">
			{$FntList['name']}
		</td>
		<td class="row1">
			<a href="./admin.php?page=toolbox&amp;fonts=1&amp;edit=1&amp;main=1&amp;id={$FntList['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=toolbox&amp;fonts=1&amp;del=1&amp;main=1&amp;id={$FntList['id']}">حذف</a>
		</td>
	</tr>
	{/Des::while}
</table>

<br />
