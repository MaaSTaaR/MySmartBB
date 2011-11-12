{template}usercp_menu{/template}

<div class="usercp_context">

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['your_options']}
{template}address_bar_part2{/template}

<form name="info" method="post" action="index.php?page=usercp_control_setting&amp;start=1">
	<table align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			{$lang['your_options']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			{$lang['style']}
			</td>
			<td class="row1" width="30%">
				<select name="style">
   				{DB::getInfo}{$style_res}{$style}
						<option value="{$style['id']}">{$style['style_title']}</option>
				{/DB::getInfo}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="30%">
			{$lang['hidden_browsing']}
			</td>
			<td class="row2" width="30%">
				<select name="hide_online" size="1">
				{if {$_CONF['member_row']['hide_online']} == 0}
					<option value="1">{$lang['yes']}</option>
					<option selected="selected" value="0">{$lang['no']}
					{$lang['']}</option>
				{else}
					<option selected="selected" value="1">{$lang['yes']}</option>
					<option value="0">{$lang['no']}</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			{$lang['time']}
			</td>
			<td class="row1" width="30%">
				GMT <select size="1" name="user_time" dir="ltr">
						<option selected="selected" value="{$_CONF['member_row']['user_time']}">{$_CONF['member_row']['user_time']}</option>
						<option value="0">0</option>
	          			<option value="+1">+1</option>
    			      	<option value="+2">+2</option>
   			       		<option value="+3">+3</option>
          				<option value="+4">+4</option>
         				<option value="+5">+5</option>
          				<option value="+6">+6</option>
          				<option value="+7">+7</option>
          				<option value="+8">+8</option>
          				<option value="+9">+9</option>
          				<option value="+10">+10</option>
          				<option value="+11">+11</option>
          				<option value="+12">+12</option>
          				<option value="+13">+13</option>
          				<option value="-1">-1</option>
          				<option value="-2">-2</option>
          				<option value="-3">-3</option>
          				<option value="-4">-4</option>
          				<option value="-5">-5</option>
          				<option value="-6">-6</option>
          				<option value="-7">-7</option>
          				<option value="-8">-8</option>
          				<option value="-9">-9</option>
          				<option value="-10">-10</option>
          				<option value="-11">-11</option>
          				<option value="-12">-12</option>
	          </select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="30%">
			{$lang['send_permission']}
			</td>
			<td class="row2" width="30%">
				<select name="send_allow" size="1">
				{if {$_CONF['member_row']['send_allow']} == 0}
					<option value="1">{$lang['yes']}</option>
					<option selected="selected" value="0">{$lang['no']}</option>
				{else}
					<option selected="selected" value="1">{$lang['yes']}</option>
					<option value="0">{$lang['no']}</option>
				{/if}
				</select>
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input name="send" type="submit" value="{$lang['common']['submit']}" />
	</div>
</form>

</div>

<br />
