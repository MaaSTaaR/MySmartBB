<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=announcement&amp;control=1&amp;main=1">الاعلانات الاداريه</a> &raquo; تحرير : {$AnnInfo['title']}</div>

<br />

<form action="admin.php?page=announcement&amp;edit=1&amp;start=1&amp;id={$AnnInfo['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
			تحرير اعلان
			</td>
		</tr>
		<tr>
			<td class="row1">
			العنوان
			</td>
			<td class="row1">
				<input type="text" name="title" value="{$AnnInfo['title']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			النص
			</td>
			<td class="row2">
				<textarea name="text" id="textarea_text" rows="10" cols="40" wrap="virtual" dir="rtl">{$AnnInfo['text']}</textarea>
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>

	<br />
	
</form>
