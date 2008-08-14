{template}address_bar_part1{/template}
المسؤولين
{template}address_bar_part2{/template}

<br />

<table cellpadding="2" cellspacing="2" border="1" align="center" class="t_style_b" width="50%">
	<tr align="center">
		<td class="tcat1" width="30%">
		اسم المستخدم
		</td>
		<td class="tcat1" width="20%">
		المسمى
		</td>
	</tr>
{Des::while}{GetTeamList}
	<tr align="center">
		<td class="row1" width="30%">
		<a href="index.php?page=profile&amp;show=1&amp;usernam={$GetTeamList['username']}">{$GetTeamList['username']}</a>
		</td>
		<td class="row1" width="20%">
		{$GetTeamList['user_title']}
		</td>
	</tr>
{/Des::while}
</table>
<br />
