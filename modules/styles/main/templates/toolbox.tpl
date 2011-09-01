<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		صندوق الادوات
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			<input type="button" value="عريض" OnClick="code(1)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="مائل" OnClick="code(2)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="تحته خط" OnClick="code(3)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="موقع" OnClick="code(4)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="صوره" OnClick="code(5)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="شيفره" OnClick="code(6)" />
		</td>
		<td class="row1 rows_space">
			<input type="button" value="اقتباس" OnClick="code(7)" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="7">
			<select name="FontsList" OnChange="Fonts();" size="1">
				<option selected="selected" value="0">[الخط]</option>
				{DB::getInfo}{$font_res}{$font}
				<option value="{$font['name']}">{$font['name']}</option>
				{/DB::getInfo}
			</select>
			-
			<select name="SizesList" OnChange="Sizes();" size="1">
        		<option selected="selected" value="0">[الحجم]</option>
        		<option value="7">صغير جداً</option>
        		<option value="10">صغير</option>
        		<option value="14">متوسط</option>
        		<option value="20">كبير</option>
        		<option value="25">كبير جداً</option>
        	</select>
        	-
        	<select name="ColorsList" OnChange="Colors();" size="1" />
        		<option selected="selected" value="0">[اللون]</option>
        		{DB::getInfo}{$color_res}{$color}
        			<option style="color: {$color['name']}" value="{$color['name']}">{$color['name']}</option>
        		{/DB::getInfo}
        	</select>
		</td>
	</tr>
</table>

	
        

        
