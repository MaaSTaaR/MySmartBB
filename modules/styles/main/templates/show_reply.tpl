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
	<tr align="center">
		<td class="row2" width="25%" valign="top">
			{template}writer_info{/template}
		</td>
		<td class="row2" width="70%"  colspan="2">
			{$Info['text']}
			
			{if {$SHOW_REPLY_ATTACH}}
				{template}attach_show{/template}
			{/if}
			
			{if {$Info['user_sig']} != ''}
				{template}signature_show{/template}
			{/if}
		</td>
	</tr>
	<tr align="center">
		<td class="row2" width="15%">
			{$Info['write_time']}
			<a title="{$lang['report_abuse']}" href="index.php?page=report&amp;index=1">
			<img alt="{$lang['report_abuse']}" border="0" src="{$image_path}/report.gif">
			</a>
		</td>
		<td  colspan="2" class="row2" width="80%">
		{if {$Mod}}
		<form method="get" action="index.php">
		<input type="hidden" name="page" value="management" />
		<input type="hidden" name="reply" value="1" />
		<input type="hidden" name="section" value="{$section}" />
		<input type="hidden" name="subject_id" value="{$Info['subject_id']}" />
		<input type="hidden" name="reply_id" value="{$Info['reply_id']}" />
		
		<select name="operator">
			<option value="edit">{$lang['edit_reply']}</option>
			<option value="delete">{$lang['delete_reply']}</option>
		</select>
		<input type="submit" value="{$lang['common']['submit']}" />
		
		</form>
		{/if}
		</td>
	</tr>
</table>

<br />
