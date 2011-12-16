<form action="admin.php?page=login&amp;login=1" method="post">
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
			{$lang['common']['login']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['common']['username']}
			</td>
			<td class="row1">
				<input type="text" name="username" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['common']['password']}
			</td>
			<td class="row2">
				<input type="password" name="password" />
			</td>
		</tr>
	</table>
		
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>

</form>
