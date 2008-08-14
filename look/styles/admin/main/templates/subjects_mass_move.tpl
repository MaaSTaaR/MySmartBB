<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="">نقل جماعي</a></div>

<br />

<form action="admin.php?page=subject&amp;mass_move=1&amp;start=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="70%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">من القسم</td>
</tr>
<tr valign="top" align="center">
	<td class="row1" colspan="2">
	<select name="from" id="select_from">
	{Des::while}{SectionList}
		<option value="{#SectionList['id']#}">{#SectionList['title']#}</option>
	{/Des::while}
	</select>
</td>
</tr>
</table><br />
<table cellpadding="3" cellspacing="1" width="70%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">الى القسم</td>
</tr>
<tr valign="top" align="center">
	<td class="row1" colspan="2">
<select name="to" id="select_to">
	{Des::while}{SectionList}
		<option value="{#SectionList['id']#}">{#SectionList['title']#}</option>
	{/Des::while}
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
