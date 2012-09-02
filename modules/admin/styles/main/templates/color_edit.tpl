<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=toolbox&amp;colors=1&amp;control=1&amp;main=1">{$lang['colors']}</a> &raquo; {$lang['common']['edit']} : {$Inf['name']}</div>

<br />

<form action="admin.php?page=toolbox&amp;colors=1&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['edit_color']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['color_code']}
			</td>
			<td class="row1">
				<input type="text" name="name" value="{$Inf['name']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
</form>
