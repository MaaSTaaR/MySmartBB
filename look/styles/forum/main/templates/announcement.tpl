{template}address_bar_part1{/template}
<a href="index.php?page=annoncement&amp;list=1&amp;main=1">الاعلانات الاداريه</a> {$_CONF['info_row']['adress_bar_separate']} {$AnnInfo['title']}
{template}address_bar_part2{/template}

<br />

<table border="1" class="t_style_b" width="40%" align="center">
	<tr align="center">
		<td width="20%" class="row1">
			عنوان الاعلان
		</td>
		<td width="20%" class="row1">
			{$AnnInfo['title']}
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
			تاريخ الاعلان
		</td>
		<td width="20%" class="row1">
			{$AnnInfo['date']}
		</td>
	</tr>
	<tr align="center">
		<td width="20%" class="row1">
			كاتب الاعلان
		</td>
		<td width="20%" class="row1">
			<a href="index.php?page=profile&amp;show=1&amp;username={$AnnInfo['writer']}">{$AnnInfo['writer']}</a>
		</td>
	</tr>
</table>

<br />

<table border="1" class="t_style_b" width="70%" align="center">
	<tr>
		<td width="70%" class="row1">
		{$AnnInfo['text']}
		</td>
	</tr>
</table>

<br />
