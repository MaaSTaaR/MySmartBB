<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">الاعضاء</a> &raquo; تحرير : {$Inf['username']}</div>

<br />

<form action="admin.php?page=member&amp;edit=1&amp;start=1&amp;id={$Inf['id']}"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تحرير عضو</td>
</tr>
<tr valign="top">
		<td class="row1">اسم المستخدم</td>
		<td class="row1">
<input type="text" name="username" id="input_username" value="{$Inf['username']}" size="30"readonly="readonly" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">البريد الالكتروني</td>
		<td class="row2">
<input type="text" name="email" id="input_email" value="{$Inf['email']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">الجنس</td>
		<td class="row1">
<select name="gender" id="select_gender">
	{if {{$Inf['user_gender']}} == 'm'}
	<option value="m" selected="selected">ذكر</option>
	<option value="f">انثى</option>
	{else}
	<option value="m">ذكر</option>
	<option value="f" selected="selected">انثى</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">النمط</td>
		<td class="row2">
<select name="style" id="select_style">
{Des::while}{StyleList}
	{if {{$Inf['style']}} == {{$StyleList['id']}}}
	<option value="{$StyleList['id']}" selected="selected">{$StyleList['style_title']}</option>
	{else}
	<option value="{$StyleList['id']}">{$StyleList['style_title']}</option>
	{/if}
{/Des::while}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">الصوره الرمزيه</td>
		<td class="row1">
<input type="text" name="avater_path" id="input_avater_path" value="{$Inf['avatar_path']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">نبذه</td>
		<td class="row2">
<input type="text" name="user_info" id="input_user_info" value="{$Inf['user_info']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">لقب العضو</td>
		<td class="row1">
<input type="text" name="user_title" id="input_user_title" value="{$Inf['user_title']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">عدد المشاركات</td>
		<td class="row2">

<input type="text" name="posts" id="input_posts" value="{$Inf['posts']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">عنوان الموقع</td>
		<td class="row1">
<input type="text" name="user_website" id="input_user_website" value="{$Inf['user_website']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">الدوله</td>
		<td class="row2">

<input type="text" name="user_country" id="input_user_country" value="{$Inf['user_country']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">المجموعه</td>
		<td class="row1">
<select name="usergroup" id="select_usergroup">
{Des::while}{GroupList}
	{if {{$Inf['usergroup']}} == {{$GroupList['id']}}}
	<option value="{$GroupList['id']}" selected="selected">{$GroupList['title']}</option>
	{else}
	<option value="{$GroupList['id']}">{$GroupList['title']}</option>
	{/if}
{/Des::while}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">IP العضو</td>
		<td class="row2">

<input type="text" name="ip" id="input_ip" value="{$Inf['member_ip']}" size="30" readonly="readonly" />&nbsp;
</td>
</tr>
</table><br />
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تغيير اسم المستخدم</td>
</tr>
<tr valign="top">
		<td class="row2">اسم المستخدم الجديد</td>
		<td class="row2">
<input type="text" name="new_username" id="input_new_username" value="" size="30" />&nbsp;
</td>
</tr>

</table><br />
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تغيير كلمة المرور</td>
</tr>
<tr valign="top">
		<td class="row1">كلمة المرور الجديده</td>
		<td class="row1">
<input type="password" name="new_password" id="input_new_password" value="" size="30" />&nbsp;
</td>
</tr>
</table><br />

<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
