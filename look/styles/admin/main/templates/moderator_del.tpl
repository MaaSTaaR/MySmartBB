<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">المشرفين</a> &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;section=1&amp;id={$Section['id']}">{$Section['title']}</a> &raquo; إلغاء : {$Inf['username']}</div>

<br />

<table width="50%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">
		تأكيد إلغاء الاشراف
		</td>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2">
		هل انت متأكد من رغبتك بإلغاء اشراف {$Inf['username']}؟
		</td>
	</tr>
	<tr align="center">
		<td class="row1">
			<a href="admin.php?page=moderators&amp;del=1&amp;start=1&amp;id={$Inf['id']}">نعم</a>
		</td>
		<td class="row1">
			<a href="admin.php?page=moderators&amp;control=1&amp;main=1">لا</a>
		</td>
	</tr>
</table>
