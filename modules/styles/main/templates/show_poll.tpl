{hook}before_poll_table{/hook}

<form method="post" action="index.php?page=vote&amp;start=1&amp;id={$Poll['id']}">

<table id="poll_table" align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
			{$lang['poll']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" width="60%" colspan="2">
			<strong>{$Poll['qus']}</strong>
		</td>
	</tr>
	{Des::foreach}{answers}{answer}
	<tr>
		<td class="row1 rows_space" width="60%">
			<input type="radio" name="answer" value="{$answer[0]}" id="answer{counter}"> <label for="answer{counter}">{$answer[0]}</label>
		</td>
		<td class="row1 rows_space" width="60%">
			{$answer[1]}
		</td>
	</tr>
	{/Des::foreach}
</table>

<br />

<div align="center">
	<input name="insert" type="submit" value="{$lang['common']['submit']}" />
</div>

<br />

</form>

{hook}after_poll_table{/hook}
