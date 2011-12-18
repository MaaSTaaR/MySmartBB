<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=avatar&amp;control=1&amp;main=1">{$lang['avatars']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		{$lang['avatar']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['edit']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$AvrList}
	<tr align="center">
		<td class="row1">
			<img src="{$AvrList['avatar_path']}" alt="{$AvrList['avatar_path']}" />
		</td>
		<td class="row1">
			<a href="./admin.php?page=avatar&amp;edit=1&amp;main=1&amp;id={$AvrList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=avatar&amp;del=1&amp;main=1&amp;id={$AvrList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
