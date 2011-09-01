{template}address_bar_part1{/template}
الاحصائيات
{template}address_bar_part2{/template}

<br />

<table border="1" width="95%" class="t_style_b" align="center">
	<tr align="center">
		<td width="10%" class="main1 rows_space">
		عمر المنتدى بالايام
		</td>
		<td width="20%" class="main1 rows_space">
		تاريخ انشاء المنتدى
		</td>
		<td width="10%" class="main1 rows_space">
		عدد الاعضاء
		</td>
		<td width="10%" class="main1 rows_space">
		عدد المواضيع
		</td>
		<td width="10%" class="main1 rows_space">
		عدد الردود
		</td>
		<td width="10%" class="main1 rows_space">
		عدد الاعضاء النشيطين
		</td>
		<td width="10%" class="main1 rows_space">
		عدد المنتديات
		</td>
	</tr>
	<tr align="center">
		<td width="10%" class="row1">
		{$StaticInfo['Age']} يوم
		</td>
		<td width="20%" class="row1">
		{$StaticInfo['InstallDate']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetMemberNumber']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetSubjectNumber']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetReplyNumber']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetActiveMember']}
		</td>
		<td width="10%" class="row1">
		{$StaticInfo['GetSectionNumber']}
		</td>
	</tr>
</table>

<br />

<table border="1" width="95%" class="t_style_b" align="center">
	<tr align="center">
		<td class="main1 rows_space1">
		كاتب اقدم موضوع
		</td>
		<td class="main1 rows_space">
		كاتب احدث موضوع
		</td>
		<td class="main1 rows_space">
		كاتب اكثر المواضيع ردوداً
		</td>
	</tr>
	<tr align="center">
		<td class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;username={$StaticInfo['OldestSubjectWriter']}">{$StaticInfo['OldestSubjectWriter']}</a>
		</td>
		<td class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;username={$StaticInfo['NewerSubjectWriter']}">{$StaticInfo['NewerSubjectWriter']}</a>
		</td>
		<td class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;username={$StaticInfo['MostSubjectWriter']}">{$StaticInfo['MostSubjectWriter']}</a>
		</td>
	</tr>
</table>

<br />

<table border="1" width="50%" class="t_style_b" align="center">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		انشط الكتّاب من حيث عدد المشاركات
		</td>
	</tr>
	{DB::getInfo}{$topten_res}{$TopTenList}
	<tr align="center">
		<td width="30%" class="row1">
		<a href="index.php?page=profile&amp;show=1&amp;id={$TopTenList['id']}">{$TopTenList['username']}</a>
		</td>
		<td width="20%" class="row1">
		{$TopTenList['posts']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

<table border="1" width="50%" class="t_style_b" align="center">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		انشط المواضيع من حيث عدد الردود
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
		عنوان الموضوع
		</td>
		<td width="20%" class="row1">
		عدد الردود
		</td>
	</tr>
	{DB::getInfo}{$topsubject_res}{$TopSubject}
	<tr align="center">
		<td width="30%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$TopSubject['id']}">{$TopSubject['title']}</a>
		</td>
		<td width="20%" class="row1">
		{$TopSubject['reply_number']}
		</td>
	</tr>
	{/DB::getInfo}
</table>

<br />

<table border="1" width="50%" class="t_style_b" align="center">
	<tr align="center">
		<td width="50%" class="main1 rows_space" colspan="2">
		انشط المواضيع من حيث عدد الزيارات
		</td>
	</tr>
	<tr align="center">
		<td width="30%" class="row1">
		عنوان الموضوع
		</td>
		<td width="20%" class="row1">
		عدد الزوار
		</td>
	</tr>
	{DB::getInfo}{$topvisit_res}{$TopSubjectVisitor}
	<tr align="center">
		<td width="30%" class="row1">
		<a href="index.php?page=topic&amp;show=1&amp;id={$TopSubjectVisitor['id']}">{$TopSubjectVisitor['title']}</a>
		</td>
		<td width="20%" class="row1">
		{$TopSubjectVisitor['reply_number']}
		</td>
	</tr>
	{/DB::getInfo}
</table>


<br />
