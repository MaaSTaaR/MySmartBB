<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=plugin&amp;control=1&amp;main=1">نظام الإضافات</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr align="center">
	<td class="main1" colspan="3">الإضافات المُثبته</td>
</tr>
<tr align="center">
	<td class="main1">اسم الإضافة</td>
	<td class="main1">تعطيل\تفعيل</td>
	<td class="main1">إلغاء التثبيت</td>
</tr>
{DB::getInfo}{$installed}
<tr align="center">
	<td class="row1">{$installed['title']}</td>
	<td class="row1">
		{if {$installed['active']} == 1}
		<a href="admin.php?page=plugins&amp;deactive=1&amp;id={$installed['id']}">تعطيل</a>
		{else}
		<a href="admin.php?page=plugins&amp;active=1&amp;id={$installed['id']}">تفعيل</a>
		{/if}
	</td>
	<td class="row1"><a href="admin.php?page=plugins&amp;uninstall=1&amp;main=1&amp;id={$installed['id']}">إلغاء التثبيت</a></td>
</tr>
{/DB::getInfo}
</table>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr align="center">
	<td class="main1" colspan="2">إضافات قابلة للتثبيت</td>
</tr>
<tr align="center">
	<td class="main1">مسار الإضافة</td>
	<td class="main1">تثبيت</td>
</tr>
{Des::foreach}{uninstalled_list}{list}
<tr align="center">
	<td class="row1">{$list}</td>
	<td class="row1"><a href="admin.php?page=plugins&amp;install=1&amp;path={$list}">تثبيت</a></td>
</tr>
{/Des::foreach}
</table>
