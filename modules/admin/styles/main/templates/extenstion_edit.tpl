<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=extension&amp;control=1&amp;main=1">{$lang['extensions']}</a> &raquo; {$lang['common']['edit']} : {$Inf['Ex']}</div>

<br />

<form action="admin.php?page=extension&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['edit_extension']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['extension']}
			</td>
			<td class="row1">
				<input type="text" name="extension" value="{$Inf['Ex']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['max_size']} ({$lang['kilobyte']})
			</td>
			<td class="row2">
				<input type="text" name="max_size" value="{$Inf['max_size']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['mime']}
			</td>
			<td class="row2">
				<input type="text" name="mime_type" value="{$Inf['mime_type']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>
