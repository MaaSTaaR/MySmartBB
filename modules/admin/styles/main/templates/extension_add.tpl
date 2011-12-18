<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=extension&amp;control=1&amp;main=1">{$lang['extensions']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=extension&amp;add=1&amp;start=1" method="post">
	<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
		<tr valign="top" align="center">
			<td class="main1" colspan="2">
			{$lang['add_extension']}
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['extension']}
			</td>
			<td class="row1">
				<input type="text" name="extension" />
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			{$lang['max_size']} ({$lang['kilobyte']})
			</td>
			<td class="row2">
				<input type="text" name="max_size" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['mime']}
			</td>
			<td class="row2">
				<input type="text" name="mime_type" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>
