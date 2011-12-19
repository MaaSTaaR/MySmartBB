<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=smile&amp;control=1&amp;main=1">{$lang['smiles']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['smile']}</td>

	<td class="main1">{$lang['common']['edit']}</td>
	<td class="main1">{$lang['common']['delete']}</td>
</tr>
{DB::getInfo}{$SmlList}
<tr valign="top" align="center">
	<td class="row1"><img src="{$SmlList['smile_path']}" alt="" /></td>
	<td class="row1"><a href="./admin.php?page=smile&amp;edit=1&amp;main=1&amp;id={$SmlList['id']}">{$lang['common']['edit']}</a></td>
	<td class="row1"><a href="./admin.php?page=smile&amp;del=1&amp;main=1&amp;id={$SmlList['id']}">{$lang['common']['delete']}</a></td>
</tr>
{/DB::getInfo}
</table>
