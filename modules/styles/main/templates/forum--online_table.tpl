{hook}before_online_table{/hook}

<br />

<table id="online_table" border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td width="98%" class="main1 rows_space">
		{$lang['online_now']} {$lang['common']['colon']} ({$MemberNumber}) {$lang['common']['member']} {$lang['common']['and']} ({$GuestNumber}) {$lang['common']['visitor']}
		</td>
	</tr>
	<tr>
		<td width="98%" class="row2 rows_space">
		{DB::getInfo}{$online_res}{$SectionVisitor}
		<a href="{$init_path}profile/{$SectionVisitor['username']}">{$SectionVisitor['username']}</a>،
		{/DB::getInfo}

		{if {$_CONF['info_row']['show_onlineguest']} != 1}
		{if {$MemberNumber} <= 0}
				{$lang['no_member_online']}
		{/if}
		{/if}
		</td>
	</tr>
</table>

<br />

{hook}after_online_table{/hook}
