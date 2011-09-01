<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=extension&amp;control=1&amp;main=1">الامتدادات</a> &raquo; اضافه</div>

<br />

<form action="admin.php?page=extension&amp;add=1&amp;start=1" method="post">
	<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
		<tr valign="top" align="center">
			<td class="main1" colspan="2">
			اضافة إمتداد جديد
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			الامتداد
			</td>
			<td class="row1">
				<input type="text" name="extension" />
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			اقصى حجم (بالكيلوبايت)
			</td>
			<td class="row2">
				<input type="text" name="max_size" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			نوع MIME
			</td>
			<td class="row2">
				<input type="text" name="mime_type" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
	<br />
</form>
