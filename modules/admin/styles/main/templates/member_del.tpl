<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['members']}</a> &raquo; {$lang['member_del_confirmation']} : {$Inf['username']}</div>

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
			<a href="admin.php?page=member_del&amp;start=1&amp;id={$Inf['id']}">{$lang['common']['yes']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['common']['no']}</a>
		</td>
	</tr>
</table>
