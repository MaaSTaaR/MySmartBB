<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td width="98%" class="main1 rows_space">
		المتواجدين في القسم حالياً : ({$MemberNumber}) عضو و ({$GuestNumber}) زائر
		</td>
	</tr>
	<tr>
		<td width="98%" class="row2 rows_space">
		{Des::while}{SectionVisitor}
		<a href="index.php?page=profile&amp;show=1&amp;username={$SectionVisitor['username']}">{$SectionVisitor['username']}</a>،
		{/Des::while}

		{if {{$_CONF['info_row']['show_onlineguest']}} == 1}
		{if {{$MemberNumber}}+{{$GuestNumber}} <= 0}
		لا يوجد اي شخص في هذا القسم
		{else}
		{if}{{$MemberNumber}} <= 0{if}
		لا يوجد اعضاء يتصفحون هذا القسم حالياً
		{/if}
		{/if}
		</td>
	</tr>
</table>

<br />
