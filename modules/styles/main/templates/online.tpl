{hook}before_online_table{/hook}

<table id="online_table" border="1" class="t_style_b" width="80%" align="center">
   	<tr align="center">
		<td class="main1 rows_space" colspan="2">
		{$lang['online']}
		</td>
	</tr>
	{DB::getInfo}{$online_res}{$Online}
	<tr align="center">
		<td class="row1" width="40%">
		<a href="{$init_path}profile/id/
		{$Online['user_id']}">{$Online['username_style']}</a>
		</td>
		<td class="row2" width="40%">
		{$Online['user_location']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

{hook}after_online_table{/hook}
