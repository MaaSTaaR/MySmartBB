<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=usertitle&amp;control=1&amp;main=1">مسميات الاعضاء</a> &raquo; تحرير : {$Inf['usertitle']}</div>

<br />

<form action="admin.php?page=usertitle&amp;edit=1&amp;start=1&amp;id={$Inf['id']}"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تحرير مسمى</td>
</tr>
<tr valign="top">
		<td class="row1">المسمى</td>
		<td class="row1">
<input type="text" name="title" id="input_title" value="{$Inf['usertitle']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">المشاركات</td>
		<td class="row2">
<input type="text" name="posts" id="input_posts" value="{$Inf['posts']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>

