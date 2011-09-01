{template}usercp_menu{/template}

<div class="usercp_context">

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} معلوماتك الشخصيه
{template}address_bar_part2{/template}

<form name="info" method="post" action="index.php?page=usercp_control_info&amp;start=1">
	<table align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			معلوماتك الشخصيه
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			الدوله
			</td>
			<td class="row1" width="30%">
				<input name="country" type="text" value="{$_CONF['member_row']['user_country']}" />
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="30%">
			موقعك الشخصي
			</td>
			<td class="row2" width="30%">
				<input name="website" type="text" value="{$_CONF['member_row']['user_website']}" />
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			معلومات عنك
			</td>
			<td class="row1" width="30%">
				<input name="info" type="text" value="{$_CONF['member_row']['user_info']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	{if {$_CONF['info_row']['allow_apsent']}}
	<table align="center" border="1" cellpadding="2" cellspacing="2" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			اعدادات الغياب
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			هل تريد الغياب ؟
			</td>
			<td class="row1" width="30%">
				<select name="away" size="1">	
					{if {$_CONF['member_row']['away']} == 0}
						<option value="1">نعم</option>
						<option selected="selected" value="0">لا</option>
					{else}
						<option selected="selected" value="1">نعم</option>
						<option value="0">لا</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="60%" colspan="2">
				<textarea name="away_msg" rows="5" cols="40">{$_CONF['member_row']['away_msg']}</textarea>
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="60%" colspan="2">
				انت الآن : 
				{if {$_CONF['member_row']['away']} == 0}
					<strong>غير غائب</strong>
				{else}
					<strong>غائب</strong>
				{/if}
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="60%" colspan="2">
				ملاحظه : عند تشغيل اعدادات الغياب فان السبب سوف يظهر في ملفك الشخصي بالاضافه إلى مواضيعك و ردودك
			</td>
		</tr>
	</table>
	{/if}
	
	<br />
	
	<div align="center">
		<input name="send" type="submit" value="موافق" />
	</div>

</div>

<br />
