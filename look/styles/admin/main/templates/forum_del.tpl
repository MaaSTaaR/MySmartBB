<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">المنتديات</a> &raquo; تأكيد حذف : {$Inf['title']}</div>

<br />

	<form action="admin.php?page=forums&amp;del=1&amp;start=1&amp;id={$Inf['id']}" method="post">
		<p align="center">انت الآن مُقدم على حذف منتدى</p>
		
		<table width="60%" class="t_style_b" border="0" align="center">
			<tr valign="top">
				<td class="row1">
				ما الذي تريد فعله؟
				</td>
				<td class="row1">
					<select name="choose" id="select_choose">
						<option value="move">نقل جميع المواضيع و الردود</option>
						<option value="del">حذف جميع المواضيع و الردود</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<td class="row2">
				نقل إلى
				</td>
				<td class="row2">
					<select name="to" id="select_to">
					{Des::while}{SecList}
						<option value="{$SecList['id']}">{$SecList['title']}</option>
					{/Des::while}
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
