<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=groups&amp;control=1&amp;main=1">{$lang['groups']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=groups_add&amp;start=1" method="post">
	<table width="70%" class="t_style_b" border="1" align="center">
		<tr>
			<td class="main1 rows_space" colspan="2">
			{$lang['add_group']}
			</td>
		</tr>
		<tr>
			<td class="row1" width="50%">
			{$lang['group_title']}
			</td>
			<td class="row1" width="50%">
				<input type="text" name="name" />
			</td>
		</tr>
		<tr>
			<td class="row2" width="50%">
			{$lang['name_style']}
			</td>
			<td class="row2" width="50%">
				<input type="text" dir="ltr" value="[username]" name="style" />
			</td>
		</tr>
		<tr>
			<td class="row1" width="50%">
			{$lang['usertitle']}
			</td>
			<td class="row1" width="50%">
				<input type="text" name="usertitle" />
			</td>
		</tr>
		<tr>
			<td class="row2" width="50%">
			{$lang['sort']}
			</td>
			<td class="row2" width="50%">
				<input name="group_order" type="text" size="9" />
			</td>
		</tr>
		<tr>
			<td class="row1" width="50%">
			{$lang['show_in_teamwork']}
			</td>
			<td class="row1" width="50%">
				<select size="1" name="forum_team">
					<option selected="selected" value="1">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2" width="50%">
			{$lang['banned_group']}
			</td>
			<td class="row2" width="50%">
				<select size="1" name="banned">
					<option selected="selected" value="1">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="main1 rows_space" colspan="2">
			{$lang['sections_setting']}
			</td>
		</tr>
		<tr>
			<td class="row1" width="50%">
			{$lang['view_section']}
			</td>
			<td class="row1" width="50%">
				<select size="1" name="view_section">
					<option selected="selected" value="1">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2" width="50%">
			{$lang['download_attachments']}
			</td>
			<td class="row2" width="50%">
		 		<select size="1" name="download_attach">
					<option selected="selected" value="1">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
		 		</select>
			</td>
		</tr>
		<tr>
			<td class="row1" width="50%">
			{$lang['post_number_to_download']}
			</td>
			<td class="row1" width="50%">
				<input name="download_attach_number" type="text" value="0" size="5" />
			</td>
		</tr>
		<tr>
			<td class="row2" width="50%">
			{$lang['upload_attachments']}
			</td>
			<td class="row2" width="50%">
				<select size="1" name="upload_attach">
					<option selected="selected" value="1">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1" width="50%">
			{$lang['attachments_limit']}
			</td>
			<td class="row1" width="50%">
				<input name="upload_attach_num" type="text" value="0" size="5">
			</td>
		</tr>
		<tr>
			<td class="row2" width="50%">
			{$lang['write_topic']}
			</td>
			<td class="row2" width="50%">
				<select size="1" name="write_subject">
					<option selected="selected" value="1">{$lang['common']['yes']}</option>
					<option value="0">{$lang['common']['no']}</option>
				</select>
			</td>

		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['write_reply']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="write_reply">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['edit_own_topic']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="edit_own_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['edit_own_reply']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="edit_own_reply">

		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['delete_own_topic']}</td>

		<td class="row2" width="50%">
		 <select size="1" name="del_own_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['delete_own_reply']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="del_own_reply">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['write_poll']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="write_poll">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['vote_poll']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="vote_poll">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="main1 rows_space" colspan="2">{$lang['pm_settings']}</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['use_pm_feature']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="use_pm">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['send_pm']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="send_pm">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['receive_pm']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="resive_pm">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['inbox_size']}</td>
		<td class="row2" width="50%"><input type="text" name="max_pm" value="70" size="5"></td>
		</tr>

		<tr>
		<td class="row1" width="50%">{$lang['posts_number_to_pm']}</td>
		<td class="row1" width="50%"><input type="text" name="min_send_pm" value="0" size="5"></td>
		</tr>
		<tr>
		<td class="main1 rows_space" colspan="2">{$lang['signature_settings']}</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['use_signature']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="sig_allow">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['signature_length']}</td>
		<td class="row2" width="50%"><input type="text" name="sig_len" value="1000" size="5"></td>
		</tr>

		<tr>
		<td class="main1 rows_space" colspan="2">{$lang['moderate_setting']}</td>

		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['moderaters_group']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="group_mod">
		  <option value="1">{$lang['common']['yes']}</option>
		  <option selected="selected" value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['supervisor_group']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="group_vice">
		  <option value="1">{$lang['common']['yes']}</option>

		  <option selected="selected" value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_edit_topics']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="edit_subject">

		  <option value="1">{$lang['common']['yes']}</option>
		  <option selected="selected" value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_edit_replies']}</td>

		<td class="row2" width="50%">
		 <select size="1" name="edit_reply">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['can_delete_topics']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="del_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_delete_replies']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="del_reply">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_stick_topics']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="stick_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_unstick_topics']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="unstick_subject">

		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_move_topics']}</td>

		<td class="row1" width="50%">
		 <select size="1" name="move_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row2" width="50%">{$lang['can_close_topics']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="close_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="main1 rows_space" colspan="2">{$lang['admin_setting']}</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_use_admin_cp']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_allow">

		  <option value="1">{$lang['common']['yes']}</option>
		  <option selected="selected" value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>

		<tr>
		<td class="row2" width="50%">{$lang['can_control_sections']}</td>

		<td class="row2" width="50%">
		 <select size="1" name="admincp_section">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['can_control_options']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_option">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_members']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_member">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_control_groups']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_membergroup">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_usertitles']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_membertitle">

		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>

		<tr>
		<td class="row1" width="50%">{$lang['can_control_moderators']}</td>

		<td class="row1" width="50%">
		 <select size="1" name="admincp_admin">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_control_topics']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_subject">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_ads']}</td>

		<td class="row2" width="50%">
		 <select size="1" name="admincp_ads">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['can_control_templates']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_template">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_announcements']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_adminads">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_control_attachments']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_attach">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_pages']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_page">

		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_control_banned']}</td>

		<td class="row1" width="50%">
		 <select size="1" name="admincp_block">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row2" width="50%">{$lang['can_control_styles']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_style">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_control_toolbox']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_toolbox">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_smiles']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_smile">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_control_icons']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="admincp_icon">

		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_control_avatars']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="admincp_avater">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		
		<tr>
		<td class="main1 rows_space" colspan="2">{$lang['other']}</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['can_use_search']}</td>
		<td class="row1" width="50%">

		 <select size="1" name="search_allow">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_view_memberlist']}</td>

		<td class="row2" width="50%">
		 <select size="1" name="memberlist_allow">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>

		<td class="row1" width="50%">{$lang['can_see_hidden_members']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="show_hidden">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>

		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['show_group_title']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="view_usernamestyle">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>

		 </select>
		</td>
		</tr>
		<tr>
		<td class="row1" width="50%">{$lang['usertitle_change_post_count']}</td>
		<td class="row1" width="50%">
		 <select size="1" name="usertitle_change">
		  <option selected="selected" value="1">{$lang['common']['yes']}</option>

		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
		<tr>
		<td class="row2" width="50%">{$lang['can_view_online']}</td>
		<td class="row2" width="50%">
		 <select size="1" name="onlinepage_allow">

		  <option selected="selected" value="1">{$lang['common']['yes']}</option>
		  <option value="0">{$lang['common']['no']}</option>
		 </select>
		</td>
		</tr>
    </table>

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
</form>
