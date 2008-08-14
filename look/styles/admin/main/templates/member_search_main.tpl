<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">الاعضاء</a> &raquo; بحث</div>

<br />

<form action="admin.php?page=member&amp;search=1&amp;start=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">البحث عن عضو</td>
</tr>
<tr valign="top">
		<td class="row1">كلمة البحث</td>
		<td class="row1">
<input type="text" name="keyword" id="input_keyword" value="" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">بدلالة</td>
		<td class="row2">
<select name="search_by" id="select_search_by">
	<option value="username" >اسم المستخدم</option>
	<option value="email" >البريد الالكتروني</option>
	<option value="mid" >رقم العضو</option>
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
