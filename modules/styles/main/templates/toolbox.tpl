{hook}before_toolbox_table{/hook}

<table id="toolbox_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['common']['toolbox']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['bold']}" OnClick="code(1)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['italic']}" OnClick="code(2)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['underline']}" OnClick="code(3)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['url']}" OnClick="code(4)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['image']}" OnClick="code(5)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['code']}" OnClick="code(6)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="{$lang['common']['quote']}" OnClick="code(7)" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="7">
			<select name="FontsList" OnChange="Fonts();" size="1">
				<option selected="selected" value="0">{$lang['common']['font']}</option>
				{DB::getInfo}{$font_res}{$font}
				<option value="{$font['name']}">{$font['name']}</option>
				{/DB::getInfo}
			</select>
			-
			<select name="SizesList" OnChange="Sizes();" size="1">
        		<option selected="selected" value="0">{$lang['common']['size']}</option>
        		<option value="7">{$lang['common']['too_small']}</option>
        		<option value="10">{$lang['common']['small']}</option>
        		<option value="14">{$lang['common']['medium']}</option>
        		<option value="20">{$lang['common']['large']}</option>
        		<option value="25">{$lang['common']['too_large']}</option>
        	</select>
        	-
        	<select name="ColorsList" OnChange="Colors();" size="1" />
        		<option selected="selected" value="0">{$lang['common']['color']}</option>
        		{DB::getInfo}{$color_res}{$color}
        			<option style="color: {$color['name']}" value="{$color['name']}">{$color['name']}</option>
        		{/DB::getInfo}
        	</select>
		</td>
	</tr>
</table>

{hook}after_toolbox_table{/hook}        
