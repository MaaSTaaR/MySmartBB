{template}address_bar_part1{/template}
{$lang['send_email_to']} {$MemberInfo['username']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<form method="post" action="{$init_path}send/start/{$MemberInfo['id']}">

<br />

<table id="send_email_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['message_context']}
		</td>
	</tr>
	</tr>
		<td class="row1 rows_space">
			{$lang['message_title']}
		</td>
		<td class="row2 rows_space">
			<input name="title" type="text" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69"></textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
</table>

</form>

<br />

{hook}after_send_email_table{/hook}
