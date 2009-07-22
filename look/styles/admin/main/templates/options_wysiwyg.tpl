<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;wysiwyg=1&amp;main=1">إعدادات المحرر المتقدم WYSIWYG</a></div>

<br />

<form action="admin.php?page=options&amp;wysiwyg=1&amp;update=1" method="post">
	<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			إعدادات المحرر المتقدم WYSIWYG
			</td>
		</tr>
		<tr>
			<td class="row1">
			تنشيطه في صفحة اضافة الموضوع
			</td>
			<td class="row1">
				<select name="wysiwyg_topic">
					{if {$_CONF['info_row']['wysiwyg_topic']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
					{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			تنشيطه في صفحة اضافة الرد
			</td>
			<td class="row2">
				<select name="wysiwyg_reply">
					{if {$_CONF['info_row']['wysiwyg_reply']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
					{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			تنشيطه في الرد السريع
			</td>
			<td class="row1">
				<select name="wysiwyg_freply">
					{if {$_CONF['info_row']['wysiwyg_freply']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
					{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
					{/if}
				</select>
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
</form>
