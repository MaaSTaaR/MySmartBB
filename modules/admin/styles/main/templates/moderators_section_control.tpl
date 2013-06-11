<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">{$lang['moderators']}</a> &raquo; {$Section['title']}</div>

<br />

<table width="80%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="40%">
		{$lang['moderator']}
		</td>
		<td class="main1 rows_space" width="20%">
		{$lang['edit_member']}
		</td>
		<td class="main1 rows_space" width="20%">
		{$lang['cancel_moderator']}
		</td>
	</tr>
	{DB::getInfo}{$ModeratorsList}
	<tr align="center">
		<td class="row1" width="40%">
			<a href="{$init_path}profile/
		{$ModeratorsList['username']}" target="_blank">{$ModeratorsList['username']}</a>
		</td>
		<td class="row1" width="20%">
			<a href="admin.php?page=member_edit&amp;main=1&amp;id={$ModeratorsList['member_id']}">{$lang['edit_member']}</a>
		</td>
		<td class="row1" width="20%">
			<a href="admin.php?page=moderators&amp;del=1&amp;main=1&amp;id={$ModeratorsList['id']}">{$lang['cancel_moderator']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
