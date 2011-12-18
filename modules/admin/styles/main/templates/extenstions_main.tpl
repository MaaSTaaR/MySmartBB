<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=extension&amp;control=1&amp;main=1">{$lang['extensions']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		{$lang['extension']}
		</td>
		<td class="main1">
		{$lang['max_size']}
		</td>
		<td class="main1">
		{$lang['common']['edit']}
		</td>
		<td class="main1">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$ExList}
	<tr align="center">
		<td class="row1">
			{$ExList['Ex']}
		</td>
		<td class="row1">
			{$ExList['max_size']} {$lang['kilobyte']}
		</td>
		<td class="row1">
			<a href="./admin.php?page=extension&amp;edit=1&amp;main=1&amp;id={$ExList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=extension&amp;del=1&amp;main=1&amp;id={$ExList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
