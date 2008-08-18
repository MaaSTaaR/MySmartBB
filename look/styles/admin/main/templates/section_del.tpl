<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">الاقسام الرئيسيه</a> &raquo; تأكيد حذف : {$Inf['title']}</div>

<br />

<form action="admin.php?page=sections&amp;del=1&amp;start=1&amp;id={$Inf['id']}" name="myform" method="post">
<p align="center">انت الآن مُقدم على حذف قسم رئيسي<br /></p>

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="0" align="center">
<tr valign="top">
		<td class="row1">ما الذي تريد فعله؟</td>
		<td class="row1">
<select name="choose" id="select_choose">
	<option value="move" >نقل جميع المنتديات التي تحته إلى قسم رئيسي آخر</option>
	<option value="del" >حذف جميع المنتديات و مواضيعهم</option>
	<option value="move_subjects" >حذف جميع المنتديات مع نقل المواضيع إلى منتدى آخر</option>
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">نقل إلى</td>
		<td class="row2">
<select name="to" id="select_to">
		{Des::while}{SecList}
		<option value="{$SecList['id']}">{$SecList['title']}</option>
		{/Des::while}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">نقل المواضيع إلى</td>
		<td class="row1">
		<select name="subject_to" id="select_subject_to">
		{Des::while}{ForumsList}
		<option value="{$ForumsList['id']}">{$ForumsList['title']}</option>
		{/Des::while}
</select>
</td>
</tr>
</table><br />
<div align="center"><tr>

	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="   موافق   " name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
