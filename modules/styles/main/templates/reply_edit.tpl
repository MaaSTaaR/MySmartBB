<br />

<form name="topic" method="post" action="{$edit_page}">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الرد
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			عنوان الرد : 	<input name="title" type="text" value="{$ReplyInfo['title']}" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69">{$ReplyInfo['text']}</textarea>
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
