<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="">{$lang['topics_with_attachments']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['topic_title']}</td>
	<td class="main1">{$lang['writer']}</td>
</tr>
{DB::getInfo}{$AttachList}
<tr valign="top" align="center">
	<td class="row1"><a href="index.php?page=topic&amp;show=1&amp;id={$AttachList['id']}" target="_blank">{$AttachList['title']}</a></td>
	<td class="row1"><a href="index.php?page=profile&amp;show=1&amp;username={$AttachList['writer']}" target="_blank">{$AttachList['writer']}</a></td>
</tr>
{/DB::getInfo}
</table>
