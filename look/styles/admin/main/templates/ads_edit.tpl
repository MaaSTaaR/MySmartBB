<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=ads&amp;control=1&amp;main=1">الاعلانات التجاريه</a> &raquo; تحرير : {$Inf['sitename']}</div>

<br />

<form action="admin.php?page=ads&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b rows_space" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			اضافة إعلان جديد
			</td>
		</tr>
		<tr>
			<td class="row1">
			اسم الموقع
			</td>
			<td class="row1">
				<input type="text" name="name" value="{$Inf['sitename']}" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			الوصله
			</td>
			<td class="row2">
				<input type="text" name="link" value="{$Inf['site']}" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			وصلة الصوره
			</td>
			<td class="row1">
				<input type="text" name="picture" value="{$Inf['picture']}" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			طول الصوره - غير ضروري
			</td>
			<td class="row2">
				<input type="text" name="width" value="{$Inf['width']}" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			عرض الصوره - غير ضروري
			</td>
			<td class="row1">
				<input type="text" name="height" value="{$Inf['height']}" size="30" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
<br />

</form>
