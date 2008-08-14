<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sub&amp;control=1&amp;main=1">المنتديات</a> &raquo; <a href="admin.php?page=sub&amp;groups=1&amp;main=1">صلاحيات المجموعات</a> &raquo; التحكم في صلاحيات المجموعات للقسم : {$Inf['title']}</div>

<br />


<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">اسم المجموعه</td>
	<td class="main1">تحكم</td>
</tr>
{Des::while}{GroupList}
<tr valign="top" align="center">
	<td class="row1">{#GroupList['h_title']#}</td>
	<td class="row1"><a href="./admin.php?page=sub&amp;groups=1&amp;control_group=1&amp;index=1&amp;group_id={#GroupList['id']#}&amp;id={$Inf['id']}">تحكم</a></td>
</tr>
{/Des::while}
</table>
