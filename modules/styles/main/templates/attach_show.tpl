<br />

<table border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="50%" align="center">
	<tr align="center">
		<td width="30%" class="main1">
			اسم الملف
		</td>
		<td width="20%" class="main1">
			مرات التحميل
		</td>
	</tr>
	{DB::getInfo}{$AttachList}
	<tr align="center">
		<td width="30%" class="row1">
			<a href="index.php?page=download&amp;attach=1&amp;id={$AttachList['id']}">{$AttachList['filename']}</a>
		</td>
		<td width="20%" class="row2">
			{$AttachList['visitor']}
		</td>
	</tr>
	{/DB::getInfo}
</table>
