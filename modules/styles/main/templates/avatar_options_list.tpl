	<table align="center" border="1" width="80%" class="t_style_b">
		<tr align="center">
			<td width="80%" class="main1 rows_space">
				{$lang['avatar_from_list']}
			</td>
		</tr>
		<tr align="center">
			<td width="80%" class="row1">
			{DB::getInfo}{$avatar_res}{$avatar}
				<input name="avatar_list" type="radio" value="{$avatar['avatar_path']}" id="avatar{$avatar['id']}" />
				<label for="avatar{$AvatarList['id']}">
					<img border="0" alt="{$lang['avatar']} #{$avatar['id']}" src="{$avatar['avatar_path']}" />
				</label>
				<br />
			{/DB::getInfo}
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		{$pager}
	</div>
