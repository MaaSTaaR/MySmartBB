<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">{$lang['moderators']}</a></div>

<br />


<table width="40%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		{$lang['forum_title']}
		</td>
	</tr>
	{Des::foreach}{forums_list}{forum}
	<tr align="center">
	{if {$forum['parent']} == 0}
		<td class="main2">
			{$forum['title']}
		</td>
	{else}
		<td class="row1">
			<a href="admin.php?page=moderators&amp;control=1&amp;section=1&amp;id={$forum['id']}">{$forum['title']}</a>
		</td>
	{/if}
	</tr>
	{/Des::foreach}
</table>
