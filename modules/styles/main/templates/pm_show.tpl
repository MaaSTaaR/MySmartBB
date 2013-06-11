{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">

{template}address_bar_part1{/template}
<a href="{$init_path}pm_list/inbox">
{$lang['pm']}</a> {$_CONF['info_row']['adress_bar_separate']} 
{$lang['read_the_pm']} {$lang['common']['colon']} {$MassegeRow['title']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

	<table id="pm_view_table" border="1" class="t_style_b" width="96%" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
				<img src="{$MassegeRow['icon']}" border="0" /> {$MassegeRow['title']}
			</td>
		</tr>
      	<tr align="center">
        	<td class="main2" width="20%">
        		{$lang['writer']}
        	</td>
        	<td class="main2" width="50%">
        		{$lang['context']}
        	</td>
      	</tr>
      	<tr>
      	<td class="row1" width="25%" align="center">
      		{template}writer_info{/template}
      	</td>
		<td class="row1" width="50%">
			{$MassegeRow['text']}
			
			{if {$Info['user_sig']} != ''}
				{template}signature_show{/template}
			{/if}
			{if {$ATTACH_SHOW}}
				{template}attach_show{/template}
			{/if}
		</td>
		</tr>
      	<tr align="center">
        	<td class="row1" width="20%">
        		{$lang['date']} {$lang['common']['colon']}{$MassegeRow['date']}
        	</td>
        	<td class="row1" width="50%">
        		<a href="{$init_path}download/pm/{$MassegeRow['id']}">{$lang['take_copy']}</a>
        	</td>
      	</tr>
</table>

</td>
</tr>
</table>

{hook}after_pm_view_table{/hook}

<br />

{template}pm_send{/template}

{hook}after_pm_send{/hook}

</div>
<br />
