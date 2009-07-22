{template}address_bar_part1{/template}
مواضيع المنتدى المميزه
{template}address_bar_part2{/template}

<br />
<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
	<tr valign="top" align="center">
    	<td class="main1" width="3">
    	</td>
		<td class="main1">
		عنوان الموضوع
		</td>
		<td class="main1">
		الكاتب
		</td>
	</tr>
	{Des::while}{SpecialSubjectList}
	<tr valign="top" align="center">
		<td class="row2" width="3">
			<img border="0" src="{$image_path}/special.png" alt="موضوع مميز" />
		</td>
		<td class="row1">
			<a href="index.php?page=topic&amp;show=1&amp;id={$SpecialSubjectList['id']}">
				{$SpecialSubjectList['title']}
			</a>
		</td>
		<td class="row2">
			<a href="index.php?page=profile&amp;show=1&amp;username={$SpecialSubjectList['writer']}">
				{$SpecialSubjectList['writer']}
			</a>
		</td>
	</tr>
	{/Des::while}
</table>

<br />
<br />
