{template}usercp_menu{/template}

<div class="usercp_context">

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['pm']}
{template}address_bar_part2{/template}

<form method="post" action="index.php?page=pm_cp&amp;cp=1&amp;del=1">
<table border="1" class="t_style_b" width="%85" align="center">
	<tr align="center">
		<td width="95%" class="main1 rows_space" colspan="4">
			{$lang['pm']}
		</td>
	</tr>
	<tr align="center">
		<td class="main2" width="5%">
			{$lang['delete']}
		</td>
		<td class="main2" width="20%">
			{$lang['title']}
		</td>
		<td class="main2" width="20%">
			{$lang['sender']}
		</td>
		<td class="main2" width="20%">
			{$lang['send_date']}
		</td>
	</tr>
	{DB::getInfo}{$pmlist_res}{$MassegeList}
	<tr align="center">
		<td class="row1" width="5%">
			<input type="checkbox" name="delete_list[]" value="{$MassegeList['id']}" />
		</td>
		<td class="row1" width="20%">
			<a href="index.php?page=pm_show&amp;show=1&amp;id={$MassegeList['id']}">{$MassegeList['title']}</a>
			<br />
			{if {$INBOX_FOLDER}}
			{if {$MassegeList['user_read']} == 1}
			<span class="readpm">{$lang['read_message']}</span>
			{else}
			<span class="unreadpm">{$lang['new_message']}</span>
			{/if}
			{/if}
		</td>
		<td class="row1" width="20%">
			<a href="index.php?page=profile&amp;show=1&amp;username={$MassegeList['user_from']}">{$MassegeList['user_from']}</a>
		</td>
		<td class="row1" width="20%">
			{$MassegeList['date']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<input type="submit" name="delete" value="{$lang['delete']}" />
</form>

<br />

{$pager}

<br />

</div>
