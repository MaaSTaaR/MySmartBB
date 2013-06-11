{template}address_bar_part1{/template}
<a href="{$init_path}annoncement">{$lang['announcements']}</a> {$_CONF['info_row']['adress_bar_separate']} {$AnnInfo['title']}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

<table id="announcement_details_table" border="1" class="t_style_b" width="40%" align="center">
	<tr align="center">
		<td width="20%" class="row1">
			{$lang['announcement_title']}
		</td>
		<td width="20%" class="row1">
			{$AnnInfo['title']}
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
			{$lang['announcement_date']}
		</td>
		<td width="20%" class="row1">
			{$AnnInfo['date']}
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
			{$lang['announcement_writer']}
		</td>
		<td width="20%" class="row1">
			<a href="{$init_path}profile/{$AnnInfo['writer']}">{$AnnInfo['writer']}</a>
		</td>
	</tr>
</table>


<br />

{hook}after_announcement_details_table{/hook}

<table id="announcement_context_table" border="1" class="t_style_b" width="70%" align="center">
	<tr>
		<td width="70%" class="row1">
		{$AnnInfo['text']}
		</td>
	</tr>
</table>

{hook}after_announcement_context_table{/hook}

<br />
