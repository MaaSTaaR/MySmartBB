<form method="post" action="index.php?page=management&amp;repeat=1&amp;subject_id={$subject}">
<table align="center" border="1" class="t_style_b" width="40%">
	<tr align="center">
		<td class="main1 rows_space" width="20%" colspan="2">
			{$lang['repeated_subject']}
		</td>
	</tr>
	<tr>
		<td class="row1 rows_space" width="20%">
			{$lang['repeated_subject_link']}
		</td>
		<td class="row2 rows_space" width="20%">
			<input name="url" type="text" />
		</td>
	</tr>
</table>

<br />

<div align="center">
	<input type="submit" value="{$lang['common']['submit']}" />
</div>

</form>
