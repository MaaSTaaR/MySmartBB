{template}address_bar_part1{/template}
{$lang['statistics']}
{template}address_bar_part2{/template}

<br />
{hook}after_adress_bar{/hook}

<table id="general_stats_table" border="1" width="95%" class="t_style_b" align="center">
	<tr align="center">
		<td width="10%" class="main1 rows_space">
		{$lang['board_age']}
		</td>
		<td width="20%" class="main1 rows_space">
		{$lang['creation_date']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['member_number']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['subject_number']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['reply_number']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['active_member_number']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['forum_number']}
		</td>
	</tr>
	<tr align="center">
		<td width="10%" class="row1">
		{$StaticInfo['Age']} {$lang['day']}
		</td>
		<td width="20%" class="row1">
		{$StaticInfo['InstallDate']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetMemberNumber']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetSubjectNumber']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetReplyNumber']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetActiveMember']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetSectionNumber']}
		</td>
	</tr>
</table>

<br />

{hook}after_general_stats_table{/hook}

<table id="topics_stats_table" border="1" width="95%" class="t_style_b" align="center">
	<tr align="center">
		<td class="main1 rows_space1">
		{$lang['older_subject_writer']}
		</td>
		<td class="main1 rows_space">
		{$lang['newer_subject_writer']}
		</td>
		<td class="main1 rows_space">
		{$lang['most_reply_writer']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;username={$StaticInfo['OldestSubjectWriter']}">{$StaticInfo['OldestSubjectWriter']}</a>
		</td>
		<td class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;username={$StaticInfo['NewerSubjectWriter']}">{$StaticInfo['NewerSubjectWriter']}</a>
		</td>
		<td class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;username={$StaticInfo['MostSubjectWriter']}">{$StaticInfo['MostSubjectWriter']}</a>
		</td>
	</tr>
</table>

<br />

{hook}after_topics_stats_table{/hook}

<table id="most_active_writer_table" border="1" width="50%" class="t_style_b" align="center">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		{$lang['most_active_writer']}
		</td>
	</tr>
	{DB::getInfo}{$topten_res}{$TopTenList}
	<tr align="center">
		<td width="30%" class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;id={$TopTenList['id']}">{$TopTenList['username']}</a>
		</td>
		<td width="20%" class="row1">
		{$TopTenList['posts']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

{hook}after_most_active_writer_table{/hook}

<table id="most_active_subject" border="1" width="50%" class="t_style_b" align="center">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		{$lang['most_active_subject']}
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
		{$lang['subject_title']}
		</td>
		<td width="20%" class="row1">
		{$lang['reply_number']}
		</td>
	</tr>
	{DB::getInfo}{$topsubject_res}{$TopSubject}
	<tr align="center">
		<td width="30%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$TopSubject['id']}">{$TopSubject['title']}</a>
		</td>
		<td width="20%" class="row1">
		{$TopSubject['reply_number']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

{hook}after_most_active_subject_table{/hook}

<table id="most_active_views_table" border="1" width="50%" class="t_style_b" align="center">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		{$lang['most_active_subject_visits']}
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
		{$lang['subject_title']}
		</td>
		<td width="20%" class="row1">
		{$lang['visit_number']}
		</td>
	</tr>
	{DB::getInfo}{$topvisit_res}{$TopSubjectVisitor}
	<tr align="center">
		<td width="30%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$TopSubjectVisitor['id']}">{$TopSubjectVisitor['title']}</a>
		</td>
		<td width="20%" class="row1">
		{$TopSubjectVisitor['visitor']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

{hook}after_most_active_views_table{/hook}

<br />
