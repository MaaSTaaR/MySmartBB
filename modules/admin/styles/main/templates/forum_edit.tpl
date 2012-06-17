<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">{$lang['forums']}</a> &raquo; {$lang['common']['edit']} : {$Inf['title']}</div>

<br />

<form action="admin.php?page=forums_edit&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['basic_info']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			{$lang['forum_title']}
			</td>
			<td class="row1">
				<input type="text" name="name" value="{$Inf['title']}" size="30" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2">
			{$lang['sort']}
			</td>
			<td class="row2">
				<input type="text" name="sort" value="{$Inf['sort']}" size="5" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2">
			{$lang['position']}
			</td>
			<td class="row2">
				<select name="parent" id="select_parent">
				{Des::foreach}{forums_list}{forum}
					{if {$forum['parent']} == 0}
					{if {$forum['id']} == {$Inf['parent']}}
					<option value="{$forum['id']}" class="main_section" selected="selected">- {$forum['title']}</option>
					{else}
					<option value="{$forum['id']}" class="main_section">- {$forum['title']}</option>
					{/if}
					{else}
					{if {$forum['id']} == {$Inf['parent']}}
					<option value="{$forum['id']}" selected="selected">-- {$forum['title']}</option>
					{else}
					<option value="{$forum['id']}">-- {$forum['title']}</option>
					{/if}
					{/if}
				{/Des::foreach}
				</select>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['description']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="describe" rows="5" cols="40" wrap="virtual">{$Inf['section_describe']}</textarea>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['forum_image']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			{$lang['show_image']}
			</td>
			<td class="row1">
				<select name="use_section_picture">
				{if {$Inf['use_section_picture']}}
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
			<td class="row2">
			{$lang['forum_image']}
			</td>
			<td class="row2">
				<input type="text" name="section_picture" value="{$Inf['section_picture']}" />
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			{$lang['image_position']}
			</td>
			<td class="row1">
				<select name="sectionpicture_type">
				{if {$Inf['sectionpicture_type']} == 1}
					<option value="1" selected="selected">{$lang['icon_position']}</option>
					<option value="2">{$lang['description_upper']}</option>
				{elseif {$Inf['sectionpicture_type']} == 2}
					<option value="1">{$lang['icon_position']}</option>
					<option value="2" selected="selected">{$lang['description_upper']}</option>
				{/if}
				</select>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['type']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			{$lang['link_forum']}
			</td>
			<td class="row1">
				<select name="linksection">
				{if {$Inf['linksection']}}
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
			<td class="row2">
			{$lang['link']}
			</td>
			<td class="row2">
				<input type="text" name="linksite" value="{$Inf['linksite']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['options']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['forum_password']}
			</td>
			<td class="row1">
				<input type="text" name="section_password" value="{$Inf['section_password']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['show_signature']}
			</td>
			<td class="row2">
				<select name="show_sig">
				{if {$Inf['show_sig']} != -1}
					<option value="1" selected="selected">{$lang['common']['yes']}</option>
					<option value="-1">{$lang['common']['no']}</option>
				{else}
					<option value="1">{$lang['common']['yes']}</option>
					<option value="-1" selected="selected">{$lang['common']['no']}</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['smartcode_allow']}
			</td>
			<td class="row2">
				<select name="usesmartcode_allow">
				{if {$Inf['usesmartcode_allow']}}
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
			{$lang['topic_view_state']}
			</td>
			<td class="row1">
				<select name="subject_order">
				{if {$Inf['subject_order']} == 1}
					<option value="1" selected="selected">{$lang['new_replies_up']}</option>
					<option value="2">{$lang['new_topic_up']}</option>
					<option value="3">{$lang['old_topic_up']}</option>
				{elseif {$Inf['subject_order']} == 2}
					<option value="1">{$lang['new_replies_up']}</option>
					<option value="2" selected="selected">{$lang['new_topic_up']}</option>
					<option value="3">{$lang['old_topic_up']}</option>
				{elseif {$Inf['subject_order']} == 3}
					<option value="1">{$lang['new_replies_up']}</option>
					<option value="2">{$lang['new_topic_up']}</option>
					<option value="3" selected="selected">{$lang['old_topic_up']}</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['hide_from_non_writer']}
			</td>
			<td class="row2">
				<select name="hide_subject">
				{if {$Inf['hide_subject']}}
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
			{$lang['secret_forum']}
			</td>
			<td class="row1">
				<select name="sec_section">
				{if {$Inf['sec_section']}}
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
