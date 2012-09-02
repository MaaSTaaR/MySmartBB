<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=ads&amp;control=1&amp;main=1">{$lang['ads']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=ads&amp;add=1&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
			{$lang['add_ad']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['site_name']}
			</td>
			<td class="row1">
				<input type="text" name="name" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['link']}
			</td>
			<td class="row2">
				<input type="text" name="link" dir="ltr" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['image_url']}
			</td>
			<td class="row1">
				<input type="text" name="picture" dir="ltr" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['height']}
			</td>
			<td class="row2">
				<input type="text" name="width" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['width']}
			</td>
			<td class="row1">
				<input type="text" name="height" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
</form>
