<br />
			<table align="center" border="1" width="98%" class="t_style_b">
				<tr align="center">
					<td class="main1 rows_space">
						إحصائيات
						</td>
					</tr>
					<tr align="right">
						<td class="main2 rows_space small_text">
							<strong>المتواجدين الآن : </strong> ({$MemberNumber}) عضو و ({$GuestNumber}) زائر
						</td>
					</tr>
					<tr align="right">
						<td class="row1">
							{Des::while}{GroupList}
								{$GroupList['h_title']}،
							{/Des::while}
						</td>
					</tr>
					<tr align="right">
						<td class="row2">
						{Des::while}{OnlineList}
							<a href="index.php?page=profile&show=1&id={$OnlineList['user_id']}">{$OnlineList['username_style']}</a>،
						{/Des::while}
			
						{if {{$_CONF['info_row']['show_onlineguest']}} == 1}
							{if {{$MemberNumber}}+{{$GuestNumber}} <= 0}
			لا يوجد شخص قام بتسجيل دخوله
							{/if}
						{else}
							{if {{$MemberNumber}} <= 0}
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
						{if {{$TodayNumber}} > 0}
							{Des::while}{TodayList}
							<a href="index.php?page=profile&amp;show=1&amp;id={$TodayList['user_id']}">{$TodayList['username_style']}</a>،
							{/Des::while}
						{elseif {{$TodayNumber}} <= 0}
						لا يوجد عضو قام بزيارة المنتديات اليوم
						{/if}
						</td>
					</tr>
				</table>
				
				<br />
