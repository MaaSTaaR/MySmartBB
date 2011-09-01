{template}address_bar_part1{/template}
قائمة الاعضاء
{template}address_bar_part2{/template}

<br />

{$pager}

<br />

<table border="1" width="60%" class="t_style_b" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="20%">
		اسم المستخدم
		</td>
		<td class="main1 rows_space" width="20%">
		مسمى العضو
		</td>
		<td class="main1 rows_space" width="10%">
		المشاركات
		</td>
		<td class="main1 rows_space" width="10%">
		الزيارات
		</td>
	</tr>
	{DB::getInfo}{$MemberList}
	<tr align="center">
		<td class="row1" width="20%">
		<a href="index.php?page=profile&amp;show=1&amp;id={$MemberList['id']}">{$MemberList['username']}</a>
		</td>
		<td class="row1" width="20%">
		{$MemberList['user_title']}
		</td>
		<td class="row1" width="10%">
		{$MemberList['posts']}
		</td>
		<td class="row1" width="10%">
		{$MemberList['visitor']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

{$pager}

<br />
