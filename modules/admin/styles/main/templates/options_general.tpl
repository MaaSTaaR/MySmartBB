<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;general=1&amp;main=1">إعدادات عامه</a></div>

<br />

<form action="admin.php?page=options&amp;general=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b rows_spaces" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">اعدادات عامه</td>
		</tr>
		<tr>
			<td class="row1">اسم المنتدى</td>
			<td class="row1">
				<input type="text" name="title" value="{$_CONF['info_row']['title']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">بريد الارسال</td>
			<td class="row2">
				<input type="text" name="send_email" value="{$_CONF['info_row']['send_email']}" />
			</td>
		</tr>
		<tr>
			<td class="row1">بريد الاستقبال</td>
			<td class="row1">
				<input type="text" name="admin_email" value="{$_CONF['info_row']['admin_email']}" />
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
</form>
