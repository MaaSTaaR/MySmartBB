{template}usercp_menu{/template}

<div class="usercp_context">
{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} قائمة مواضيعك
{template}address_bar_part2{/template}

<table border="1" class="t_style_b" width="80%" align="center">
	<tr align="center">
  		<td class="main1 rows_space" colspan="5">
     		آخر المواضيع التي قمت بكتابتها
     	</td>
    </tr>
	<tr>
		<td width="30%" class="main1 rows_space small_text" align="center" colspan="2">
			عنوان الموضوع
		</td>
		<td width="10%" class="main1 rows_space small_text" align="center">
			عدد الردود
		</td>
		<td width="10%" class="main1 rows_space small_text" align="center">
			عدد الزوار
		</td>
		<td width="28%" class="main1 rows_space small_text" align="center">
			آخر رد
		</td>
	</tr>
    {Des::while}{MemberSubjects}
		<tr>
			<td width="3%" class="row1" align="center">
				<img src="{$MemberSubjects['icon']}" alt="" />
			</td>
			<td width="30%" class="row2">
				<a href="index.php?page=topic&show=1&id={$MemberSubjects['id']}">
					{$MemberSubjects['title']}
				</a> 
				{if {$MemberSubjects['close']}}
				<small>(مغلق)</small>
				{/if}
				<br />
				<font class="small">{$MemberSubjects['subject_describe']}</font>
			</td>
			<td width="8%" class="row2" align="center">
				{$MemberSubjects['reply_number']}
			</td>
			<td width="8%" class="row1" align="center">
				{$MemberSubjects['visitor']}
			</td>
			<td width="28%" class="row2" align="center">
				{if {$MemberSubjects['reply_number']} <= 0}
			لا يوجد ردود
				{else}
				{$MemberSubjects['reply_date']} بواسطة <a href="index.php?page=profile&show=1&username={$MemberSubjects['last_replier']}">{$MemberSubjects['last_replier']}</a>
				{/if}
			</td>
		</tr>
    {/Des::while}
</table>

</div>
