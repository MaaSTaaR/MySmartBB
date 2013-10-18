{hook}before_today_subject_table{/hook}

{if {$NO_TOPICS}}
{$lang['no_new_topics']}
{else}
<table id="today_subject_table" border="1" class="t_style_b" width="98%" align="center">
	<tr>
		<td width="30%" class="main1 rows_space small_text" align="center" colspan="2">
			{$lang['topic_title']}
		</td>
		<td width="20%" class="main1 rows_space small_text" align="center">
			{$lang['topic_writer']}
		</td>
		<td width="10%" class="main1 rows_space small_text" align="center">
			{$lang['replies_number']}
		</td>
		<td width="10%" class="main1 rows_space small_text" align="center">
			{$lang['visits_number']}
		</td>
		<td width="28%" class="main1 rows_space small_text" align="center">
			{$lang['last_post']}
		</td>
	</tr>
	{DB::getInfo}{$latest_res}{$subject_list}
	<tr>
		<td width="3%" class="row1" align="center">
			<img src="{$bb_path}
			{$subject_list['icon']}" alt="" />
		</td>
		<td width="30%" class="row2">
			<a href="{$init_path}topic/
			{$subject_list['id']}/
			{$subject_list['title']}">
				{$subject_list['title']}
			</a>
			{if {$subject_list['close']}}
			<small>{$lang['closed']}</small>
			{/if}
			<br />
			<font class="small">{$subject_list['subject_describe']}</font>
		</td>
		<td width="20%" class="row1" align="center">
			<a href="{$init_path}profile/
			{$subject_list['writer']}">{$subject_list['writer']}</a><br />
			{$subject_list['write_date']}
		</td>
		<td width="8%" class="row2" align="center">
			{$subject_list['reply_number']}
		</td>
		<td width="8%" class="row1" align="center">
			{$subject_list['visitor']}
		</td>
		<td width="28%" class="row2" align="center">
			{if {$subject_list['reply_number']} <= 0}
			{$lang['no_replies']}
			{else}
			<a href="{$init_path}profile/
			{$subject_list['last_replier']}">{$subject_list['last_replier']}</a><br />
			{$subject_list['reply_date']}
			{/if}
		</td>
	</tr>	
{/DB::getInfo}
</table>
{/if}

<br />

{hook}after_today_subject_table{/hook}
