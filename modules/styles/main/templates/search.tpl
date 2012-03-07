{template}address_bar_part1{/template}
{$lang['the_search']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<form name="search" method="get">

<input type="hidden" name="page" value="search">
<input type="hidden" name="start" value="1">

<table id="search_table" border="1" width="60%" class="t_style_b" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
		{$lang['search_engine']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="25%">
		{$lang['keyword']}
		</td>

        <td class="row1" width="25%">
        	<input type="text" name="keyword" id="keyword_id" />
        </td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
		{$lang['by_username']}
		</td>
        <td class="row1" width="50%">
        	<input type="text" name="username" id="username_id" />
        </td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
		{$lang['the_forum']}
		</td>

        <td class="row1" width="50%">
        	<select size="1" name="section" id="section_id">
        		<option selected="selected" value="all">{$lang['all_forums']}</option>
        		{Des::foreach}{forums_list}{forum}
        		{if {$forum['parent']} == 0}
				<option value="{$forum['id']}" class="main_section">- {$forum['title']}</option>
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
	<input type="submit" value="{$lang['search']}" name="search">
</div>

</form>

{hook}after_search_table{/hook}
