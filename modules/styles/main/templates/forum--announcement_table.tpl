{hook}before_announcement_table{/hook}

<table id="announcement_table" border="1" class="t_style_b" width="98%" align="center">
	<tr>
		<td width="98%" align="center" class="main1 rows_space">
			{$lang['announcements']}
		</td>
	</tr>
	<tr>
		<td width="98%" class="row1 rows_space">
			<a href="{$init_path}announcement/{$announcement['id']}/{$announcement['title']}">
			{$announcement['title']}
			</a> 
		    {$lang['common']['written_by']}
			<a href="{$init_path}/profile/{$announcement['writer']}">
			{$announcement['writer']}
			</a> 
			
			{$lang['common']['on_date']} {$announcement['date']}
		</td>
	</tr>
</table>

<br />

{hook}after_announcement_table{/hook}
