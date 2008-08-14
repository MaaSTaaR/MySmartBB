<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">المنتديات</a> &raquo; <a href="admin.php?page=forums&amp;groups=1&amp;main=1">صلاحيات المجموعات</a> &raquo; <a href="admin.php?page=forums&amp;groups=1&amp;show_group=1&amp;id={$Inf['id']}">التحكم في صلاحيات المجموعات للقسم : {$Inf['title']}</a> &raquo; التحكم في صلاحيات المجموعه : {$GroupInf['title']}</div>

<br />

<form action="admin.php?page=forums&amp;groups=1&amp;control_group=1&amp;start=1&amp;group_id={$SecGroupInf['id']}&amp;gid={$GroupInf['id']}" name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">تحرير صلاحيات المجموعه : {$GroupInf['title']}</td>
</tr>
<tr valign="top">
		<td class="row1">إمكانية عرض القسم</td>
		<td class="row1">
<select name="view_section" id="select_view_section">
	{if}{{$SecGroupInf['view_section']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">تحميل المرفقات</td>
		<td class="row2">
<select name="download_attach" id="select_download_attach">
	{if}{{$SecGroupInf['download_attach']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">رفع المرفقات</td>
		<td class="row1">
<select name="upload_attach" id="select_upload_attach">
	{if}{{$SecGroupInf['upload_attach']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>

</td>
</tr>
<tr valign="top">
		<td class="row2">كتابة موضوع</td>
		<td class="row2">
<select name="write_subject" id="select_write_subject">
	{if}{{$SecGroupInf['write_subject']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>

</tr>
<tr valign="top">
		<td class="row1">كتابة رد</td>
		<td class="row1">
<select name="write_reply" id="select_write_reply">
	{if}{{$SecGroupInf['write_reply']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>

<tr valign="top">
		<td class="row2">تحرير موضوعه الخاص</td>
		<td class="row2">
<select name="edit_own_subject" id="select_edit_own_subject">
	{if}{{$SecGroupInf['edit_own_subject']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">

		<td class="row1">تحرير رده الخاص</td>
		<td class="row1">
<select name="edit_own_reply" id="select_edit_own_reply">
	{if}{{$SecGroupInf['edit_own_reply']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">حذف موضوعه الخاص</td>

		<td class="row2">
<select name="del_own_subject" id="select_del_own_subject">
	{if}{{$SecGroupInf['del_own_subject']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">حذف رده الخاص</td>
		<td class="row1">

<select name="del_own_reply" id="select_del_own_reply">
	{if}{{$SecGroupInf['del_own_reply']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">كتابة استفتاء</td>
		<td class="row2">
<select name="write_poll" id="select_write_poll">
	{if}{{$SecGroupInf['write_poll']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row1">تصويت في استفتاء</td>
		<td class="row1">
<select name="vote_poll" id="select_vote_poll">
	{if}{{$SecGroupInf['vote_poll']}}{if}
	<option value="1" selected="selected">نعم</option>
	<option value="0">لا</option>
	{/comif}
	{else}
	<option value="1">نعم</option>
	<option value="0" selected="selected">لا</option>
	{/else}
</select>
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="موافق" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>



