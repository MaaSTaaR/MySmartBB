<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=usertitle&amp;control=1&amp;main=1">مسميات الاعضاء</a> &raquo; تحرير : {$Inf['usertitle']}</div>

<br />

<form action="admin.php?page=usertitle&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			تحرير مسمى
			</td>
		</tr>
		<tr>
			<td class="row1">
			المسمى
			</td>
			<td class="row1">
				<input type="text" name="title" value="{$Inf['usertitle']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			المشاركات
			</td>
			<td class="row2">
				<input type="text" name="posts" value="{$Inf['posts']}" />
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
	<br />
</form>

