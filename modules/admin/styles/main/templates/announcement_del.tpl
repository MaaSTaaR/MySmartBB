<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=announcement&amp;control=1&amp;main=1">{$lang['announcements']}</a> &raquo; {$lang['common']['delete']} : {$AnnInfo['title']}</div>

<br />

<table width="50%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['common']['delete_confirm']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2">
		{$lang['common']['are_you_sure_delete']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1">
			<a href="admin.php?page=announcement&amp;del=1&amp;start=1&amp;id={$AnnInfo['id']}">{$lang['common']['yes']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=announcement&amp;control=1&amp;main=1">{$lang['common']['no']}</a>
		</td>
	</tr>
</table>
