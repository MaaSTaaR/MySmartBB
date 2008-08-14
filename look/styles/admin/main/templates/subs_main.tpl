<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sub&amp;control=1&amp;main=1">المنتديات الفرعيه</a></div>

<br />


<p align="right">من فضلك، يرجى اختيار المنتدى الذي يقع تحته المنتدى الفرعي المطلوب :<br /></p>

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">عنوان المنتدى</td>
</tr>
{Des::while}{SecList}
<tr valign="top" align="center">
	<td class="row1" colspan="2"><a href="admin.php?page=sub&amp;control=1&amp;show_sub=1&amp;id={#SecList['id']#}">{#SecList['title']#}</a></td>
</tr>
{/Des::while}
</table>
