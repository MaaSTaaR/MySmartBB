<table border="1" class="t_style_b" width="80%" align="center">
   	<tr align="center">
		<td class="main1 rows_space" colspan="2">
		المتواجدين حالياً
		</td>
	</tr>
	{Des::while}{Online}
	<tr align="center">
		<td class="row1" width="40%">
		<a href="index.php?page=profile&amp;show=1&amp;id={$Online['user_id']}">{$Online['username_style']}</a>
		</td>
		<td class="row2" width="40%">
		{$Online['user_location']}
		</td>
	</tr>
	{/Des::while}
</table>
