{template}usercp_menu{/template}

<div class="usercp_context">
<table border="1" class="t_style_b" width="%85" align="center">
	<tr align="center">
		<td width="95%" class="main1 rows_space" colspan="4">
			الرسائل الخاصه
		</td>
	</tr>
	<tr align="center">
		<td class="main2" width="5%">
			حذف
		</td>
		<td class="main2" width="20%">
			عنوان الرساله
		</td>
		<td class="main2" width="20%">
			المرسل
		</td>
		<td class="main2" width="20%">
			تاريخ الارسال
		</td>
	</tr>
	{Des::while}{MassegeList}
	<tr align="center">
		<td class="row1" width="5%">
			<a href="index.php?page=pm&amp;cp=1&amp;del=1&amp;id={$MassegeList['id']}"><img alt="حذف" src="{$image_path}/trash.gif" border="0" />
		</td>
		<td class="row1" width="20%">
			<a href="index.php?page=pm&amp;show=1&amp;id={$MassegeList['id']}">{$MassegeList['title']}</a>
			<br />
			{if {$MassegeList['user_read']} == 1}
			<font class="readpm">رسالة مقروءه</font>
			{else}
			<font class="unreadpm">رساله جديده</font>
			{/if}
		</td>
		<td class="row1" width="20%">
			<a href="index.php?page=profile&amp;show=1&amp;username={$MassegeList['user_from']}">{$MassegeList['user_from']}</a>
		</td>
		<td class="row1" width="20%">
			{$MassegeList['date']}
		</td>
	</tr>
	{/Des::while}
</table>

<br />

{$pager}

<br />

</div>
