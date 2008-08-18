<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;time=1&amp;main=1">إعدادات الوقت</a></div>

<br />

<form action="admin.php?page=options&amp;time=1&amp;update=1" name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">اعدادات الوقت</td>
</tr>
<tr valign="top">
		<td class="row1">توقيت المنتدى</td>
		<td class="row1">
<select name="time_stamp" id="select_time_stamp">
	<option {if {{$_CONF['info_row']['timestamp']}} == '-43200'} selected="selected" {/if} value="-43200" >GMT 12</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-39600'} selected="selected" {/if} value="-39600" >GMT 11</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-36000'} selected="selected" {/if} value="-36000" >GMT 10</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-32400'} selected="selected" {/if} value="-32400" >GMT 9</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-28800'} selected="selected" {/if} value="-28800" >GMT 8</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-25200'} selected="selected" {/if} value="-25200" >GMT 7</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-21600'} selected="selected" {/if} value="-21600" >GMT 6</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-18000'} selected="selected" {/if} value="-18000" >GMT 5</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-14400'} selected="selected" {/if} value="-14400" >GMT 4</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-10800'} selected="selected" {/if} value="-10800" >GMT 3</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-7200'} selected="selected" {/if} value="-7200" >GMT 2</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '-3600'} selected="selected" {/if} value="-3600" >GMT 1</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '0000'} selected="selected" {/if} value="0000"  selected="selected">GMT Time</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+3600'} selected="selected" {/if} value="+3600" >GMT + 1</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+7200'} selected="selected" {/if} value="+7200" >GMT + 2</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+10800'} selected="selected" {/if} value="+10800" >GMT + 3</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+14400'} selected="selected" {/if} value="+14400" >GMT + 4</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+18000'} selected="selected" {/if} value="+18000" >GMT + 5</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+21600'} selected="selected" {/if} value="+21600" >GMT + 6</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+25200'} selected="selected" {/if} value="+25200" >GMT + 7</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+28800'} selected="selected" {/if} value="+28800" >GMT + 8</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+32400'} selected="selected" {/if} value="+32400" >GMT + 9</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+36000'} selected="selected" {/if} value="+36000" >GMT + 10</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+39600'} selected="selected" {/if} value="+39600" >GMT + 11</option>
	<option {if {{$_CONF['info_row']['timestamp']}} == '+43200'} selected="selected" {/if} value="+43200" >GMT + 12</option>
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">نظام الوقت</td>
		<td class="row2">
<select name="time_system" id="select_time_system">
		{if {{$_CONF['info_row']['timesystem']}} == 'ty'}
			<option value="ty" selected="selected">نظام اليوم/الامس</option>
			<option value="n" >النظام العادي</option>
		{elseif {{$_CONF['info_row']['timesystem']}} == 'n'}
			<option value="ty">نظام اليوم/الامس</option>
			<option value="n" selected="selected">النظام العادي</option>
		{/if}
</select>

</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
