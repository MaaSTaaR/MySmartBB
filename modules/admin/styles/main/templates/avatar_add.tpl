<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=avatar&amp;control=1&amp;main=1">{$lang['avatars']}</a></div>

<br />

<form action="admin.php?page=avatar&amp;add=1&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
			{$lang['add_avatar']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['path']}
			</td>
			<td class="row1">
				<input type="text" name="path" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>
