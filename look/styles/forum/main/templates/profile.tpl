{template}address_bar_part1{/template}
عرض الملف الشخصي للعضو {$MemberInfo['username']}
{template}address_bar_part2{/template}

<table align="center" class="t_style_b" border="1" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
		عرض الملف الشخصي للعضو {$MemberInfo['username']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		الاسم المستعار
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['username']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		المسمى
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_title']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		تاريخ التسجيل
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['register_date']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		عدد المشاركات
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['posts']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		عدد الزيارات
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['visitor']}
		</td>
	</tr>
	{if !empty({$MemberInfo['user_country']})}
	<tr align="center">
		<td class="row1" width="20%">
		الدوله
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_country']}
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1" width="20%">
		الجنس
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_gender']}
		</td>
	</tr>
	{if !empty({$MemberInfo['user_website']}) and {$MemberInfo['user_website']} != 'http://'}
	<tr align="center">
		<td class="row1" width="20%">
		الموقع الشخصي
		</td>
		<td class="row1" width="30%">
		 <a href="{$MemberInfo['user_website']}">{$MemberInfo['user_website']}</a>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1" width="20%">
		آخر زياره
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['lastvisit']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		الوقت لديه الآن
		</td>
		<td class="row1" width="30%">
		 {$MemberInfo['user_time']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		مجموعته
		</td>
		<td class="row1" width="30%">
		  {$MemberInfo['usergroup']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="20%">
		الحاله
		</td>
		<td class="row1" width="30%">
		 {if {$MemberInfo['IsOnline']}}
		 متصل
		 {else}
		 غير متصل
		 {/if}
		</td>
	</tr>
	{if {$MemberInfo['IsOnline']}}
	<tr align="center">
		<td class="row1" width="20%">
		مكان تواجده
		</td>
		<td class="row1" width="30%">
		{$Location['user_location']}
		</td>
	</tr>
	{/if}
</table>
<br />
<table align="center" class="t_style_b" border="1" width="80%">
	<tr align="center">
		<td width="60%" class="main1 rows_space" colspan="4">
		تفاصيل اخرى
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
		آخر موضوع 
		</td>
		<td width="20%" class="row1">
		آخر رد في
		</td>
		<td width="20%" class="row1">
		رساله خاصه 
		</td>
		<td width="20%" class="row1">
		رساله بريديه 
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$LastSubject['id']}">{$LastSubject['title']}</a>
		</td>
		<td width="20%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$LastReply['id']}">{$LastReply['title']}</a>
		</td>
		<td width="20%" class="row1">
		<a href="index.php?page=pm&amp;send=1&amp;index=1&amp;username={$MemberInfo['username']}">رساله خاصه</a>
		</td>
		<td width="20%" class="row1">
		<a href="index.php?page=send&amp;member=1&amp;index=1&amp;id={$MemberInfo['id']}">رساله بريديه</a> 
		</td>
	</tr>
</table>
<br />
