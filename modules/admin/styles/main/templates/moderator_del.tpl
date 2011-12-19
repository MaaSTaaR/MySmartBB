<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; 
<a href="admin.php?page=moderators&amp;control=1&amp;main=1">{$lang['moderators']}</a> 
&raquo; <a href="admin.php?page=moderators&amp;control=1&amp;section=1&amp;id={$Section['id']}">{$Section['title']}</a> &raquo; 
{$lang['cancel']} : {$Inf['username']}</div>

<br />

<table width="50%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['confirm_cancel_moderator']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2">
		{$lang['are_you_sure']} {$Inf['username']}؟
		</td>
	</tr>
	<tr align="center">
		<td class="row1">
			<a href="admin.php?page=moderators&amp;del=1&amp;start=1&amp;id={$Inf['id']}">{$lang['common']['yes']}</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=moderators&amp;control=1&amp;main=1">{$lang['common']['no']}</a>
		</td>
	</tr>
</table>
