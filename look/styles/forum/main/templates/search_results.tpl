{template}address_bar_part1{/template}
نتائج البحث
{template}address_bar_part2{/template}

<br />
<table border="1" width="80%" class="t_style_b" align="center">
	<tr align="center">
		<td width="20%" class="main1 rows_space">
		عنوان الموضوع
		</td>
		<td width="20%" class="main1 rows_space">
		كاتب الموضوع
		</td>
		<td width="10%" class="main1 rows_space">
		عدد الزيارات
		</td>
		<td width="10%" class="main1 rows_space">
		عدد الردود
		</td>
		<td width="20%" class="main1 rows_space">
		تاريخ الكتابه
		</td>
	</tr>
{Des::while}{SearchResult}
	<tr align="center">
		<td width="20%" class="row1">
			<a href="index.php?page=topic&amp;show=1&amp;highlight={$highlight}&amp;id={$SearchResult['id']}">{$SearchResult['title']}</a>
		</td>
		<td width="20%" class="row1">
			<a href="index.php?page=profile&amp;show=1&amp;username={$SearchResult['writer']}">{$SearchResult['writer']}</a>
		</td>
		<td width="10%" class="row1">
		{$SearchResult['visitor']}
		</td>
		<td width="10%" class="row1">
		{$SearchResult['reply_number']}
		</td>
		<td width="20%" class="row1">
		{$SearchResult['write_date']}
		</td>
	</tr>
{/Des::while}
</table>

<br />
