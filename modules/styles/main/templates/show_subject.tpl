{template}address_bar_part1{/template}
<a href="index.php?page=forum&amp;show=1&amp;id={$section_info['id']}{$password}">
	{$section_info['title']}
</a> {$_CONF['info_row']['adress_bar_separate']} <img src="{$Info['icon']}" alt="" /> {$Info['title']}
{template}address_bar_part2{/template}

<br />

{template}add_reply_link{/template}
{template}add_subject_link{/template}

<br /><br />

{if {$Mod}}
{template}show_subject--subject_control{/template}
{/if}

{template}show_subject--subject_information{/template}

{if {$SHOW_POLL}}
{template}show_poll{/template}
{/if}

<table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="95%">
	<tr align="center">
		<td class="main1 rows_space" width="15%">
			{$lang['writer_information']}
		</td>
		<td class="main1 rows_space" width="80%">
			{$lang['subject_context']}
		</td>
	</tr>
	<tr align="center">
		<td class="row2" width="25%" valign="top">
			{template}writer_info{/template}
		</td>
		<td class="row2" width="70%" align="right">
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
