<table border="1" class="t_style_b" width="80%" align="center">
   	<tr align="center">
		<td class="main1 rows_space" colspan="2">
		المتواجدون حالياً
		</td>
	</tr>
	{DB::getInfo}{$Online}
	<tr align="center">
		<td class="row1" width="40%">
		<a href="index.php?page=profile&amp;show=1&amp;id={$Online['user_id']}">{$Online['username_style']}</a>
		</td>
		<td class="row2" width="40%">
		{$Online['user_location']}
		</td>
	</tr>
	{/DB::getInfo}
</table>