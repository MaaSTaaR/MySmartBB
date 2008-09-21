{template}usercp_menu{/template}

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} توقيعك الخاص
{template}address_bar_part2{/template}

{if !empty({$Sign})}
   <table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="65%">
   	<tr align="center">
   		<td class="thead" width="65%">
   		توقيعك الحالي
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

<form method="post" name="topic" action="index.php?page=usercp&amp;control=1&amp;sign=1&amp;start=1">

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		تحرير التوقيع
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69">{$_CONF['rows']['member_row']['user_sig']}</textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="موافق" />
		</td>
	</tr>
</table>

<br />

{template}smilebox{/template}

</form>
