{template}address_bar_part1{/template}
<a href="index.php?page=forum&amp;show=1&amp;id={$section_info['id']}{$password}">
	{$section_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']} <img src="{$Info['icon']}" alt="" /> {$Info['title']}
{template}address_bar_part2{/template}

<br />

{hook}after_adress_bar{/hook}

{template}add_reply_link{/template}
{template}add_subject_link{/template}

<br /><br />

{hook}after_adding_links{/hook}

{if {$Mod}}
{template}show_subject--subject_control{/template}
{/if}

{hook}after_topic_management{/hook}

{template}show_subject--subject_information{/template}

{hook}after_topic_info{/hook}

{if {$SHOW_POLL}}
{template}show_poll{/template}
{/if}

{hook}after_poll{/hook}

<table id="topic_context_table" align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="95%">
	<tr align="center">
		<td class="main1 rows_space" width="25%">
			{$lang['writer_information']}
		</td>
		<td class="main1 rows_space" width="70%">
			{$lang['subject_context']}
		</td>
	</tr>
	<tr>
		<td class="row2" width="25%">
			{template}writer_info{/template}
		</td>
		<td class="row2" width="70%">
			{$Info['text']}

			{if {$ATTACH_SHOW}}
				{template}attach_show{/template}
			{/if}
			
			{if {$Info['user_sig']} != ''}
				{template}signature_show{/template}
			{/if}
		</td>
	</tr>
	<tr align="center">
		<td class="row2" width="15%">
			{$Info['native_write_time']}
			<a title="{$lang['report_abuse']}" href="index.php?page=report&amp;index=1&amp;id={$Info['subject_id']}">
			    <img alt="{$lang['report_abuse']}" border="0" src="{$image_path}/report.gif">
			</a>
		</td>
		<td class="row2" width="80%">
			
		</td>
	</tr>
</table>

<br />

{hook}after_topic_context_table{/hook}
