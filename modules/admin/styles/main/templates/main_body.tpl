<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">{$lang['statistics']}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['version']} MySmartBB</td>
		<td class="row2" width="40%" dir="ltr"><strong>{$_CONF['info_row']['MySBB_version']}</strong></td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['members_number']}</td>
		<td class="row2" width="40%">{$MemberNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['active_members_number']}</td>
		<td class="row2" width="40%">{$ActiveMember}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['forums_number']}</td>
		<td class="row2" width="40%">{$ForumsNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['topics_numer']}</td>
		<td class="row2" width="40%">{$SubjectNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['replies_number']}</td>
		<td class="row2" width="40%">{$ReplyNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['registration_today']}</td>
		<td class="row2" width="40%">{$TodayMemberNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['today_topics']}</td>
		<td class="row2" width="40%">{$TodaySubjectNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['today_replies']}</td>
		<td class="row2" width="40%">{$TodayReplyNumber}</td>
	</tr>
</table>

<br />

<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">{$lang['info_about']} MySmartBB</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['developers']}</td>
		<td class="row2" width="40%"><strong><a traget="_blank" href="">{$lang['here']}</a></strong></td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['official_website']}</td>
		<td class="row2" width="40%"><strong><a traget="_blank" href="http://www.mysmartbb.com">{$lang['here']}</a></strong></td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['documents']}</td>
		<td class="row2" width="40%"><strong><a traget="_blank" href="">{$lang['here']}</a></strong></td>
	</tr>
</table>

<br />

<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1">{$lang['admin_notes']}</td>
	</tr>
	<tr align="center">
		<td class="row1">
			<form method="post" action="admin.php?page=note">
				<textarea name="note" rows="9" cols="77">{$_CONF['info_row']['admin_notes']}</textarea>
				<br />
				<input type="submit" value="{$lang['common']['submit']}" name="submit" />
			</form>
		</td>
	</tr>
</table>
