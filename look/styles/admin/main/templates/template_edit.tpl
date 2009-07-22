<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=template&amp;control=1&amp;main=1">القوالب</a> &raquo; تحرير : {$filename}</div>

<br />

<form action="admin.php?page=template&amp;edit=1&amp;start=1&amp;id={$Inf['id']}&amp;filename={$filename}" method="post">
	<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
		<tr valign="top" align="center">
			<td class="main1" colspan="2">
			تحرير القالب
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			اسم القالب
			</td>
			<td class="row1">
				{$filename}
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			نمط القالب
			</td>
			<td class="row1">
				{$Inf['style_title']}
			</td>
		</tr>
		<tr valign="top">
			<td class="row1">
			حُرر في
			</td>
			<td class="row1">
				{$last_edit}
			</td>
		</tr>
		<tr valign="top">
			<td class="row1" colspan="2" align="center">
				<textarea rows="25" cols="80" name="context" dir="ltr">{$context}</textarea>
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="حفظ" name="submit" />
	</div>
</form>
