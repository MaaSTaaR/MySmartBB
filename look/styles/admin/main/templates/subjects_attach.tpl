<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="">المواضيع المحتويه على مرفقات</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">عنوان الموضوع</td>
	<td class="main1">الكاتب</td>
</tr>
{Des::while}{AttachList}
<tr valign="top" align="center">
	<td class="row1"><a href="index.php?page=topic&amp;show=1&amp;id={#AttachList['id']#}" target="_blank">{#AttachList['title']#}</a></td>
	<td class="row1"><a href="index.php?page=profile&amp;show=1&amp;username={#AttachList['writer']#}" target="_blank">{#AttachList['writer']#}</a></td>
</tr>
{/Des::while}
</table>
