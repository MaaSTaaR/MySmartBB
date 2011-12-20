{template}usercp_menu{/template}

<div class="usercp_context">
{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['your_sign']}
{template}address_bar_part2{/template}

{if !empty({$Sign})}
   <table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="65%">
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

<form method="post" name="topic" action="index.php?page=usercp_control_signature&amp;start=1">

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
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

{template}smilebox{/template}

</form>

</div>
