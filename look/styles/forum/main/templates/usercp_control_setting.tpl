{template}usercp_menu{/template}

<div class="usercp_context">

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} خياراتك الخاصه
{template}address_bar_part2{/template}

<form name="info" method="post" action="index.php?page=usercp&amp;control=1&amp;setting=1&amp;start=1">
	<table align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			خياراتك الخاصه
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			الستايل
			</td>
			<td class="row1" width="30%">
				<select name="style">
   					{Des::while}{StyleList}
						<option value="{$StyleList['id']}" {if {$StyleList['id']} == {$_CONF['rows']['style']['id']}}selected="selected" style="background : #EEEEEE"{/if}>{$StyleList['style_title']}</option>
				{/Des::while}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="30%">
			التصفح الخفي
			</td>
			<td class="row2" width="30%">
				<select name="hide_online" size="1">
				{if {$_CONF['rows']['member_row']['hide_online']} == 0}
					<option value="1">نعم</option>
					<option selected="selected" value="0">لا</option>
				{else}
					<option selected="selected" value="1">نعم</option>
					<option value="0">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			الوقت
			</td>
			<td class="row1" width="30%">
				GMT <select size="1" name="user_time" dir="ltr">
						<option selected="selected" value="{$_CONF['rows']['member_row']['user_time']}">{$_CONF['rows']['member_row']['user_time']}</option>
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
			السماح للاعضاء بمراسلتك بريدياً
			</td>
			<td class="row2" width="30%">
				<select name="send_allow" size="1">
				{if {$_CONF['rows']['member_row']['send_allow']} == 0}
					<option value="1">نعم</option>
					<option selected="selected" value="0">لا</option>
				{else}
					<option selected="selected" value="1">نعم</option>
					<option value="0">لا</option>
				{/if}
				</select>
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input name="send" type="submit" value="موافق" />
	</div>
</form>

</div>

<br />
