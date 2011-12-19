<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['members_merge']}</a> </div>

<br />

<form action="admin.php?page=member_merge&amp;start=1" method="post">

	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">{$lang['members_merge']}</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['from_member']}
			</td>
			<td class="row1">
				<input type="text" name="user_get" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['to_member']}
			</td>
			<td class="row2">
				<input type="text" name="user_to" size="30" />
			</td>
		</tr>
	</table>

	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />

</form>
