<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=icon&amp;control=1&amp;main=1">{$lang['icons']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		{$lang['icon']}
		</td>
		<td class="main1">
		{$lang['common']['edit']}
		</td>
		<td class="main1">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$IcnList}
	<tr align="center">
		<td class="row1">
			<img src="{$IcnList['smile_path']}" alt="{$IcnList['smile_path']}" />
		</td>
		<td class="row1">
			<a href="./admin.php?page=icon&amp;edit=1&amp;main=1&amp;id={$IcnList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=icon&amp;del=1&amp;main=1&amp;id={$IcnList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
