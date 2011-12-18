<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=extension&amp;search=1&amp;main=1">{$lang['attachments']}</a> &raquo; {$lang['search_attachments']} </div>

<br />

<form action="admin.php?page=extension&amp;search=1&amp;start=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['search_attachments']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['keyword']}
			</td>
			<td class="row1">
				<input type="text" name="keyword" id="input_keyword" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['search_by']}
			</td>
			<td class="row2">
				<select name="search_by" id="select_search_by">
					<option value="filename">{$lang['filename']}</option>
					<option value="filesize">{$lang['filesize']}</option>
					<option value="visitor">{$lang['downloads']}</option>
				</select>
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
</form>
