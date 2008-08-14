{template}usercp_menu{/template}

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} تغيير الكلمه السريه
{template}address_bar_part2{/template}

<form method="post" action="index.php?page=usercp&amp;control=1&amp;password=1&amp;start=1">

<table align="center" border="1" width="60%" class="t_style_b">
	<tr align="center">
		<td width="60%" class="main1 rows_space" colspan="2">
			تغيير كلمة مرورك
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
			كلمة مرورك الحاليه
		</td>
		<td width="30%" class="row1">
			<input type="password" name="old_password" />
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row2">
			كلمة المرور الجديده
		</td>
		<td width="30%" class="row2">
			<input type="password" name="new_password" />
		</td>
	</tr>
</table>

<br />

<div align="center"><input type="submit" value="موافق" /></div>

</form>
