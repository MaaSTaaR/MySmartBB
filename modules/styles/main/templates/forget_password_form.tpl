{template}address_bar_part1{/template}
{$lang['forget_password']}
{template}address_bar_part2{/template}

<br />

<form method="post" action="index.php?page=forget&amp;start=1">
<table border="1" width="50%" align="center" class="t_style_b">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		{$lang['forget_password']}
		</td>
	</tr>
	<tr align="center">
		<td width="25%" class="row1">
		{$lang['your_email']}
		</td>
		<td width="25%" class="row1">
			<input name="email" type="text" />
		</td>
	</tr>
</table>
<br />
<div align="center">
	<input type="submit" name="submit_forget" value="{$lang['common']['submit']}" />
</div>
</form>

<br />
