<form method="post" action="index.php?page=management&amp;move=1&amp;section={$section}&amp;subject_id={$subject}">
<table align="center" border="1" class="t_style_b" width="50%">
	<tr align="center">
		<td class="main1 rows_space" width="50%">
			نقل الموضوع إلى
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
        	<select size="1" name="section" id="section_id">
        		{Des::foreach}{forums_list}{forum}
        		{if {$forum['parent']} == 0}
				<option value="{$forum['id']}" disabled="disabled">- {$forum['title']}</option>
				{else}
				<option value="{$forum['id']}" selected="selected">-- {$forum['title']}</option>
				{/if}
				{/Des::foreach}
			</select>
			<input type="submit" value="موافق" />
		</td>
	</tr>
</table>
