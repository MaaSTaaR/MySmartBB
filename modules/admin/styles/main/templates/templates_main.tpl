<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=template&amp;control=1&amp;main=1">{$lang['templates']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['style_name']}</td>

	<td class="main1">{$lang['templates']}</td>
</tr>
{DB::getInfo}{$StyleList}
<tr valign="top" align="center">
	<td class="row1">{$StyleList['style_title']}</td>
	<td class="row1"><a href="./admin.php?page=template&amp;control=1&amp;show=1&amp;id={$StyleList['id']}">{$lang['view']}</a></td>
</tr>
{/DB::getInfo}
</table>
