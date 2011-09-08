<table border="1" class="t_style_b" width="40%" align="center">
	<tr align="center">
		<td width="40%" class="main1 rows_space">
			{$lang['same_topics']}
		</td>
	</tr>
	{DB::getInfo}{$same_subjects_res}{$SameSubject}
	<tr align="center">
		<td width="40%" class="row1">
			<a href="index.php?page=topic&amp;show=1&amp;id={$SameSubject['id']}">{$SameSubject['title']}</a>
		</td>
	</tr>
	{/DB::getInfo}
</table>
