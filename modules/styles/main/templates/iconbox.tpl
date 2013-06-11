{hook}before_icon_box_table{/hook}

<table id="icon_box_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space">
		{$lang['common']['icons']}
		</td>
	</tr>
	<tr>
		<td class="row1">
			<input type="radio" value="{$_CONF['info_row']['icon_path']}i1.gif" checked="checked" name="icon" id="fp0" />
			<label for="fp0">{$lang['common']['no_icon']}</label>
        
			{DB::getInfo}{$icon_res}{$icon}
				<input type="radio" value="{$icon['smile_path']}" name="icon" id="fp{$icon['id']}" />

				<label for="fp{$icon['id']}">
					<img src="{$bb_path}
					{$icon['smile_path']}" alt="{$bb_path}
					{$icon['smile_path']}" border="0" />
				</label>
			{/DB::getInfo}
		</td>
	</tr>
</table>

{hook}after_icon_box_table{/hook}
