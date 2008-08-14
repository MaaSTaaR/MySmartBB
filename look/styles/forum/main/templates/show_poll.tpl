<form method="post" action="index.php?page=vote&amp;start=1&amp;id={$Poll['id']}">

<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
			التصويت
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
			<input type="radio" name="answer" value="{$answer}" id="answer{counter}"> <label for="answer{counter}">{$answer}</label>
		</td>
		<td class="row1 rows_space" width="60%">
			{#1#}
		</td>
	</tr>
	{/Des::foreach}
</table>

<br />

<div align="center">
	<input name="insert" type="submit" value="موافق" />
</div>

<br />

</form>
