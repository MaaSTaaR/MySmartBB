<br />

<table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="95%">
	<tr align="center">
		<td class="main1 rows_space" width="15%">
			معلومات الكاتب
		</td>
		<td class="main1 rows_space" width="80%">
			<img src="{$Reply_Info['icon']}" alt="" /> {$Info['title']}
		</td>
	</tr>
	<tr align="center">
		<td class="row2" width="25%" valign="top">
			{template}writer_info{/template}
		</td>
		<td class="row2" width="70%" align="right">
			{$Reply_Info['text']}
			
			{if {$Reply_Info['attach_reply']}}
				{template}attach_show{/template}
			{/if}
			
			{if {$Reply_Info['user_sig']} != ''}
				{template}signature_show{/template}
			{/if}
		</td>
	</tr>
	<tr align="center">
		<td class="row2" width="15%">
			{$Reply_Info['write_time']}
			<a title="ابلاغ عن مشاركة مخالفة" href="index.php?page=report&amp;index=1"><img alt="ابلاغ عن مشاركة مخالفة" border="0" src="{$image_path}/report.gif"></a>
		</td>
		<td class="row2" width="80%">
		{if {$Mod}}
		<form method="get" action="index.php">
		<input type="hidden" name="page" value="management" />
		<input type="hidden" name="reply" value="1" />
		<input type="hidden" name="section" value="{$section}" />
		<input type="hidden" name="subject_id" value="{$Reply_Info['subject_id']}" />
		<input type="hidden" name="reply_id" value="{$Reply_Info['reply_id']}" />
		
		<select name="operator">
			<option value="edit">تحرير الرد</option>
			<option value="delete">حذف الرد</option>
		</select>
		<input type="submit" value="موافق" />
		
		</form>
		{/if}
		</td>
	</tr>
</table>

<br />
