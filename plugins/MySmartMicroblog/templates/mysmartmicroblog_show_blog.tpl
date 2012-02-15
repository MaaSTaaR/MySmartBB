{template}address_bar_part1{/template}
<a href="index.php?page=profile&amp;show=1&amp;username={$username}">{$username}</a>
{$_CONF['info_row']['adress_bar_separate']} {$plugin_lang['posts']}
{template}address_bar_part2{/template}

{if {$NO_POST} == 'true'}
{$plugin_lang['no_posts']}
{else}
<table align="center" class="t_style_b" border="1" width="80%">
	<tr align="center">
		<td class="main1 rows_space">
		{$plugin_lang['posts_of']} {$username}
		</td>
	</tr>
	{DB::getInfo}{$post}
	<tr>
		<td class="row1">
		{$post['context']}
		<br />
		{$plugin_lang['date']} {$post['date']}
		</td>
	</tr>
	{/DB::getInfo}
</table>
{/if}
