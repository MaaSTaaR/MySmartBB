{template}usercp_menu{/template}

<div class="usercp_context">
{template}address_bar_part1{/template}
<a href="index.php?page=pm_list&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> {$_CONF['info_row']['adress_bar_separate']} إعدادات الرسائل الخاصه
{template}address_bar_part2{/template}

<form name="info" method="post" action="index.php?page=pm_setting&amp;setting=1&amp;start=1">

	<table align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			جُمله للمُرسلين
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="40%">
			هل تريد ان تظهر جمله في صفحة الارسال الخاصه بك لمن يحاول مراسلتك؟
			</td>
			<td class="row1" width="20%">
				<select name="pm_senders" size="1">
					{if {$_CONF['member_row']['pm_senders']}}
					<option selected="selected" value="1">نعم</option>
					<option value="0">لا</option>
					{else}
					<option value="1">نعم</option>
					<option selected="selected" value="0">لا</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="60%" colspan="2">
				الرساله : <input name="pm_senders_msg" type="text" value="{$_CONF['member_row']['pm_senders_msg']}" size="40" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<table align="center" border="1" width="60%" class="t_style_b">
		<tr align="center">
			<td class="main1 rows_space" width="60%" colspan="2">
			الرد الآلي على الرسائل الخاصه
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="30%">
			تشغيل الرد الآلي؟
			</td>
			<td class="row1" width="30%">
				<select name="autoreply" size="1">
					{if {$_CONF['member_row']['autoreply']}}
					<option selected="selected" value="1">نعم</option>
					<option value="0">لا</option>
					{else}
					<option value="1">نعم</option>
					<option selected="selected" value="0">لا</option>
					{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row2" width="60%" colspan="2">
				عنوان رسالة الرد : <input name="title" type="text" value="{$_CONF['member_row']['autoreply_title']}" />
				<br /><br />
				<textarea name="msg" rows="5" cols="40">{$_CONF['rows']['member_row']['autoreply_msg']}</textarea>
			</td>
		</tr>
		<tr align="center">
			<td class="row1" width="60%" colspan="2">
				الرد الآلي الآن : 
			{if {$_CONF['member_row']['autoreply']}}
			<strong>يعمل</strong>
			{else}
			<strong>لا يعمل</strong>
			{/if}
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input name="send" type="submit" value="موافق" />
	</div>

</div>
<br />
