<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="">نقل جماعي</a></div>

<br />

<form action="admin.php?page=subject&amp;mass_move=1&amp;start=1" method="post">
	<table width="40%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			نقل جماعي
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			من القسم
			</td>
			<td class="row2">
				<select name="from" id="select_from">
				{DB::getInfo}{$SectionList}
					<option value="{$SectionList['id']}">{$SectionList['title']}</option>
				{/DB::getInfo}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
			الى القسم
			</td>
			<td class="row2">
				<select name="to" id="select_to">
				{DB::getInfo}{$SectionList}
					<option value="{$SectionList['id']}">{$SectionList['title']}</option>
				{/DB::getInfo}
				</select>
			</td>
		</tr>
	</table>
	
	<br />

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
	
	<br />
</form>
