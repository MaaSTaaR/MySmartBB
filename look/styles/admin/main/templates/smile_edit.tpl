<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=smile&amp;control=1&amp;main=1">الابتسامات</a> &raquo; تحرير الابتسامه : {$Inf['smile_short']}</div>

<br />

<form action="admin.php?page=smile&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تحرير ابتسامه</td>
</tr>
<tr valign="top">
		<td class="row1">اختصار الابتسامه</td>
		<td class="row1">
<input type="text" name="short" id="input_short" value="{$Inf['smile_short']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">مسار الصوره</td>
		<td class="row2">
<input type="text" name="path" id="input_path" value="{$Inf['smile_path']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>

