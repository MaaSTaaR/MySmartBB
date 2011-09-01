<br />
			<table align="center" border="1" width="98%" class="t_style_b">
				<tr align="center">
					<td class="main1 rows_space">
						إحصائيات
						</td>
					</tr>
					<tr align="right">
						<td class="main2 rows_space small_text">
							<strong><a href="index.php?page=online&amp;show=1">المتواجدون الآن</a> : </strong> ({$MemberNumber}) عضو و ({$GuestNumber}) زائر
						</td>
					</tr>
					<tr align="right">
						<td class="row1">
							{DB::getInfo}{$group_res}{$group}
								{$group['username_style']}،
							{/DB::getInfo}
						</td>
					</tr>
					<tr align="right">
						<td class="row2">
						{DB::getInfo}{$online_res}{$online}
							<a href="index.php?page=profile&show=1&id={$online['user_id']}">{$online['username_style']}</a>،
						{/DB::getInfo}
			
						{if {$_CONF['info_row']['show_onlineguest']} == 1}
							{if {$MemberNumber} + {$GuestNumber} <= 0}
			لا يوجد شخص قام بتسجيل دخوله
							{/if}
						{else}
							{if {$MemberNumber} <= 0}
			لا يوجد شخص قام بتسجيل دخوله
							{/if}
						{/if}
						</td>
					</tr>
					<tr align="right">
						<td class="main2 rows_space small_text">
							<strong>من تواجد اليوم</strong> : ({$TodayNumber}) عضو
						</td>
					</tr>
					<tr align="right">
						<td class="row1">
						{if {$TodayNumber} > 0}
							{DB::getInfo}{$today_res}{$today}
							<a href="index.php?page=profile&amp;show=1&amp;id={$today['user_id']}">{$today['username_style']}</a>،
							{/DB::getInfo}
						{elseif {$TodayNumber} <= 0}
						لا يوجد عضو قام بزيارة المنتديات اليوم
						{/if}
						</td>
					</tr>
				</table>
				
				<br />
