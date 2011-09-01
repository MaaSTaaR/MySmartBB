<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="">المواضيع المغلقه</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">عنوان الموضوع</td>
	<td class="main1">الكاتب</td>
</tr>
{DB::getInfo}{$CloseList}
<tr valign="top" align="center">
	<td class="row1"><a href="../index.php?page=topic&amp;show=1&amp;id={$CloseList['id']}" traget="_blank">{$CloseList['title']}</a></td>
	<td class="row1"><a href="../index.php?page=profile&amp;show=1&amp;username={$CloseList['writer']}" traget="_blank">{$CloseList['writer']}</a></td>
</tr>
{/DB::getInfo}
</table>
