{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">
	{template}address_bar_part1{/template}
	<a href="{$init_path}usercp">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['usercp_main']}
	{template}address_bar_part2{/template}
	
	{hook}after_adress_bar{/hook}
  	
  	<table id="own_topics_table" border="1" class="t_style_b" width="80%" align="center">
  		<tr align="center">
  			<td class="main1 rows_space" colspan="5">
     		{$lang['latest_own_subject']}
     		</td>
    	</tr>
		<tr>
			<td width="30%" class="main1 rows_space small_text" align="center" colspan="2">
			{$lang['title']}
			</td>
			<td width="10%" class="main1 rows_space small_text" align="center">
			{$lang['replies_number']}
			</td>
			<td width="10%" class="main1 rows_space small_text" align="center">
			{$lang['visitors_number']}
			</td>
			<td width="28%" class="main1 rows_space small_text" align="center">
			{$lang['last_reply']}
			</td>
		</tr>
    	{DB::getInfo}{$last_subjects_res}{$subject}
		<tr>
			<td width="3%" class="row1" align="center">
				<img src="{$bb_path}
				{$subject['icon']}" alt="" />
			</td>
			<td width="30%" class="row2">
				<a href="{$init_path}topic/
				{$subject['id']}/
				{$subject['title']}">
					{$subject['title']}
				</a> 
				{if {$subject['close']}}
				<small>({$lang['closed']})</small>
				{/if}
				<br />
				<font class="small">{$subject['subject_describe']}</font>
			</td>
			<td width="8%" class="row2" align="center">
				{$subject['reply_number']}
			</td>
			<td width="8%" class="row1" align="center">
				{$subject['visitor']}
			</td>
			<td width="28%" class="row2" align="center">
				{if {$subject['reply_number']} <= 0}
			    {$lang['no_replies']}
				{else}
				{$subject['reply_date']} 
				{$lang['written_by']} <a href="{$init_path}profile/
				{$subject['last_replier']}">{$subject['last_replier']}</a>
				{/if}
			</td>
		</tr>
    	{/DB::getInfo}
	</table>
	
	{hook}after_own_topics_table{/hook}
</div>
