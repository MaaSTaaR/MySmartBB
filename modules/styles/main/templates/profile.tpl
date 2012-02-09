{template}address_bar_part1{/template}
{$lang['view_member_profile']} {$MemberInfo['username']}
{template}address_bar_part2{/template}

{hook}after_address_bar{/hook}

<table id="profile_main_table" align="center" class="t_style_b" border="1" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
		{$lang['view_member_profile']} {$MemberInfo['username']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['username']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['display_username']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['usertitle']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_title']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['register_date']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['register_date']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['post_number']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['posts']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['visit_number']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['visitor']}
		</td>
	</tr>
	{if !empty({$MemberInfo['user_country']})}
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['country']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_country']}
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['gender']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_gender']}
		</td>
	</tr>
	{if !empty({$MemberInfo['user_website']}) and {$MemberInfo['user_website']} != 'http://'}
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['website']}
		</td>
		<td class="row1" width="30%">
		 <a href="{$MemberInfo['user_website']}">{$MemberInfo['user_website']}</a>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['last_visit']}
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['lastvisit']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['member_group']}
		</td>
		<td class="row1" width="30%">
		  {$MemberInfo['usergroup']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['member_state']}
		</td>
		<td class="row1" width="30%">
		 {if {$status} == 'online'}
		 <span class="online">{$lang['online']}</span>
		 {else}
		 <span class="offline">{$lang['offline']}</span>
		 {/if}
		</td>
	</tr>
	{if {$MemberInfo['IsOnline']}}
	<tr align="center">
		<td class="row1" width="20%">
		{$lang['member_location']}
		</td>
		<td class="row1" width="30%">
		{$Location['user_location']}
		</td>
	</tr><tr id="plugin_mysmartmicroblog_link_row" align="center">
<td class="row1" width="20%">المدوّنة المُصغرة</td>
<td class="row1" width="30%"><a href="index.php?page=plugin&amp;name=MySmartMicroblog&amp;action=show&amp;id={$MemberInfo['id']}">هنا</a></td>
</tr>



	{/if}
</table>
<br />

{hook}after_main_table{/hook}
<table id="plugin_mysmartmicroblog_last_post_table" align="center" class="t_style_b" border="1" width="60%">
<tr align="center">
<td class="main1 rows_space" width="60%">
التدوينة الأخيره
</td>
</tr>
<tr align="center">
<td class="row1" width="30%">
{if {$mysmartmicroblog_no_posts} == 'true'}
لا توجد تدوينات
{else}
{$mysmartmicroblog_post['context']}
{/if}
</td>
</tr>
</table><br id="plugin_mysmartmicroblog_last_post_br"></br>






{if {$MemberInfo['away']}}
<table id="profile_away_table" align="center" class="t_style_b" border="1" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%">
		{$lang['member_away']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="30%">
		 {$MemberInfo['away_msg']}
		</td>
	</tr>
</table>
{/if}

{hook}after_away_table{/hook}

{if {$MemberInfo['user_sig']} != ''}
<br />
<table id="profile_signature_table" align="center" class="t_style_b" border="1" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%">
		{$lang['signature']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="30%">
		 {$MemberInfo['user_sig']}
		</td>
	</tr>
</table>
{/if}

<br />

{hook}after_signature_table{/hook}

<table id="profile_details_table" align="center" class="t_style_b" border="1" width="80%">
	<tr align="center">
		<td width="60%" class="main1 rows_space" colspan="4">
		{$lang['details']}
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
		{$lang['last_topic']}
		</td>
		<td width="20%" class="row1">
		{$lang['last_reply']}
		</td>
		<td width="20%" class="row1">
		{$lang['send_pm']}
		</td>
		<td width="20%" class="row1">
		{$lang['send_email']}
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$LastSubject['id']}">{$LastSubject['title']}</a>
		</td>
		<td width="20%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$LastReply['id']}">{$LastReply['title']}</a>
		</td>
		<td width="20%" class="row1">
		<a href="index.php?page=pm_send&amp;send=1&amp;index=1&amp;username={$MemberInfo['username']}">{$lang['send_pm']}</a>
		</td>
		<td width="20%" class="row1">
		<a href="index.php?page=send&amp;member=1&amp;index=1&amp;id={$MemberInfo['id']}">{$lang['send_email']}</a> 
		</td>
	</tr>
</table>

{hook}after_details_table{/hook}

<br />
