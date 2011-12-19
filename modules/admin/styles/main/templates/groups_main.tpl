<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=groups&amp;control=1&amp;main=1">{$lang['groups']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		{$lang['group']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['edit']}
		</td>
		<td class="main1 rows_space">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$groups}
	<tr align="center">
		<td class="row1">
			{$groups['h_title']}
		</td>
		<td class="row1">
			<a href="admin.php?page=groups_edit&amp;main=1&amp;id={$groups['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=groups_del&amp;main=1&amp;id={$groups['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
