{if !{$_CONF['info_row']['ajax_moderator_options']}}
<form method="post" action="index.php?page=management&amp;close=1&amp;subject_id={$subject}">
{/if}

<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
			إغلاق الموضوع
		</td>
	</tr>
	<tr>
		<td class="row1 rows_space" width="30%">
			سبب إغلاق الموضوع (يمكن تركه فارغاً)
		</td>
		<td class="row2 rows_space" width="30%">
			<input name="reason" type="text" />
		</td>
	</tr>
</table>

<br />

<div align="center">
	{if {$_CONF['info_row']['ajax_moderator_options']}}
	<input type="button" id="close_id" value="موافق" />
	{else}
	<input type="submit" value="موافق" />
	{/if}
</div>

{if !{$_CONF['info_row']['ajax_moderator_options']}}
</form>
{/if}
