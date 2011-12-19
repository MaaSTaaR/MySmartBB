<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;general=1&amp;main=1">{$lang['general_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;general=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b rows_spaces" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">{$lang['general_options']}</td>
		</tr>
		<tr>
			<td class="row1">{$lang['board_title']}</td>
			<td class="row1">
				<input type="text" name="title" value="{$_CONF['info_row']['title']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">{$lang['send_email_address']}</td>
			<td class="row2">
				<input type="text" name="send_email" value="{$_CONF['info_row']['send_email']}" />
			</td>
		</tr>
		<tr>
			<td class="row1">{$lang['receive_email_address']}</td>
			<td class="row1">
				<input type="text" name="admin_email" value="{$_CONF['info_row']['admin_email']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
</form>
