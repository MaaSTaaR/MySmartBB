<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="">{$lang['trash']}</a></div>

<br />
<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['reply_id']}</td>
	<td class="main1">{$lang['writer']}</td>
	<td class="main1">{$lang['restore']}</td>
	<td class="main1">{$lang['common']['delete']}</td>
</tr>
{DB::getInfo}{$TrashList}
<tr valign="top" align="center">
	<td class="row1">#{$TrashList['id']}</td>
	<td class="row1"><a href="index.php?page=profile&amp;show=1&amp;username={$TrashList['writer']}">{$TrashList['writer']}</a></td>
	<td class="row1"><a href="admin.php?page=trash&amp;reply=1&amp;untrash=1&amp;start=1&amp;id={$TrashList['id']}">{$lang['restore']}</a></td>
	<td class="row1"><a href="admin.php?page=trash&amp;reply=1&amp;del=1&amp;confirm=1&amp;id={$TrashList['id']}">{$lang['common']['delete']}</a></td>
</tr>
{/DB::getInfo}
</table>
