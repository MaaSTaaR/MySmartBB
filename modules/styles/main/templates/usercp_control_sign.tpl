{template}usercp_menu{/template}

<div class="usercp_context {$_CONF['opp_align']}_side">
{template}address_bar_part1{/template}
<a href="{$init_path}usercp">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['your_sign']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

{if !empty({$Sign})}
   <table id="current_signature_table" align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="65%">
   	<tr align="center">
   		<td class="main1 rows_space" width="65%">
   		{$lang['current_sign']}
   		</td>
   	</tr>
   	<tr align="center">
   		<td class="row1" width="65%">
   			{$Sign}
   		</td>
   	</tr>
   </table>
   
   <br />
{/if}

{hook}after_current_signature_table{/hook}

<form method="post" name="topic" action="{$init_path}usercp_control_signature/start">

{template}toolbox{/template}

{hook}after_toolbox{/hook}

<br />

<table id="edit_signature_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['edit_sign']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69">{$_CONF['member_row']['user_sig']}</textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
</table>

<br />

{hook}after_edit_signature_table{/hook}

{template}smilebox{/template}

{hook}after_smilebox{/hook}

</form>

</div>
