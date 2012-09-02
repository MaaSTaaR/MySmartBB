<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['members']}</a></div>

<br />

<table width="90%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1">{$lang['username']}</td>
		<td class="main1">{$lang['common']['edit']}</td>
		<td class="main1">{$lang['common']['delete']}</td>
	</tr>
	{DB::getInfo}{$MembersList}
	<tr align="center">
		<td class="row1"><a href="index.php?page=profile&amp;show=1&amp;id={$MembersList['id']}" target="_blank">{$MembersList['username']}</a></td>
		<td class="row1"><a href="admin.php?page=member_edit&amp;main=1&amp;id={$MembersList['id']}">{$lang['common']['edit']}</a></td>
		<td class="row1"><a href="admin.php?page=member_del&amp;main=1&amp;id={$MembersList['id']}">{$lang['common']['delete']}</a></td>
	</tr>
	{/DB::getInfo}
</table>
