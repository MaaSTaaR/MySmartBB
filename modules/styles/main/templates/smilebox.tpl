<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['common']['emoticons']}
		</td>
	</tr>
	<tr>
		<td class="row1">
			{DB::getInfo}{$smile_res}{$smile}
				<img src="{$smile['smile_path']}" OnClick="set_smile('{$smile['smile_path']}');" alt="{$smile['smile_path']}" border="0" />
			{/DB::getInfo}
			<br />
			<a class="small_text" href="JavaScript:OpenWindow('new.php?smile=1');">{$lang['common']['view_all_emoticons']}</a>
		</td>
	</tr>
</table>
