<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">المشرفين</a> &raquo; تحكم</div>

<br />


<table width="40%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space">
		اسم المنتدى
		</td>
	</tr>
	{Des::foreach}{forums_list}
	<tr align="center">
		<td class="row1">
			<a href="admin.php?page=moderators&amp;control=1&amp;section=1&amp;id={#id#}">{#title#}</a>
		</td>
	</tr>
	{/Des::foreach}
</table>
