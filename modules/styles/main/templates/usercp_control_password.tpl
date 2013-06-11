{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">

{template}address_bar_part1{/template}
<a href="{$init_path}usercp">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['change_password']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<form method="post" action="{$init_path}usercp_control_password/start">

<table id="change_password_table" align="center" border="1" width="60%" class="t_style_b">
	<tr align="center">
		<td width="60%" class="main1 rows_space" colspan="2">
			{$lang['change_password']}
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
			{$lang['current_password']}
		</td>
		<td width="30%" class="row1">
			<input type="password" name="old_password" />
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row2">
			{$lang['new_password']}
		</td>
		<td width="30%" class="row2">
			<input type="password" name="new_password" />
		</td>
	</tr>
</table>

<br />

<div align="center"><input type="submit" value="{$lang['common']['submit']}" /></div>

</form>

{hook}after_change_password_table{/hook}

</div>
