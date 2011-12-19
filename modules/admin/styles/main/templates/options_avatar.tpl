<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;avatar=1&amp;main=1">{$lang['avatar_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;avatar=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['avatar_options']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['activate_avatar']}
			</td>
			<td class="row1">
				<select name="allow_avatar">
				{if {$_CONF['info_row']['allow_avatar']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['allow_avatar_upload']}
			</td>
			<td class="row2">
				<select name="upload_avatar">
				{if {$_CONF['info_row']['upload_avatar']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['avatar_width']}
			</td>
			<td class="row1">
				<input type="text" name="max_avatar_width" value="{$_CONF['info_row']['max_avatar_width']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['avatar_height']}
			</td>
			<td class="row2">
				<input type="text" name="max_avatar_height" value="{$_CONF['info_row']['max_avatar_height']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['default_avatar']}
			</td>
			<td class="row2">
				<input type="text" name="default_avatar" value="{$_CONF['info_row']['default_avatar']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
</form>
