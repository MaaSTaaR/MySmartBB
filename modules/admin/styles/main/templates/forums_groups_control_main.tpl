<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">{$lang['forums']}</a> &raquo; {$lang['control_forum_permission']} : {$Inf['title']}</div>

<br />

<form action="admin.php?page=forums_groups&amp;start=1&amp;id={$Inf['id']}" method="post">

	{DB::getInfo}{$SecGroupList}
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr valign="top" align="center">
			<td class="main1" colspan="2">
				<strong>{$SecGroupList['group_name']}</strong>
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['view_forum']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][view_section]" id="select_view_section">
					{if {$SecGroupList['view_section']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			{$lang['download_attachments']}
			</td>
			<td class="row2">
				<select name="groups[{$SecGroupList['group_id']}][download_attach]" id="select_download_attach">
					{if {$SecGroupList['download_attach']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['upload_attachments']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][upload_attach]" id="select_upload_attach">
					{if {$SecGroupList['upload_attach']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			{$lang['write_topic']}
			</td>
			<td class="row2">
				<select name="groups[{$SecGroupList['group_id']}][write_subject]" id="select_write_subject">
					{if {$SecGroupList['write_subject']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['write_reply']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][write_reply]" id="select_write_reply">
					{if {$SecGroupList['write_reply']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			{$lang['edit_own_topic']}
			</td>
			<td class="row2">
				<select name="groups[{$SecGroupList['group_id']}][edit_own_subject]" id="select_edit_own_subject">
					{if {$SecGroupList['edit_own_subject']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['edit_own_reply']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][edit_own_reply]" id="select_edit_own_reply">
					{if {$SecGroupList['edit_own_reply']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			{$lang['delete_own_topic']}
			</td>
			<td class="row2">
				<select name="groups[{$SecGroupList['group_id']}][del_own_subject]" id="select_del_own_subject">
					{if {$SecGroupList['del_own_subject']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['delete_own_reply']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][del_own_reply]" id="select_del_own_reply">
					{if {$SecGroupList['del_own_reply']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row2">
			{$lang['write_poll']}
			</td>
			<td class="row2">
				<select name="groups[{$SecGroupList['group_id']}][write_poll]" id="select_write_poll">
					{if {$SecGroupList['write_poll']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>	
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['vote_poll']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][vote_poll]" id="select_vote_poll">
					{if {$SecGroupList['vote_poll']}}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
					{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="0" selected="selected">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			{$lang['count_posts_number']}
			</td>
			<td class="row1">
				<select name="groups[{$SecGroupList['group_id']}][no_posts]" id="select_no_posts">
					{if {$SecGroupList['no_posts']}}
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
	{/DB::getInfo}

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>
