﻿<div align="center">
	<table id="reply_view_table" border="0" cellpadding="0" class="print-table" width="95%">
		<tr align="center">
			<td width="30%" class="print-td" style="font-size:14pt">
			{$lang['reply_writer']} : {$Info['display_username']}
			</td>
			<td width="60%" class="print-td">
			{$lang['on_date']} : {$Info['write_time']}
			</td>
		</tr> 
		<tr>
			<td width="95%" valign="top" colspan="2" class="print-td">
				<hr />
				{$Info['text']}
			</td>		
		</tr>
	</table>
</div>

{hook}after_reply_view_table{/hook}

<br />
