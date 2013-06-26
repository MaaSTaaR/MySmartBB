<br />

<table id="{$Info['reply_id']}" align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="95%">
	<tr align="center">
		<td class="main1 rows_space" width="15%">
			{$lang['writer_information']}
		</td>
		<td class="main1 rows_space" width="80%">
			<img src="{$Info['icon']}" alt="" /> {$Info['title']}
		</td>
		<td class="main1 rows_space" width="80%">
			<a title="{$lang['reply_number']} ({$Info['reply_id']})" name="{$Info['reply_id']}" href="#{$Info['reply_id']}">#{$Info['reply_number']}</a>
		</td>
	</tr>
	<tr>
		<td class="row2" width="25%" style="vertical-align: text-top;">
			{template}writer_info{/template}
		</td>
		<td class="row2" width="70%"  colspan="2">
			{$Info['text']}
			
			{if {$SHOW_REPLY_ATTACH}}
				{template}attach_show{/template}
			{/if}
			
			{if {$Info['user_sig']} != '' and {$section_info['show_sig']} != -1}
				{template}signature_show{/template}
			{/if}
		</td>
	</tr>
	<tr align="center">
		<td class="row2" width="15%">
			{$Info['write_time']}
			<a title="{$lang['report_abuse']}" href="{$init_path}report/
			{$Info['subject_id']}/{$Info['reply_id']}">
			<img alt="{$lang['report_abuse']}" border="0" src="{$image_path}/report.png">
			</a>
		</td>
		<td  colspan="2" class="row2" width="80%">
		{if {$Mod}}
		{template}show_reply--reply_control{/template}
		<strong><a class="box_link" href="#reply_management_dialog_{$Info['reply_id']}">{$lang['reply_control']}</a></strong>
		{/if}
		</td>
	</tr>
</table>

<br />
