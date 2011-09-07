<form method="get" action="index.php">

<input type="hidden" name="page" value="management" />
<input type="hidden" name="subject" value="1" />
<input type="hidden" name="section" value="{$Info['section']}" />
<input type="hidden" name="subject_id" value="{$Info['subject_id']}" />

<table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="50%">
	<tr align="center">
		<td class="main1 rows_space" width="50%">
			{$lang['subject_control']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
			<select name="operator" id="operator_i">
				{if !{$Info['stick']}}
				<option value="stick">{$lang['stick_subject']}</option>
				{/if}
				{if {$Info['stick']}}
				<option value="unstick">{$lang['unstick_subject']}</option>
				{/if}
				{if !{$Info['close']}}
				<option value="close">{$lang['close_subject']}</option>
				{/if}
				{if {$Info['close']}}
				<option value="open">{$lang['open_subject']}</option>
				{/if}
				<option value="delete">{$lang['delete_subject']}</option>
				<option value="move">{$lang['move_subject']}</option>
				<option value="edit">{$lang['edit_subject']}</option>
				<option value="repeated">{$lang['repeated_subject']}</option>
				<option value="up">{$lang['raise_subject']}</option>
				<option value="down">{$lang['down_subject']}</option>
			</select>
			<input type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
</table>

</form>

<br />
