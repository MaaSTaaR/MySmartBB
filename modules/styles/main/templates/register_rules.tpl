{template}address_bar_part1{/template}
{$lang['register_rules']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<table id="register_rules_table" border="1" class="t_style_b" width="70%" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="70%" colspan="2">
			{$lang['register_rules']}
		</td>
	</tr>
	<tr>
		<td class="row1" width="70%" colspan="2">
		{$_CONF['info_row']['register_rules']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="35%">
			<a href="{$init_path}register/agree">{$lang['agree']}</a>
		</td>
		<td class="row1" width="35%">
			<a href="index.php">{$lang['not_agree']}</a>
		</td>
	</tr>
</table>

{hook}after_register_rules_table{/hook}
