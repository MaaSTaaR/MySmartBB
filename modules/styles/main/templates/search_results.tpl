{template}address_bar_part1{/template}
{$lang['search_result']}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

<table id="search_results_table" border="1" width="80%" class="t_style_b" align="center">
	<tr align="center">
		<td width="20%" class="main1 rows_space">
		{$lang['subject_title']}
		</td>
		<td width="20%" class="main1 rows_space">
		{$lang['subject_writer']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['subject_visitor']}
		</td>
		<td width="10%" class="main1 rows_space">
		{$lang['reply_number']}
		</td>
		<td width="20%" class="main1 rows_space">
		{$lang['write_date']}
		</td>
	</tr>
{DB::getInfo}{$search_res}{$SearchResult}
	<tr align="center">
		<td width="20%" class="row1">
			<a href="index.php?page=topic&amp;show=1&amp;id={$SearchResult['id']}&amp;highlight={$highlight}">
				{$SearchResult['title']}
			</a>
		</td>
		<td width="20%" class="row1">
			<a href="index.php?page=profile&amp;show=1&amp;username={$SearchResult['writer']}">{$SearchResult['writer']}</a>
		</td>
		<td width="10%" class="row1">
		{$SearchResult['visitor']}
		</td>
		<td width="10%" class="row1">
		{$SearchResult['reply_number']}
		</td>
		<td width="20%" class="row1">
		{$SearchResult['write_date']}
		</td>
	</tr>
{/DB::getInfo}
</table>

<br />

{hook}after_search_results_table{/hook}
