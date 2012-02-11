{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">
{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$plugin_lang['add_new_post']}
{template}address_bar_part2{/template}

<br />

<form method="post" action="index.php?page=plugin&amp;name=MySmartMicroblog&amp;action=add&amp;start=1">
<table border="1" class="t_style_b" width="30%" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		{$plugin_lang['add_new_post']}
		</td>
	</tr>
	<tr>
		<td class="row1" align="center">
			<input type="text" name="context" />
		</td>
	</tr>
</table>
<br />
<div align="center">
<input name="register_button" type="submit" value="{$lang['common']['submit']}" />
</div>
</form>
<br />
</div>
