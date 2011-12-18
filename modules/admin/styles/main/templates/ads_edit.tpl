<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=ads&amp;control=1&amp;main=1">{$lang['ads']}</a> &raquo; {$lang['common']['edit']} : {$Inf['sitename']}</div>

<br />

<form action="admin.php?page=ads&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b rows_space" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['add_ad']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['site_name']}
			</td>
			<td class="row1">
				<input type="text" name="name" value="{$Inf['sitename']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['link']}
			</td>
			<td class="row2">
				<input type="text" name="link" value="{$Inf['site']}" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['image_url']}
			</td>
			<td class="row1">
				<input type="text" name="picture" value="{$Inf['picture']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['height']}
			</td>
			<td class="row2">
				<input type="text" name="width" value="{$Inf['width']}" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['width']}
			</td>
			<td class="row1">
				<input type="text" name="height" value="{$Inf['height']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />

</form>
