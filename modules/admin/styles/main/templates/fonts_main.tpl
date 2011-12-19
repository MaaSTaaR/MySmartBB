<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1">{$lang['fonts']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		{$lang['font_name']}
		</td>
		<td class="main1">
		{$lang['common']['edit']}
		</td>
		<td class="main1">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$FntList}
	<tr align="center">
		<td class="row1">
			{$FntList['name']}
		</td>
		<td class="row1">
			<a href="./admin.php?page=toolbox&amp;fonts=1&amp;edit=1&amp;main=1&amp;id={$FntList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="./admin.php?page=toolbox&amp;fonts=1&amp;del=1&amp;main=1&amp;id={$FntList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />
