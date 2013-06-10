{hook}before_similar_topics_table{/hook}

<table id="similar_topics_table" border="1" class="t_style_b" width="40%" align="center">
	<tr align="center">
		<td width="40%" class="main1 rows_space">
			{$lang['same_topics']}
		</td>
	</tr>
	{DB::getInfo}{$similar_subjects_res}{$SameSubject}
	<tr align="center">
		<td width="40%" class="row1">
			<a href="{$init_path}topic/{$SameSubject['id']}/{$SameSubject['title']}">{$SameSubject['title']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>

{hook}after_similar_topics_table{/hook}
