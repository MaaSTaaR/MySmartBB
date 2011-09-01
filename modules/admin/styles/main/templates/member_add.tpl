<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">الاعضاء</a> &raquo; اضافه</div>

<br />

<form action="admin.php?page=member_add&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		اضافة عضو جديد
		</td>
	</tr>
	<tr>
		<td class="row1">
		اسم المستخدم
		</td>
		<td class="row1">
			<input type="text" name="username" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		كلمة السر
		</td>
		<td class="row2">
			<input type="password" name="password" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		البريد الالكتروني
		</td>
		<td class="row1">
			<input type="text" name="email" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		الجنس
		</td>
		<td class="row2">
			<select name="gender">
				<option value="m">ذكر</option>
				<option value="f">انثى</option>
			</select>
		</td>
	</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
</form>
