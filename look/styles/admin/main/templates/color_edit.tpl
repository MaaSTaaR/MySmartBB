<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1">الالوان</a> &raquo; تحرير : {$Inf['name']}</div>

<br />

<form action="admin.php?page=toolbox&amp;colors=1&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			تحرير لون
			</td>
		</tr>
		<tr>
			<td class="row1">
			رمز اللون
			</td>
			<td class="row1">
				<input type="text" name="name" value="{$Inf['name']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input class="submit" type="submit" value="موافق" name="submit" />
	</div>
	
	<br />
	
</form>
