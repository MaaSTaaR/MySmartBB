{template}address_bar_part1{/template}
العلامات
{template}address_bar_part2{/template}

<div align="center">
	<strong>المواضيع التي تستخدم <em>{$tag}</em> كعلامه</strong>
</div>

<br />

{$pager}

<br />

<table border="1" class="t_style_b" width="60%" align="center">
	<tr align="center">
		<td width="80%" class="main1 rows_space" colspan="2">
		عناوين المواضيع
		</td>
	</tr>
	{Des::while}{Subject}
	<tr align="center">
		<td width="80%" class="row1 rows_space" colspan="2">
			<a href="index.php?page=topic&amp;show=1&amp;id={$Subject['subject_id']}">{$Subject['subject_title']}</a>
		</td>
	</tr>
	{/Des::while}
</table>

<br />
