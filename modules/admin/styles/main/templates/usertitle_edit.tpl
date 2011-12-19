<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=usertitle&amp;control=1&amp;main=1">{$lang['usertitles']}</a> &raquo; {$lang['common']['edit']} : {$Inf['usertitle']}</div>

<br />

<form action="admin.php?page=usertitle&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['edit_usertitle']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['usertitle']}
			</td>
			<td class="row1">
				<input type="text" name="title" value="{$Inf['usertitle']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['posts_number']}
			</td>
			<td class="row2">
				<input type="text" name="posts" value="{$Inf['posts']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>

