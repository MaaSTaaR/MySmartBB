<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1">الالوان</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		رمز اللون
		</td>
		<td class="main1">
		تحرير
		</td>
		<td class="main1">
		حذف
		</td>
	</tr>
	{DB::getInfo}{$ClrList}
	<tr align="center">
		<td class="row1">
			<div style="color : {$ClrList['name']}">{$ClrList['name']}</div>
		</td>
		<td class="row1">
			<a href="./admin.php?page=toolbox&amp;colors=1&amp;edit=1&amp;main=1&amp;id={$ClrList['id']}">تحرير</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=toolbox&amp;colors=1&amp;del=1&amp;main=1&amp;id={$ClrList['id']}">حذف</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>