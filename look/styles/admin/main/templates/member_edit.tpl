<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=member&amp;control=1&amp;main=1">الاعضاء</a> &raquo; تحرير : {$Inf['username']}</div>

<br />

<form action="admin.php?page=member&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		تحرير عضو
		</td>
	</tr>
	<tr>
		<td class="row1">
		اسم المستخدم
		</td>
		<td class="row1">
			<input type="text" name="username" value="{$Inf['username']}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		البريد الالكتروني
		</td>
		<td class="row2">
			<input type="text" name="email" value="{$Inf['email']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		الجنس
		</td>
		<td class="row1">
			<select name="gender" id="select_gender">
			{if {$Inf['user_gender']} == 'm'}
				<option value="m" selected="selected">ذكر</option>
				<option value="f">انثى</option>
			{else}
				<option value="m">ذكر</option>
				<option value="f" selected="selected">انثى</option>
			{/if}
			</select>
		</td>
	</tr>
	<tr>
		<td class="row2">
		النمط
		</td>
		<td class="row2">
			<select name="style" id="select_style">
			{Des::while}{StyleList}
			{if {$Inf['style']} == {$StyleList['id']} }
				<option value="{$StyleList['id']}" selected="selected">{$StyleList['style_title']}</option>
			{else}
				<option value="{$StyleList['id']}">{$StyleList['style_title']}</option>
			{/if}
			{/Des::while}
			</select>
		</td>
	</tr>
	<tr>
		<td class="row1">
		الصوره الرمزيه
		</td>
		<td class="row1">
			<input type="text" name="avater_path" value="{$Inf['avatar_path']}" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		نبذه
		</td>
		<td class="row2">
			<input type="text" name="user_info" value="{$Inf['user_info']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		لقب العضو
		</td>
		<td class="row1">
			<input type="text" name="user_title" value="{$Inf['user_title']}" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		عدد المشاركات
		</td>
		<td class="row2">
			<input type="text" name="posts" value="{$Inf['posts']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		عنوان الموقع
		</td>
		<td class="row1">
			<input type="text" name="user_website" value="{$Inf['user_website']}" />
		</td>
	</tr>
	<tr>
		<td class="row2">
		الدوله
		</td>
		<td class="row2">
			<input type="text" name="user_country" value="{$Inf['user_country']}" />
		</td>
	</tr>
	<tr>
		<td class="row1">
		المجموعه
		</td>
		<td class="row1">
			<select name="usergroup" id="select_usergroup">
			{Des::while}{GroupList}
				{if {$Inf['usergroup']} == {$GroupList['id']} }
				<option value="{$GroupList['id']}" selected="selected">{$GroupList['title']}</option>
				{else}
				<option value="{$GroupList['id']}">{$GroupList['title']}</option>
				{/if}
			{/Des::while}
			</select>
		</td>
	</tr>
	<tr>
		<td class="row2">
		IP العضو
		</td>
		<td class="row2">
			<input type="text" name="ip" value="{$Inf['member_ip']}" readonly="readonly" />
		</td>
	</tr>
</table>

<br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		خيارات أخرى
		</td>
	</tr>
	<tr>
		<td class="row1">
		مواضيعة تستلزم الموافقة قبل النشر
		</td>
		<td class="row1">
			<select name="review_subject" id="select_review_subject">
				{if {$Inf['review_subject']}}
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

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		تغيير اسم المستخدم
		</td>
	</tr>
	<tr>
		<td class="row2">
		اسم المستخدم الجديد
		</td>
		<td class="row2">
			<input type="text" name="new_username" />
		</td>
	</tr>
</table>

<br />

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		تغيير كلمة المرور
		</td>
	</tr>
	<tr>
		<td class="row1">
		كلمة المرور الجديده
		</td>
		<td class="row1">
			<input type="password" name="new_password" />
		</td>
	</tr>
</table>

<br />

<div align="center">
	<input type="submit" value="موافق" name="submit" />
</div>

</form>
