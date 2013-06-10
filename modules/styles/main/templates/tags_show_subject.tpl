{template}address_bar_part1{/template}
{$lang['tags']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<div align="center">
	<strong>
	{$lang['topic_that_used']} <em>{$tag}</em> {$lang['as_tag']}</strong>
</div>

<br />

{hook}after_tag_title{/hook}

{$pager}

<br />

<table id="topics_list_table" border="1" class="t_style_b" width="60%" align="center">
	<tr align="center">
		<td width="80%" class="main1 rows_space" colspan="2">
		{$lang['topics_title']}
		</td>
	</tr>
	{DB::getInfo}{$Subject}
	<tr align="center">
		<td width="80%" class="row1 rows_space" colspan="2">
			<a href="{$init_path}topic/{$Subject['subject_id']}/{$Subject['subject_title']}">{$Subject['subject_title']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

{hook}after_topics_list_table{/hook}
