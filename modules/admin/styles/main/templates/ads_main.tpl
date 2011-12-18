<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=ads&amp;control=1&amp;main=1">{$lang['ads']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		{$lang['site_name']}
		</td>
		<td class="main1 rows_space">
		{$lang['visits']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['edit']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$AdsList}
	<tr align="center">
		<td class="row1">
			{$AdsList['sitename']}
		</td>
		<td class="row1">
			{$AdsList['clicks']}
		</td>
		<td class="row1">
			<a href="admin.php?page=ads&amp;edit=1&amp;main=1&amp;id={$AdsList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=ads&amp;del=1&amp;main=1&amp;id={$AdsList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
