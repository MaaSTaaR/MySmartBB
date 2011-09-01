<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=extension&amp;control=1&amp;main=1">الامتدادات</a> &raquo; تحرير : {$Inf['Ex']}</div>

<br />

<form action="admin.php?page=extension&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			تحرير إمتداد
			</td>
		</tr>
		<tr>
			<td class="row1">
			الامتداد
			</td>
			<td class="row1">
				<input type="text" name="extension" value="{$Inf['Ex']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			اقصى حجم (بالكيلوبايت)
			</td>
			<td class="row2">
				<input type="text" name="max_size" value="{$Inf['max_size']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			نوع MIME
			</td>
			<td class="row2">
				<input type="text" name="mime_type" value="{$Inf['mime_type']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
	<br />
</form>
