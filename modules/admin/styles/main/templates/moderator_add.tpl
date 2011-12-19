<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">{$lang['moderators']}</a> &raquo; {$lang['common']['add']}</div>

<br />

<form action="admin.php?page=moderators&amp;add=1&amp;start=1" method="post">

	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
			{$lang['add_moderator']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['username']}
			</td>
			<td class="row1">
				<input type="text" name="username" value="" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['forum']}
			</td>
			<td class="row2">
				<select size="1" name="section" id="section_id">
				{Des::foreach}{forums_list}{forum}
    			{if {$forum['parent']} == 0}
				<option value="{$forum['id']}" class="main_section" disabled="disabled">- {$forum['title']}</option>
				{else}
				<option value="{$forum['id']}">-- {$forum['title']}</option>
				{/if}
				{/Des::foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			{$lang['group']}
			</td>
			<td class="row2">
				<select size="1" name="group" id="group_id">
				{DB::getInfo}{$GroupList}
				<option value="{$GroupList['id']}">{$GroupList['title']}</option>
				{/DB::getInfo}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			{$lang['usertitle']}
			</td>
			<td class="row1">
				<input type="text" name="usertitle" value="" size="30" />
			</td>
		</tr>
	</table>

	<br />
	
	<div align="center">
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="{$lang['common']['submit']}" name="submit" />
			</td>
		</tr>
	</table>
	
	<br />

</form>
