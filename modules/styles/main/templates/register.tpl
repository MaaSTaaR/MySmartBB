{template}address_bar_part1{/template}
{$lang['registering']}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

<form name="register" method="post" action="{$init_path}register/start">
<table id="register_form_table" border="1" class="t_style_b" width="60%" align="center">
	<tr align="center">
		<td width="80%" class="main1 rows_space" colspan="2">
		{$lang['registering']}
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		{$lang['username']}
		</td>
		<td width="30%" class="row1">
			<input type="text" name="username" id="username_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		{$lang['password']}
		</td>
		<td width="30%" class="row1">
			<input type="password" name="password" id="password_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		{$lang['password_again']}
		</td>
		<td width="30%" class="row1">
			<input type="password" name="password_confirm"  id="password_confirm_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		{$lang['email']}
		</td>
		<td width="30%" class="row1">
			<input type="text" name="email" id="email_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		{$lang['email_again']}
		</td>
		<td width="30%" class="row1">
			<input type="text" name="email_confirm" id="email_confirm_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		{$lang['gender']}
		</td>
		<td width="30%" class="row1">
			<select name="gender" id="gender_id">
				<option value="m" selected="selected">{$lang['male']}</option>
				<option value="f">{$lang['female']}</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width="60%" class="row1" colspan="2" align="center">
			<strong>{$lang['you_can_change_setting']}</strong>
		</td>
	</tr>
</table>
<br />
<div align="center">
<input name="register_button" type="submit" value="{$lang['common']['submit']}" />
</div>
</form>
<br />

{hook}after_register_form_table{/hook}
