{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} <a href="index.php?page=usercp&amp;index=1">المواضيع المفضله</a> {$_CONF['info_row']['adress_bar_separate']} اضافة موضوع
{template}address_bar_part2{/template}

﻿<form method="post" action="index.php?page=usercp&bookmark=1&amp;add=1&amp;start=1&amp;subject_id={$subject}">
<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
			إضافة الموضوع الى المفضلة 		
		</td>
	</tr>
	<tr>
		<td class="row1 rows_space" width="30%">
			سبب إضافة الموضوع (يمكن تركه فارغاً)
		</td>
		<td class="row2 rows_space" width="30%">
			<input name="reason" type="text" />
		</td>
	</tr>
</table>

<br />

<div align="center">
	<input type="submit" value="موافق" />
</div>
</form>
