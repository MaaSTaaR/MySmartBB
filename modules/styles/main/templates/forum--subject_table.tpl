<br /><br />

{hook}before_subject_table{/hook}

{$pager}

<table id="subject_table" border="1" class="t_style_b" width="98%" align="center">
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
	{if {$SHOW_STICK}}
	<tr>
		<td width="98%" colspan="6" class="main2" align="center">
			{$lang['stick_topics']}
		</td>
	</tr>
	{DB::getInfo}{$stick_subject_res}{$stick_subject_list}
	<tr>
		<td width="3%" class="row1" align="center">
			<img src="{$bb_path}
{$stick_subject_list['icon']}" alt="" />
		</td>
		<td width="30%" class="row2">
			<a href="{$init_path}topic/
			{$stick_subject_list['id']}/
			{$stick_subject_list['title']}
			{$password}">
				{$stick_subject_list['title']}
			</a> 
			{if {$stick_subject_list['close']}}
			<small>{$lang['closed']}</small>
			{/if}
			<br />
			<font class="small">{$stick_subject_list['subject_describe']}</font>
		</td>
		<td width="20%" class="row1" align="center">
			<a href="{$init_path}profile/{$stick_subject_list['writer']}">{$stick_subject_list['writer']}</a><br />
			{$stick_subject_list['write_date']}
		</td>
		<td width="8%" class="row2" align="center">
			{$stick_subject_list['reply_number']}
		</td>
		<td width="8%" class="row1" align="center">
			{$stick_subject_list['visitor']}
		</td>
		<td width="28%" class="row2" align="center">
			{if {$stick_subject_list['reply_number']} <= 0}
			{$lang['no_replies']}
			{else}
			<a href="{$init_path}profile/{$stick_subject_list['last_replier']}">{$stick_subject_list['last_replier']}</a><br />
			{$stick_subject_list['reply_date']}
			{/if}
		</td>
	</tr>
	{/DB::getInfo}
	{/if}
	<tr>
		<td width="98%" colspan="6" class="main2" align="center">
			{$lang['topics_list']}
		</td>
	</tr>
	{DB::getInfo}{$subject_res}{$subject_list}
	<tr>
		<td width="3%" class="row1" align="center">
			<img src="{$bb_path}
{$subject_list['icon']}" alt="" />
		</td>
		<td width="30%" class="row2">
			<a href="{$init_path}topic/
			{$subject_list['id']}/
			{$subject_list['title']}
			{$password}">
				{$subject_list['title']}
			</a>
			{if {$subject_list['close']}}
			<small>{$lang['closed']}</small>
			{/if}
			<br />
			<font class="small">{$subject_list['subject_describe']}</font>
		</td>
		<td width="20%" class="row1" align="center">
			<a href="{$init_path}
			profile/
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
			<a href="{$init_path}
			profile/
			{$subject_list['last_replier']}">{$subject_list['last_replier']}</a><br />
			{$subject_list['reply_date']}
			{/if}
		</td>
	</tr>	
{/DB::getInfo}
</table>

<br />

{$pager}

<br />

{hook}after_subject_table{/hook}
