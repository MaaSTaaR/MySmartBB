{template}address_bar_part1{/template}
{$lang['memberlist']}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

{$pager}

<br />

<table id="member_list_table" border="1" width="60%" class="t_style_b" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="20%">
		{$lang['username']}
		</td>
		<td class="main1 rows_space" width="20%">
		{$lang['usertitle']}
		</td>
		<td class="main1 rows_space" width="10%">
		{$lang['posts']}
		</td>
		<td class="main1 rows_space" width="10%">
		{$lang['visits']}
		</td>
	</tr>
	{DB::getInfo}{$MemberList}
	<tr align="center">
		<td class="row1" width="20%">
		<a href="index.php?page=profile&amp;show=1&amp;id={$MemberList['id']}">{$MemberList['username']}</a>
		</td>
		<td class="row1" width="20%">
		{$MemberList['user_title']}
		</td>
		<td class="row1" width="10%">
		{$MemberList['posts']}
		</td>
		<td class="row1" width="10%">
		{$MemberList['visitor']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

{$pager}

<br />

{hook}after_member_list_table{/hook}
