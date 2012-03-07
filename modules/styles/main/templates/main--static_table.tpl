<br />
			<table id="statistics_table" align="center" border="1" width="98%" class="t_style_b">
				<tr align="center">
					<td class="main1 rows_space">
						{$lang['statistics']}
						</td>
					</tr>
					<tr>
						<td class="main2 rows_space small_text">
							<strong><a href="index.php?page=online&amp;show=1">{$lang['online']}</a> : </strong> ({$MemberNumber}) {$lang['common']['member']} {$lang['common']['and']} ({$GuestNumber}) {$lang['common']['visitor']}
						</td>
					</tr>
					<tr>
						<td class="row1">
							{DB::getInfo}{$group_res}{$group}
								{$group['username_style']}{$lang['common']['comma']}
							{/DB::getInfo}
						</td>
					</tr>
					<tr>
						<td class="row2">
						{DB::getInfo}{$online_res}{$online}
							<a href="index.php?page=profile&show=1&id={$online['user_id']}">{$online['username_style']}</a>{$lang['common']['comma']}
						{/DB::getInfo}
			
						{if {$_CONF['info_row']['show_onlineguest']} == 1}
							{if {$MemberNumber} + {$GuestNumber} <= 0}
			                {$lang['no_online']}
							{/if}
						{else}
							{if {$MemberNumber} <= 0}
			                {$lang['no_online']}
							{/if}
						{/if}
						</td>
					</tr>
					<tr>
						<td class="main2 rows_space small_text">
							<strong>{$lang['today']}</strong> : ({$TodayNumber}) {$lang['common']['member']}
						</td>
					</tr>
					<tr>
						<td class="row1">
						{if {$TodayNumber} > 0}
							{DB::getInfo}{$today_res}{$today}
							<a href="index.php?page=profile&amp;show=1&amp;id={$today['user_id']}">{$today['username_style']}</a>{$lang['common']['comma']}
							{/DB::getInfo}
						{elseif {$TodayNumber} <= 0}
						{$lang['no_today']}
						{/if}
						</td>
					</tr>
				</table>
				
				<br />
				
				{hook}after_statistics_table{/hook}
