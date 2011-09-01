<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=extension&amp;search=1&amp;main=1">البحث بالمرفقات</a> &raquo; <a href="admin.php?page=extension&amp;search=1&amp;main=1">بحث</a> &raquo; نتيجة البحث</div>

<br />

<div align="center">

	<table width="90%" class="t_style_b" border="1">
		<tr align="center">
			<td class="main1">
			اسم الملف
			</td>
			<td class="main1">
			مرات التحميل
			</td>
			<td class="main1">
			حجم الملف
			</td>
			<td class="main1">
			مشاهدة المشاركة
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
				<a href="./index.php?page=download&amp;attach=1&amp;id={$Inf['id']}">{$Inf['filename']}</a>
			</td>
			<td class="row1">
				{$Inf['visitor']}
			</td>
			<td class="row1">
				{$Inf['filesize']}
			</td>
			<td class="row1">
				<a href="./index.php?page=topic&amp;show=1&amp;id={$Inf['subject_id']}" target="_blank">[مشاهدة المشاركة‎]‏</a>
			</td>
		</tr>
	</table>
</div>
