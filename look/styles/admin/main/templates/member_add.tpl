<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">الاعضاء</a> &raquo; اضافه</div>

<br />

<form action="admin.php?page=member&amp;add=1&amp;start=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اضافة عضو جديد</td>
</tr>
<tr valign="top">
		<td class="row1">اسم المستخدم</td>
		<td class="row1">
<input type="text" name="username" id="input_username" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">كلمة السر</td>
		<td class="row2">
<input type="password" name="password" id="input_password" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">البريد الالكتروني</td>
		<td class="row1">
<input type="text" name="email" id="input_email" value="" size="30" />&nbsp;
</td>
</tr>

<tr valign="top">
		<td class="row2">الجنس</td>
		<td class="row2">
<select name="gender" id="select_gender">
	<option value="m" >ذكر</option>
	<option value="f" >انثى</option>
</select>
</td>
</tr>
</table><br />

<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>

