<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=extension&amp;search=1&amp;main=1">الملفات المرفقه</a> &raquo; البحث بالمرفقات </div>

<br />

<form action="admin.php?page=extension&amp;search=1&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			البحث بالمرفقات
			</td>
		</tr>
		<tr>
			<td class="row1">
			كلمة البحث
			</td>
			<td class="row1">
				<input type="text" name="keyword" id="input_keyword" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			بدلالة
			</td>
			<td class="row2">
				<select name="search_by" id="select_search_by">
					<option value="filename">اسم الملف</option>
					<option value="filesize">حجم الملف</option>
					<option value="visitor">مرات التحميل</option>
				</select>
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
</form>
