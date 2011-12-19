<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=usertitle&amp;control=1&amp;main=1">{$lang['usertitles']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">
		{$lang['usertitle']}
		</td>
		<td class="main1">
		{$lang['posts_number']}
		</td>
		<td class="main1">
		{$lang['common']['edit']}
		</td>
		<td class="main1">
		{$lang['common']['delete']}
		</td>
	</tr>
	{DB::getInfo}{$UTList}
	<tr align="center">
		<td class="row1">
			{$UTList['usertitle']}
		</td>
		<td class="row1">
			{$UTList['posts']}
		</td>
		<td class="row1">
			<a href="admin.php?page=usertitle&amp;edit=1&amp;main=1&amp;id={$UTList['id']}">{$lang['common']['edit']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=usertitle&amp;del=1&amp;main=1&amp;id={$UTList['id']}">{$lang['common']['delete']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
