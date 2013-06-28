<script src="{$bb_path}includes/js/jquery.js"></script>
<script src="{$bb_path}includes/js/3rdparty/easytabs/jquery.easytabs.min.js"></script>

<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">{$lang['forums']}</a> &raquo; {$lang['control_forum_permission']} : {$Inf['title']}</div>

<br />

<form action="admin.php?page=forums_groups&amp;start=1&amp;id={$Inf['id']}" method="post">
<div id="topic_management_dialog" class="tab-container" style="">
	{hook}before_management_tabs{/hook}
	<ul class='etabs' id="management_tabs">
		{Des::foreach}{groups}{group}
		<li class='tab'><a href="#{$group['id']}">{$group['group_name']}</a></li>
		{/Des::foreach}
	</ul>
	<div class='panel-container' id="management_panal">
		{Des::foreach}{groups}{group}
		<div id="{$group['id']}">
		<table width="60%" class="t_style_b" border="1" align="center">
		<tr>
			<td class="row1">
			{$lang['view_forum']}
			</td>
			<td class="row1">
				<select name="groups[{$group['group_id']}][view_section]" id="select_view_section">
					{if {$group['view_section']}}
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
			{$lang['download_attachments']}
			</td>
			<td class="row2">
				<select name="groups[{$group['group_id']}][download_attach]" id="select_download_attach">
					{if {$group['download_attach']}}
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
			{$lang['upload_attachments']}
			</td>
			<td class="row1">
				<select name="groups[{$group['group_id']}][upload_attach]" id="select_upload_attach">
					{if {$group['upload_attach']}}
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
			{$lang['write_topic']}
			</td>
			<td class="row2">
				<select name="groups[{$group['group_id']}][write_subject]" id="select_write_subject">
					{if {$group['write_subject']}}
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
			{$lang['write_reply']}
			</td>
			<td class="row1">
				<select name="groups[{$group['group_id']}][write_reply]" id="select_write_reply">
					{if {$group['write_reply']}}
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
			{$lang['edit_own_topic']}
			</td>
			<td class="row2">
				<select name="groups[{$group['group_id']}][edit_own_subject]" id="select_edit_own_subject">
					{if {$group['edit_own_subject']}}
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
			{$lang['edit_own_reply']}
			</td>
			<td class="row1">
				<select name="groups[{$group['group_id']}][edit_own_reply]" id="select_edit_own_reply">
					{if {$group['edit_own_reply']}}
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
			{$lang['delete_own_topic']}
			</td>
			<td class="row2">
				<select name="groups[{$group['group_id']}][del_own_subject]" id="select_del_own_subject">
					{if {$group['del_own_subject']}}
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
			{$lang['delete_own_reply']}
			</td>
			<td class="row1">
				<select name="groups[{$group['group_id']}][del_own_reply]" id="select_del_own_reply">
					{if {$group['del_own_reply']}}
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
			{$lang['write_poll']}
			</td>
			<td class="row2">
				<select name="groups[{$group['group_id']}][write_poll]" id="select_write_poll">
					{if {$group['write_poll']}}
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
			{$lang['vote_poll']}
			</td>
			<td class="row1">
				<select name="groups[{$group['group_id']}][vote_poll]" id="select_vote_poll">
					{if {$group['vote_poll']}}
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
			{$lang['count_posts_number']}
			</td>
			<td class="row2">
				<select name="groups[{$group['group_id']}][no_posts]" id="select_no_posts">
					{if {$group['no_posts']} == '1'}
					<option value="0">{$lang['common']['yes']}</option>
					<option value="1" selected="selected">{$lang['common']['no']}</option>
					{else}
					<option value="0" selected="selected">{$lang['common']['yes']}</option>
					<option value="1">{$lang['common']['no']}</option>
					{/if}
				</select>
			</td>
		</tr>
	</table>
	
	<br />
		</div>
		{/Des::foreach}
	</div>
</div>
	{Des::foreach}{groups}{group}

	{/Des::foreach}

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>

<script type="text/javascript">
$('.tab-container').easytabs( { "animate" : false } );
</script>