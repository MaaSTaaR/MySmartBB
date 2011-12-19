<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;feature=1&amp;main=1">{$lang['feature_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;features=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b rows_spaces" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">{$lang['feature_options']}</td>
				<tr>
			<td class="row2">{$lang['show_guests_online']}</td>
			<td class="row2">
				<select name="guest_online" id="select_guest_online">
					{if {$_CONF['info_row']['show_onlineguest']}}
						<option value="1" selected="selected">{$lang['common']['yes']}</option>
						<option value="0">{$lang['common']['no']}</option>
					{else}
						<option value="1">{$lang['common']['yes']}</option>
						<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
			<td class="row2">{$lang['show_section_description']}</td>
			<td class="row2">
				<select name="describe_feature" id="select_guest_online">
					{if {$_CONF['info_row']['describe_feature']}}
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
		{$lang['activate_pm']}
			</td>
			<td class="row2">
				<select name="pm_feature">
				{if {$_CONF['info_row']['pm_feature']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
				{/if}
				</select>
			</td>
		</tr>
	</table>

	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
</form>
