<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">المنتديات</a></div>

<br />

<form action="admin.php?page=forums_sort&amp;change_sort=1" method="post">
<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">

<tr valign="top" align="center">
	<td class="main1">عنوان القسم</td>
	<td class="main1">الصلاحيات</td>
	<td class="main1">تحرير</td>
	<td class="main1">حذف</td>
	<td class="main1">ترتيب القسم</td>
</tr>
{Des::foreach}{forums_list}{forum}
<tr valign="top" align="center">
	{if {$forum['parent']} == 0}
	<td class="main2" colspan="5">{$forum['title']}</td>
	{else}
	<td class="row1">
		<a href="admin.php?page=forums&amp;forum=1&amp;index=1&amp;id={$forum['id']}">{$forum['title']}</a>
	</td>
	<td class="row1"><a href="./admin.php?page=forums_groups&amp;control_group=1&amp;index=1&amp;id={$forum['id']}">الصلاحيات</a></td>
	<td class="row1"><a href="./admin.php?page=forums_edit&amp;main=1&amp;id={$forum['id']}">تحرير</a></td>
	<td class="row1"><a href="./admin.php?page=forums_del&amp;main=1&amp;id={$forum['id']}">حذف</a></td>
	<td class="row1"><input type="text" name="order-{$forum['id']}" id="input_order-{$forum['id']}" value="{$forum['sort']}" size="5" /></td>
	{/if}
</tr>
{/Des::foreach}
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
