{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">
{template}address_bar_part1{/template}
<a href="index.php?page=pm_list&amp;list=1&amp;folder=inbox">{$lang['pm']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['pm_setting']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<form name="info" method="post" action="index.php?page=pm_setting&amp;setting=1&amp;start=1">

	<table id="pm_setting_table" align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			{$lang['message_to_sender']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="40%">
			{$lang['message_to_sender_option']}
			</td>
			<td class="row1" width="20%">
				<select name="pm_senders" size="1">
					{if {$_CONF['member_row']['pm_senders']}}
					<option selected="selected" value="1">{$lang['yes']}</option>
					<option value="0">{$lang['no']}</option>
					{else}
					<option value="1">{$lang['yes']}</option>
					<option selected="selected" value="0">{$lang['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="60%" colspan="2">
				{$lang['message']} {$lang['common']['colon']} <input name="pm_senders_msg" type="text" value="{$_CONF['member_row']['pm_senders_msg']}" size="40" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<table align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			{$lang['auto_reply']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			{$lang['auto_reply_option']}
			</td>
			<td class="row1" width="30%">
				<select name="autoreply" size="1">
					{if {$_CONF['member_row']['autoreply']}}
					<option selected="selected" value="1">{$lang['yes']}</option>
					<option value="0">{$lang['no']}</option>
					{else}
					<option value="1">{$lang['yes']}</option>
					<option selected="selected" value="0">{$lang['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="60%" colspan="2">
				{$lang['message_title']} {$lang['common']['colon']} <input name="title" type="text" value="{$_CONF['member_row']['autoreply_title']}" />
				<br /><br />
				<textarea name="msg" rows="5" cols="40">{$_CONF['member_row']['autoreply_msg']}</textarea>
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="60%" colspan="2">
				{$lang['auto_reply_state']} {$lang['common']['colon']}
			{if {$_CONF['member_row']['autoreply']}}
			<strong>{$lang['work']}</strong>
			{else}
			<strong>{$lang['doesnt_work']}</strong>
			{/if}
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input name="send" type="submit" value="{$lang['common']['submit']}" />
	</div>

</div>
<br />

{hook}after_pm_setting_table{/hook}
