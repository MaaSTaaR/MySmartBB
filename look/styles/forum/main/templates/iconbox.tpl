<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space">
		الايقونات
		</td>
	</tr>
	<tr>
		<td class="row1">
			<input type="radio" value="{$_CONF['info_row']['icon_path']}i1.gif" checked="checked" name="icon" id="fp1" />
			<label for="fp1">بدون أيقونه</label>
        			{Des::while}{IconRows}
				<input type="radio" value="{$IconRows['smile_path']}" name="icon" id="fp{$IconRows['id']}" />

				<label for="fp{$IconRows['id']}">
					<img src="{$IconRows['smile_path']}" alt="{$IconRows['smile_path']}" border="0" />
				</label>			{/Des::while}
		</td>
	</tr>
</table>
