<br />

<form name="topic" method="post" action="{$edit_page}">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الموضوع
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			عنوان الموضوع : <input name="title" type="text" value="{$SubjectInfo['title']}" />
		</td>
		<td class="row1 rows_space">
			وصف الموضوع <small>(اختياري)</small> : <input name="describe" type="text" value="{$SubjectInfo['describe']}" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69">{$SubjectInfo['text']}</textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="موافق" />
		</td>
	</tr>
</table>

<br />

{template}smilebox{/template}

</form>

<br />
