{hook}before_moderator_table{/hook}

<table id="moderator_table" border="1" class="t_style_b" width="98%" align="center">
	<tr>
		<td width="98%" class="main1 rows_space">
			{$lang['common']['moderators']}
		</td>
	</tr>
	<tr>
		<td width="98%" class="row1">
		{DB::getInfo}{$moderator_res}{$ModeratorsList}
		<a href="index.php?page=profile&amp;show=1&amp;id={$ModeratorsList['member_id']}">{$ModeratorsList['username']}</a> ،
		{/DB::getInfo}
		</td>
	</tr>
</table>

<br />

{hook}after_moderator_table{/hook}
