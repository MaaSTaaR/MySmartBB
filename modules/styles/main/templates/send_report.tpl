{template}address_bar_part1{/template}
{$lang['send_report']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<form method="post" action="{$init_path}report/start/{$subject_id}
{if {$reply_id} != ''}
/{$reply_id}
{/if}">

<br />

<div align="center">

<table id="send_report_table" border="1" width="70%" class="t_style_b">
	<tr>
		<td class="main1 rows_space" colspan="2" align="center">
		{$lang['send_report']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" width="20%">{$lang['message']}</td>
		<td class="row1 rows_space" width="70%">
			<textarea rows="12" name="text" cols="69"></textarea>
			<p>
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" width="100%" colspan="2">
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
</table>

</div>

</form>


{hook}after_send_report_table{/hook}
<br />
