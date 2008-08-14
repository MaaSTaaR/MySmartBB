{if {{$_CONF['info_row']['ajax_register']}}}
<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AjaxRegister()
{
	var AjaxState = {ajaxSend : Wait};
	
	var data = {};
	
	data['username'] 			= 	$("#username_id").val();
	data['password'] 			= 	$("#password_id").val();
	data['password_confirm'] 	= 	$("#password_confirm_id").val();
	data['email'] 				= 	$("#email_id").val();
	data['email_confirm'] 		= 	$("#email_confirm_id").val();
	data['gender'] 				= 	$("#gender_id").val();
	
	$.post("index.php?page=register&start=1",data,Success);
}

function Wait()
{
	$("#result").html("جاري تنفيذ العمليه");
}

function Success(xml)
{
	$("#result").html(xml);
}

function Ready()
{
	$("#register_id").click(AjaxRegister);
}

$(document).ready(Ready);
</script>

{template}address_bar_part1{/template}
التسجيل
{template}address_bar_part2{/template}

<br />

<div id="result" align="center"></div>

<br />
{/if}

<form name="register" method="post" action="index.php?page=register&amp;start=1">
<table border="1" class="t_style_b" width="60%" align="center">
	<tr align="center">
		<td width="80%" class="main1 rows_space" colspan="2">
		نموذج التسجيل
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		اسم المستخدم
		</td>
		<td width="30%" class="row1">
			<input type="text" name="username" id="username_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		كلمة المرور
		</td>
		<td width="30%" class="row1">
			<input type="password" name="password" id="password_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		تأكيد كلمة المرور
		</td>
		<td width="30%" class="row1">
			<input type="password" name="password_confirm"  id="password_confirm_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		البريد الالكتروني
		</td>
		<td width="30%" class="row1">
			<input type="text" name="email" id="email_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		تأكيد البريد الالكتروني
		</td>
		<td width="30%" class="row1">
			<input type="text" name="email_confirm" id="email_confirm_id" />
		</td>
	</tr>
	<tr>
		<td width="30%" class="row1">
		الجنس
		</td>
		<td width="30%" class="row1">
			<select name="gender" id="gender_id">
				<option value="m" selected="selected">ذكر</option>
				<option value="f">انثى</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width="60%" class="row1" colspan="2" align="center">
			<strong>يمكنك تعديل جميع اعداداتك من خلال لوحة تحكمك الخاصه بعد التسجيل</strong>
		</td>
	</tr>
</table>
<br />
<div align="center">
{if {{$_CONF['info_row']['ajax_register']}}}
<input name="register_button" id="register_id" type="button" value="موافق" />
{else}
<input name="register_button" type="submit" value="موافق" />
{/if}
</div>
</form>
<br />
