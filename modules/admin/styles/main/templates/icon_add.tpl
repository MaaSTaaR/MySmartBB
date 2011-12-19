<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=icon&amp;control=1&amp;main=1">{$lang['icons']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=icon&amp;add=1&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['add_icon']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['icon_path']}
			</td>
			<td class="row1">
				<input type="text" name="path" id="input_path" value="look/images/icons/" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
</form>
