	<table id="avatar_site_table" align="center" border="1" width="80%" class="t_style_b">
		<tr align="center">
			<td width="80%" class="main1 rows_space" colspan="2">
				{$lang['avatar_from_website']}
			</td>
		</tr>
		<tr align="center">
			<td width="40%" class="row1">
				{$lang['image_url']}
			</td>
			<td width="40%" class="row1">
				<input name="avatar" dir="ltr" value="http://" />
			</td>
		</tr>
		<tr align="center">
			<td colspan="2" class="row1">{$lang['max_size_avatar']}
			{$_CONF['info_row']['max_avatar_width']}x{$_CONF['info_row']['max_avatar_height']}</td>
		</tr>
	</table>

{hook}after_avatar_site_table{/hook}
