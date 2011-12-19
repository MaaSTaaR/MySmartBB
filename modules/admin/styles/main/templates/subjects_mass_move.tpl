<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="">{$lang['mass_move']}</a></div>

<br />

<form action="admin.php?page=subject&amp;mass_move=1&amp;start=1" method="post">
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			{$lang['mass_move']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			{$lang['from_forum']}
			</td>
			<td class="row2">
				<select name="from" id="select_from">
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
		<tr align="center">
			<td class="row1">
			{$lang['to_forum']}
			</td>
			<td class="row2">
				<select name="to" id="select_to">
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
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="{$lang['common']['submit']}" name="submit" />
	</div>
	
	<br />
</form>
