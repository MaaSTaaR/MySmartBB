<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="50%" colspan="2">
			{$lang['subject_information']}
		</td>
	</tr>
	{if {$Info['stick']} or {$Info['close']} or {$Info['delete_topic']}}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			{$lang['subject_state']} {$lang['common']['colon']}
			<strong>
			{if {$Info['stick']}}
			{$lang['sticked']}
			{/if}
			{if {$Info['close']}}
			{$lang['closed']}
			{/if}
			{if {$Info['delete_topic']}}
			{$lang['deleted']}
			{/if}
			</strong>
		</td>
	</tr>
	{/if}
	{if {$Info['close_reason']} != '' and {$Info['close']} }
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			{$lang['close_reason']} {$lang['common']['colon']} <strong>{$Info['close_reason']}</strong>
		</td>
	</tr>
	{/if}
	{if {$Info['delete_reason']} != '' and {$Info['delete_topic']} }
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			{$lang['delete_reason']} {$lang['common']['colon']} <strong>{$Info['delete_reason']}</strong>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1 rows_space" width="25%">
			{$lang['replies_number']} {$lang['common']['colon']} {$Info['reply_number']}
		</td>
		<td class="row1 rows_space" width="25%">
			{$lang['visits_number']} {$lang['common']['colon']} {$Info['subject_visitor']}
		</td>
	</tr>
	{if {$SHOW_TAGS}}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			<strong>
			{$lang['subject_tags']} {$lang['common']['colon']}
			{DB::getInfo}{$tags_res}{$tags}
			<a href="{$init_path}tags/
			{$tags['tag_id']}/
			{$tags['tag']}">{$tags['tag']}</a>،
			{/DB::getInfo}
			</strong>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			<a href="{$init_path}download/subject/
			{$Info['subject_id']}">{$lang['download_subject']}</a>
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			<a href="{$init_path}topic/printable/
			{$Info['subject_id']}">{$lang['printable_version']}</a>
		</td>
	</tr>
</table>

<br />
