<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">{$lang['members']}</a> &raquo; {$lang['common']['edit']} : {$Inf['username']}</div>

<br />

<form action="admin.php?page=member_edit&amp;start=1&amp;id={$Inf['id']}" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['common']['edit']} {$lang['common']['member']}
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['username']}
		</td>
		<td class="row1">
			<input type="text" name="username" value="{$Inf['username']}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['email']}
		</td>
		<td class="row2">
			<input type="text" name="email" value="{$Inf['email']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['gender']}
		</td>
		<td class="row1">
			<select name="gender" id="select_gender">
			{if {$Inf['user_gender']} == 'm'}
				<option value="m" selected="selected">{$lang['male']}</option>
				<option value="f">{$lang['female']}</option>
			{else}
				<option value="m">{$lang['male']}</option>
				<option value="f" selected="selected">{$lang['female']}</option>
			{/if}
			</select>
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['style']}
		</td>
		<td class="row2">
			<select name="style" id="select_style">
			{DB::getInfo}{$style_res}{$style}
			{if {$Inf['style']} == {$style['id']} }
				<option value="{$style['id']}" selected="selected">{$style['style_title']}</option>
			{else}
				<option value="{$style['id']}">{$style['style_title']}</option>
			{/if}
			{/DB::getInfo}
			</select>
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['avatar']}
		</td>
		<td class="row1">
			<input type="text" name="avater_path" value="{$Inf['avatar_path']}" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['about_member']}
		</td>
		<td class="row2">
			<input type="text" name="user_info" value="{$Inf['user_info']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['usertitle']}
		</td>
		<td class="row1">
			<input type="text" name="user_title" value="{$Inf['user_title']}" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['posts_count']}
		</td>
		<td class="row2">
			<input type="text" name="posts" value="{$Inf['posts']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['member_website']}
		</td>
		<td class="row1">
			<input type="text" name="user_website" value="{$Inf['user_website']}" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['country']}
		</td>
		<td class="row2">
			<input type="text" name="user_country" value="{$Inf['user_country']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['group']}
		</td>
		<td class="row1">
			<select name="usergroup" id="select_usergroup">
			{DB::getInfo}{$group_res}{$group}
				{if {$Inf['usergroup']} == {$group['id']} }
				<option value="{$group['id']}" selected="selected">{$group['title']}</option>
				{else}
				<option value="{$group['id']}">{$group['title']}</option>
				{/if}
			{/DB::getInfo}
			</select>
		</td>
	</tr>
	<tr>
		<td class="row2">
		IP {$lang['member']}
		</td>
		<td class="row2">
			<input type="text" name="ip" value="{$Inf['member_ip']}" readonly="readonly" />
		</td>
	</tr>
</table>

<br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['change_username']}
		</td>
	</tr>
	<tr>
		<td class="row2">
		{$lang['new_username']}
		</td>
		<td class="row2">
			<input type="text" name="new_username" />
		</td>
	</tr>
</table>

<br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		{$lang['change_password']}
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['new_password']}
		</td>
		<td class="row1">
			<input type="password" name="new_password" />
		</td>
	</tr>
</table>

<br />

<div align="center">
	<input type="submit" value="{$lang['common']['submit']}" name="submit" />
</div>

</form>
