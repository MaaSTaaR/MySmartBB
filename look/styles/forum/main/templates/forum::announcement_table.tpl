<table border="1" class="t_style_b" width="98%" align="center">
	<tr>
		<td width="98%" align="center" class="main1 rows_space">
			الاعلانات الاداريه
		</td>
	</tr>
	<tr>
		{Des::while}{AnnouncementList}
		<td width="98%" class="row1 rows_space">
			<a href="index.php?page=announcement&amp;show=1&amp;id={$AnnouncementList['id']}">
			{$AnnouncementList['title']}
			</a> 
			بواسطة 
			<a href="index.php?page=profile&amp;show=1&amp;username={$AnnouncementList['writer']}">
			{$AnnouncementList['writer']}
			</a> 
			
			بتاريخ {$AnnouncementList['date']}
		</td>
		{/Des::while}
	</tr>
</table>

<br />
