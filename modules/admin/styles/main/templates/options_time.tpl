<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;time=1&amp;main=1">{$lang['time_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;time=1&amp;update=1" name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['time_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['board_time']}</td>
		<td class="row1">
<select name="time_stamp" id="select_time_stamp">
	<option {if {$_CONF['info_row']['timestamp']} == '-12'} selected="selected" {/if} value="-12" >GMT - 12</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-11'} selected="selected" {/if} value="-11" >GMT - 11</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-10'} selected="selected" {/if} value="-10" >GMT - 10</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-9'} selected="selected" {/if} value="-9" >GMT - 9</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-8'} selected="selected" {/if} value="-8" >GMT - 8</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-7'} selected="selected" {/if} value="-7" >GMT - 7</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-6'} selected="selected" {/if} value="-6" >GMT - 6</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-5'} selected="selected" {/if} value="-5" >GMT - 5</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-4'} selected="selected" {/if} value="-4" >GMT - 4</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-3'} selected="selected" {/if} value="-3" >GMT - 3</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-2'} selected="selected" {/if} value="-2" >GMT - 2</option>
	<option {if {$_CONF['info_row']['timestamp']} == '-1'} selected="selected" {/if} value="-1" >GMT - 1</option>
	<option {if {$_CONF['info_row']['timestamp']} == '0'} selected="selected" {/if} value="0">GMT Time</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+1'} selected="selected" {/if} value="+1" >GMT + 1</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+2'} selected="selected" {/if} value="+2" >GMT + 2</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+3'} selected="selected" {/if} value="+3" >GMT + 3</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+4'} selected="selected" {/if} value="+4" >GMT + 4</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+5'} selected="selected" {/if} value="+5" >GMT + 5</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+6'} selected="selected" {/if} value="+6" >GMT + 6</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+7'} selected="selected" {/if} value="+7" >GMT + 7</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+8'} selected="selected" {/if} value="+8" >GMT + 8</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+9'} selected="selected" {/if} value="+9" >GMT + 9</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+10'} selected="selected" {/if} value="+10" >GMT + 10</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+11'} selected="selected" {/if} value="+11" >GMT + 11</option>
	<option {if {$_CONF['info_row']['timestamp']} == '+12'} selected="selected" {/if} value="+12" >GMT + 12</option>
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['time_system']}</td>
		<td class="row2">
<select name="time_system" id="select_time_system">
		{if {$_CONF['info_row']['timesystem']} == 'ty'}
			<option value="ty" selected="selected">{$lang['textual_system']}</option>
			<option value="n" >{$lang['normal_system']}</option>
		{elseif {$_CONF['info_row']['timesystem']} == 'n'}
			<option value="ty">{$lang['textual_system']}</option>
			<option value="n" selected="selected">{$lang['normal_system']}</option>
		{/if}
</select>

</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
