<form method="post" action="index.php?page=management&amp;delete=1&amp;subject_id={$subject}&amp;section={$section}">


<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
			{$lang['delete_subject']}
		</td>
	</tr>
	<tr>
		<td class="row1 rows_space" width="30%">
			{$lang['delete_subject_reason']}
		</td>
		<td class="row2 rows_space" width="30%">
			<input name="reason" type="text" />
		</td>
	</tr>
</table>

<br />

<div align="center">
	<input type="submit" value="{$lang['common']['submit']}" />
</div>

</form>
