<br />

<!--
<form name="topic" method="post" action="{$edit_page}">
-->

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['subject_context']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			{$lang['subject_title']} {$lang['common']['colon']} <input name="title" type="text" value="{$SubjectInfo['title']}" />
		</td>
		<td class="row1 rows_space">
			{$lang['subject_description']} <small>{$lang['optional']}</small> {$lang['common']['colon']} <input name="describe" type="text" value="{$SubjectInfo['describe']}" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69">{$SubjectInfo['text']}</textarea>
			<!-- 
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
			-->
		</td>
	</tr>
</table>

<br />

<!--

</form>
 -->
 
<br />
