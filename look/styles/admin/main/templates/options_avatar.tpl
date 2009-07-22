<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;avatar=1&amp;main=1">إعدادات الصور الشخصيه</a></div>

<br />

<form action="admin.php?page=options&amp;avatar=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			اعدادات الصور الشخصيه
			</td>
		</tr>
		<tr>
			<td class="row1">
			تفعيل الصور الشخصية
			</td>
			<td class="row1">
				<select name="allow_avatar">
				{if {$_CONF['info_row']['allow_avatar']}}
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
			السماح بتحميل الصور من حاسوب المستخدم
			</td>
			<td class="row2">
				<select name="upload_avatar">
				{if {$_CONF['info_row']['upload_avatar']}}
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
			اقصى عرض للصور الشخصية
			</td>
			<td class="row1">
				<input type="text" name="max_avatar_width" value="{$_CONF['info_row']['max_avatar_width']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			اقصى ارتفاع للصور الشخصية
			</td>
			<td class="row2">
				<input type="text" name="max_avatar_height" value="{$_CONF['info_row']['max_avatar_height']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			الصورة الشخصية الأفتراضية
			</td>
			<td class="row2">
				<input type="text" name="default_avatar" value="{$_CONF['info_row']['default_avatar']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
</form>
