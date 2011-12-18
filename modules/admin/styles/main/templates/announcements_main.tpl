<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=announcement&amp;control=1&amp;main=1">{$lang['announcements']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		{$lang['title']}
		</td>
		<td class="main1 rows_space">
		{$lang['writer']}
		</td>
		<td class="main1 rows_space">
		{$lang['add_date']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['edit']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$AnnList}
	<tr align="center">
		<td class="row1">
			<a href="index.php?page=announcement&amp;show=1&amp;id={$AnnList['id']}" target="_blank">{$AnnList['title']}</a>
		</td>
		<td class="row1">
			<a href="index.php?page=profile&amp;show=1&amp;username={$AnnList['writer']}" target="_blank">{$AnnList['writer']}</a>
		</td>
		<td class="row1">
			{$AnnList['date']}
		</td>
		<td class="row1">
			<a href="admin.php?page=announcement&amp;edit=1&amp;main=1&amp;id={$AnnList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=announcement&amp;del=1&amp;main=1&amp;id={$AnnList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
