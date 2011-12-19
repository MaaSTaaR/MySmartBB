<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=style&amp;control=1&amp;main=1">{$lang['styles']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['style_title']}</td>
	<td class="main1">{$lang['common']['edit']}</td>
	<td class="main1">{$lang['common']['delete']}</td>
</tr>
{DB::getInfo}{$StlList}
<tr valign="top" align="center">
	<td class="row1">{$StlList['style_title']}</td>
	<td class="row1"><a href="./admin.php?page=style&amp;edit=1&amp;main=1&amp;id={$StlList['id']}">{$lang['common']['edit']}</a></td>
	<td class="row1"><a href="./admin.php?page=style&amp;del=1&amp;main=1&amp;id={$StlList['id']}">{$lang['common']['delete']}</a></td>

</tr>
{/DB::getInfo}
</table>
