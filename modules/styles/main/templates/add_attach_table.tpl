{hook}before_add_attachements_table{/hook}

<br />

<table id="add_attachements_table" border="1" width="50%" class="t_style_b" align="center" id="add_attach_table">
	<tr align="center">
		<td class="main1 rows_space" colspan="2">
		{$lang['add_attachments']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<strong>{$lang['attachments_limited']} {$lang['common']['colon']} {$_CONF['group_info']['upload_attach_num']}</strong>
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			{$lang['file']} #1
		</td>
		<td class="row1 rows_space">
			<input name="files[]" type="file" value="" size="40" />
		</td>
	</tr>
	<tr align="center" class="more_attach_tr">
		<td class="row1 rows_space" colspan="2">
			<input type="button" name="more_attach" class="more_attach_class" value="{$lang['add_another_file']}" />
		</td>
	</tr>
</table>

{hook}after_add_attachements_table{/hook}
