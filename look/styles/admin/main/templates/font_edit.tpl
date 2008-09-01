<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=toolbox&amp;fonts=1&amp;control=1&amp;main=1">الخطوط</a> &raquo; تحرير : {$Inf['name']}</div>

<br />

<form action="admin.php?page=toolbox&amp;fonts=1&amp;add=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
		<tr valign="top" align="center">
			<td class="main1" colspan="2">
			تحرير خط
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			اسم الخط
			</td>
			<td class="row1">
				<input type="text" name="name" id="input_name" value="{$Inf['name']}" size="30" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
	<br />
</form>
