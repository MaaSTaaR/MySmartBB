<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=pages&amp;control=1&amp;main=1">{$lang['pages']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['page_title']}</td>
	<td class="main1">{$lang['common']['edit']}</td>
	<td class="main1">{$lang['common']['delete']}</td>
</tr>
{DB::getInfo}{$PagesList}
<tr valign="top" align="center">
	<td class="row1"><a href="{$init_path}pages/
	{$PagesList['id']}/
	{$PagesList['title']}" target="_blank">{$PagesList['title']}</a></td>
	<td class="row1"><a href="admin.php?page=pages&amp;edit=1&amp;main=1&amp;id={$PagesList['id']}">{$lang['common']['edit']}</a></td>
	<td class="row1"><a href="admin.php?page=pages&amp;del=1&amp;main=1&amp;id={$PagesList['id']}">{$lang['common']['delete']}</a></td>
</tr>
{/DB::getInfo}
</table>
