{template}address_bar_part1{/template}
{$lang['tags']}
{template}address_bar_part2{/template}

<div align="center">
	<strong>
	{$lang['topic_that_used']} <em>{$tag}</em> {$lang['as_tag']}</strong>
</div>

<br />

{$pager}

<br />

<table border="1" class="t_style_b" width="60%" align="center">
	<tr align="center">
		<td width="80%" class="main1 rows_space" colspan="2">
		{$lang['topics_title']}
		</td>
	</tr>
	{DB::getInfo}{$Subject}
	<tr align="center">
		<td width="80%" class="row1 rows_space" colspan="2">
			<a href="index.php?page=topic&amp;show=1&amp;id={$Subject['subject_id']}">{$Subject['subject_title']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />
