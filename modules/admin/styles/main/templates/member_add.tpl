<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['members']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=member_add&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['add_member']}
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['username']}
		</td>
		<td class="row1">
			<input type="text" name="username" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['password']}
		</td>
		<td class="row2">
			<input type="password" name="password" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['email']}
		</td>
		<td class="row1">
			<input type="text" name="email" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['gender']}
		</td>
		<td class="row2">
			<select name="gender">
				<option value="m">{$lang['male']}</option>
				<option value="f">{$lang['female']}</option>
			</select>
		</td>
	</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
</form>
