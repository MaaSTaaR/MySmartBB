<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=options&amp;index=1">إعدادات المنتدى</a> &raquo; <a href="admin.php?page=options&amp;feature=1&amp;main=1">إعدادات الميزات</a></div>

<br />

<form action="admin.php?page=options&amp;features=1&amp;update=1" method="post">
	<table width="60%" class="t_style_b rows_spaces" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">اعدادات الميزات</td>
				<tr>
			<td class="row2">إظهار اسماء الزوار في قائمة المتواجدين</td>
			<td class="row2">
				<select name="guest_online" id="select_guest_online">
					{if {$_CONF['info_row']['show_onlineguest']}}
						<option value="1" selected="selected">نعم</option>
						<option value="0">لا</option>
					{else}
						<option value="1">نعم</option>
						<option value="0" selected="selected">لا</option>
					{/if}
				</select>
			</td>
		</tr>
			<td class="row2">إظهار وصف اسفل كل قسم</td>
			<td class="row2">
				<select name="describe_feature" id="select_guest_online">
					{if {$_CONF['info_row']['describe_feature']}}
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
		تفعيل خاصية الرسائل الخاصة
			</td>
			<td class="row2">
				<select name="pm_feature">
				{if {$_CONF['info_row']['pm_feature']}}
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
