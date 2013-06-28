{hook}before_attachment_table{/hook}

<br />

<table id="attachment_table" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="50%" align="center">
	<tr align="center">
		<td width="30%" class="main1">
			{$lang['filename']}
		</td>
		<td width="20%" class="main1">
			{$lang['download_times']}
		</td>
	</tr>
	{DB::getInfo}{$attach_res}{$AttachList}
	<tr align="center">
		<td width="30%" class="row1">
			<a href="{$init_path}download/attach/
{$AttachList['id']}">{$AttachList['filename']}</a>
		</td>
		<td width="20%" class="row2">
			{$AttachList['visitor']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

{hook}after_attachment_table{/hook}
