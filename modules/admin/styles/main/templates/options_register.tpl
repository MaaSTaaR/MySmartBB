<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;register=1&amp;main=1">{$lang['register_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;register=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">{$lang['register_options']}</td>
		</tr>
		<tr>
			<td class="row1">{$lang['close_register']}</td>
			<td class="row1">
				<select name="reg_close">
					{if {$_CONF['info_row']['reg_close']}}
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
			<td class="row2">{$lang['default_group']}</td>
			<td class="row2">
				<select name="def_group">
					{Des::foreach}{groups}{group}
					{if {$_CONF['info_row']['def_group']} == {$group['id']}}
					<option value="{$group['id']}" selected="selected">{$group['title']}</option>
					{else}
					<option value="{$group['id']}">{$group['title']}</option>
					{/if}
					{/Des::foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">{$lang['default_activate_group']}</td>
			<td class="row1">
				<select name="adef_group" id="select_adef_group">
					{Des::foreach}{groups}{group}
					{if {$_CONF['info_row']['adef_group']} == {$group['id']}}
					<option value="{$group['id']}" selected="selected">{$group['title']}</option>
					{else}
					<option value="{$group['id']}">{$group['title']}</option>
					{/if}
					{/Des::foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">{$lang['activate_register_rules']}</td>
			<td class="row2">
				<select name="reg_o" id="select_reg_o">
					{if {$_CONF['info_row']['reg_o']}}
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
			<td class="row1">{$lang['min_length_username']}</td>
			<td class="row1">
				<input type="text" name="reg_less_num" value="{$_CONF['info_row']['reg_less_num']}" size="30" />&nbsp;
			</td>
		</tr>
		<tr>
			<td class="row2">{$lang['max_length_username']}</td>
			<td class="row2">
				<input type="text" name="reg_max_num" value="{$_CONF['info_row']['reg_max_num']}" size="30" />&nbsp;
			</td>
		</tr>
		<tr>
			<td class="row1">{$lang['min_length_password']}</td>
			<td class="row1">
				<input type="text" name="reg_pass_min_num" value="{$_CONF['info_row']['reg_pass_min_num']}" size="30" />&nbsp;
			</td>
		</tr>
		<tr>
			<td class="row2">{$lang['max_length_password']}</td>
			<td class="row2">
				<input type="text" name="reg_pass_max_num" value="{$_CONF['info_row']['reg_pass_max_num']}" size="30" />&nbsp;
			</td>
		</tr>
	</table>
	
	<br />
	
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">{$lang['register_rules_options']}</td>
		</tr>
		<tr>
			<td class="row1">{$lang['activate_register_rules']}</td>
			<td class="row1">
				<select name="reg_o" id="select_reg_o">
					{if {$_CONF['info_row']['reg_o']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2" class="main2">{$lang['register_rules']}</td>
		</tr>
		<tr>
			<td colspan="2" class="row2">
				<textarea name="register_rules" cols="117" rows="10">{$_CONF['info_row']['register_rules']}</textarea>
			</td>
		</tr>
	</table>
	
	<br />

	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">{$lang['allowed_visit_days']}</td>
		</tr>
		<tr>
			<td class="row1">{$lang['sat']}</td>
			<td class="row1">
				<select name="Sat" id="select_Sat">
					{if {$_CONF['info_row']['reg_Sat']}}
					<option value="1" selected="selected">{$lang['common']['allowed']}</option>
					<option value="0">{$lang['common']['not_allowed']}</option>
					{else}
					<option value="1">{$lang['common']['allowed']}</option>
					<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
					{/if}
				</select>
			</td>
			</tr>
			<tr>
				<td class="row2">{$lang['sun']}</td>
				<td class="row2">
					<select name="Sun">
						{if {$_CONF['info_row']['reg_Sun']}}
						<option value="1" selected="selected">{$lang['common']['allowed']}</option>
						<option value="0">{$lang['common']['not_allowed']}</option>
						{else}
						<option value="1">{$lang['common']['allowed']}</option>
						<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
						{/if}
					</select>
				</td>
			</tr>
			<tr>
				<td class="row1">{$lang['mon']}</td>
				<td class="row1">
					<select name="Mon">
						{if {$_CONF['info_row']['reg_Mon']}}
						<option value="1" selected="selected">{$lang['common']['allowed']}</option>
						<option value="0">{$lang['common']['not_allowed']}</option>
						{else}
						<option value="1">{$lang['common']['allowed']}</option>
						<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
						{/if}
					</select>
				</td>
			</tr>
			<tr>
				<td class="row2">{$lang['tue']}</td>
				<td class="row2">
					<select name="Tue">
						{if {$_CONF['info_row']['reg_Tue']}}
						<option value="1" selected="selected">{$lang['common']['allowed']}</option>
						<option value="0">{$lang['common']['not_allowed']}</option>
						{else}
						<option value="1">{$lang['common']['allowed']}</option>
						<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
						{/if}
					</select>
				</td>
			</tr>
			<tr>
				<td class="row1">{$lang['wed']}</td>
				<td class="row1">
					<select name="Wed">
						{if {$_CONF['info_row']['reg_Wed']}}
						<option value="1" selected="selected">{$lang['common']['allowed']}</option>
						<option value="0">{$lang['common']['not_allowed']}</option>
						{else}
						<option value="1">{$lang['common']['allowed']}</option>
						<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
						{/if}
					</select>
				</td>
			</tr>
			<tr>
				<td class="row2">{$lang['thu']}</td>
				<td class="row2">
					<select name="Thu">
						{if {$_CONF['info_row']['reg_Thu']}}
						<option value="1" selected="selected">{$lang['common']['allowed']}</option>
						<option value="0">{$lang['common']['not_allowed']}</option>
						{else}
						<option value="1">{$lang['common']['allowed']}</option>
						<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
						{/if}
					</select>
				</td>
			</tr>
			<tr>
				<td class="row1">{$lang['fri']}</td>
				<td class="row1">
					<select name="Fri">
						{if {$_CONF['info_row']['reg_Fri']}}
						<option value="1" selected="selected">{$lang['common']['allowed']}</option>
						<option value="0">{$lang['common']['not_allowed']}</option>
						{else}
						<option value="1">{$lang['common']['allowed']}</option>
						<option value="0" selected="selected">{$lang['common']['not_allowed']}</option>
						{/if}
					</select>
				</td>
			</tr>
		</table>
		
		<br />
		
		<div align="center">
			<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" />
		</div>
</form>
