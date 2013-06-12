{hook}before_forum_password_form_table{/hook}

<br />
<table id="forum_password_form_table" cellpadding="2" cellpadding="2" border="1" class="t_style_b" width="50%" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="50%">
		{$lang['password_proctected']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
			<form method="post" action="{$init_path}check_forum_password/{$section_id}">
				<input name="password" type="password" />
				<input name="button" type="submit" value="{$lang['common']['submit']}" />
			</form>
		</td>
	</tr>
</table>

<br />

{hook}after_forum_password_form_table{/hook}
