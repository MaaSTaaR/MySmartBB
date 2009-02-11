<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">احصائيات سريعه</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">رقم إصدار MySmartBB</td>
		<td class="row2" width="40%" dir="ltr"><strong>{$_CONF['info_row']['MySBB_version']}</strong></td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد الأعضاء</td>
		<td class="row2" width="40%">{$MemberNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد الأعضاء النشيطين</td>
		<td class="row2" width="40%">{$ActiveMember}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد المنتديات</td>
		<td class="row2" width="40%">{$ForumsNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد المواضيع</td>
		<td class="row2" width="40%">{$SubjectNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد الردود</td>
		<td class="row2" width="40%">{$ReplyNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد الأعضاء الذين اشتركوا اليوم</td>
		<td class="row2" width="40%">{$TodayMemberNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد المواضيع التي كتبت اليوم</td>
		<td class="row2" width="40%">{$TodaySubjectNumber}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">عدد الردود التي كتبت اليوم</td>
		<td class="row2" width="40%">{$TodayReplyNumber}</td>
	</tr>
</table>

<br />

<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">معلومات عن MySmartBB</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">مطوري MySmartBB</td>
		<td class="row2" width="40%"><strong><a traget="_blank" href="">هنا</a></strong></td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">الموقع الرسمي</td>
		<td class="row2" width="40%"><strong><a traget="_blank" href="http://www.mysmartbb.com">هنا</a></strong></td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">المستندات الرسمية</td>
		<td class="row2" width="40%"><strong><a traget="_blank" href="">هنا</a></strong></td>
	</tr>
</table>

<br />

<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1">المذكره</td>
	</tr>
	<tr align="center">
		<td class="row1">
			<form method="post" action="admin.php?page=note">
				<textarea name="note" rows="9" cols="77">{$_CONF['info_row']['admin_notes']}</textarea>
				<br />
				<input type="submit" value="موافق" name="submit" />
			</form>
		</td>
	</tr>
</table>
