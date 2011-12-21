{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['change_password']}
{template}address_bar_part2{/template}

<form method="post" action="index.php?page=usercp_control_password&amp;start=1">

<table align="center" border="1" width="60%" class="t_style_b">
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

</div>
