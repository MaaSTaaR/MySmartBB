<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=avatar&amp;control=1&amp;main=1">{$lang['avatars']}</a> &raquo; {$lang['common']['edit']} : {$Inf['avatar_path']}</div>

<br />

<form action="admin.php?page=avatar&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['edit_avatar']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['path']}
			</td>
			<td class="row1">
				<input type="text" name="path" value="{$Inf['avatar_path']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>

	<br />

</form>
