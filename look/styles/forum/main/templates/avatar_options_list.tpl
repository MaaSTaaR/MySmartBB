	<table align="center" border="1" width="80%" class="t_style_b">
		<tr align="center">
			<td width="80%" class="main1 rows_space">
				اختيار صوره من الموقع
			</td>
		</tr>
		<tr align="center">
			<td width="80%" class="row1">
			{Des::while}{AvatarList}
				<input name="avatar_list" type="radio" value="{$AvatarList['avatar_path']}" id="avatar{$AvatarList['id']}" />
				<label for="avatar{$AvatarList['id']}">
					<img border="0" alt="الصوره الشخصيه #{$AvatarList['id']}" src="{$AvatarList['avatar_path']}" />
				</label>
				<br />
			{/Des::while}
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		{$pager}
	</div>
