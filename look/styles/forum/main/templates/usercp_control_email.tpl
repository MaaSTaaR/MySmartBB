{template}usercp_menu{/template}

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} تغيير بريدك الالكتروني
{template}address_bar_part2{/template}

<form method="post" action="index.php?page=usercp&amp;control=1&amp;email=1&amp;start=1">

<table align="center" border="1" width="60%" class="t_style_b">
	<tr align="center">
		<td width="60%" class="main1 rows_space" colspan="2">
			تغيير بريدك الالكتروني
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
			البريد الالكتروني الجديد
		</td>
		<td width="30%" class="row1">
			<input type="text" name="new_email" />
		</td>
	</tr>
</table>

<br />

<div align="center"><input type="submit" value="موافق" /></div>

</form>
