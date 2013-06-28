{template}address_bar_part1{/template}
<a href="{$init_path}profile/
{$username}">{$lang['profile_of']} {$username}</a>
 {$_CONF['info_row']['adress_bar_separate']}
 {$lang['topics_of']} {$username}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

<table id="topics_list_table" border="1" width="80%" class="t_style_b" align="center">
	<tr align="center">
		<td width="20%" class="main1 rows_space">
		{$lang['topic_title']}
		</td>
		<td width="20%" class="main1 rows_space">
		{$lang['topic_author']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['topic_visitor']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['replies_number']}
		</td>
		<td width="20%" class="main1 rows_space">
		{$lang['write_date']}
		</td>
	</tr>
{DB::getInfo}{$topics_res}{$topic}
	<tr align="center">
		<td width="20%" class="row1">
			<a href="{$init_path}topic/
			{$topic['id']}/
			{$topic['title']}">
				{$topic['title']}
			</a>
		</td>
		<td width="20%" class="row1">
			<a href="{$init_path}profile/
			{$topic['writer']}">{$topic['writer']}</a>
		</td>
		<td width="10%" class="row1">
		{$topic['visitor']}
		</td>
		<td width="10%" class="row1">
		{$topic['reply_number']}
		</td>
		<td width="20%" class="row1">
		{$topic['write_date']}
		</td>
	</tr>
{/DB::getInfo}
</table>

<br />

{$pager}

{hook}after_topics_list_table{/hook}