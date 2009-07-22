{template}usercp_menu{/template}

<div class="usercp_context">
	{template}address_bar_part1{/template}
	<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} المفضلة
	{template}address_bar_part2{/template}

 	  	<table border="1" class="t_style_b" width="80%" align="center">
  		<tr align="center">
  			<td class="main1 rows_space" colspan="3">
 المواضيع التي قمت بإضافتها الى المفضلة الخاصة بي 
 			</td>
    	</tr>
		<tr>
			<td width="30%" class="main1 rows_space small_text" align="center" colspan="2">
			عنوان الموضوع
			</td>
			<td width="28%" class="main1 rows_space small_text" align="center">
			سبب الإضافة إلى المفضلة
			</td>
		</tr>
    	{Des::while}{MemberSubjects}    	
		<tr>
			<td width="3%" class="row1" align="center">
				<a href="index.php?page=usercp&amp;bookmark=1&amp;del=1&id={$MemberSubjects['subject_id']}">	
					<img border="0" src="{$image_path}/trash.gif" alt="حذف">
				</a>
			</td>
			<td width="30%" class="row2">
				<a href="index.php?page=topic&show=1&id={$MemberSubjects['subject_id']}">
					{$MemberSubjects['subject_title']}
				</a> 
			</td>
			<td width="28%" class="row2" align="center">
				<span class="small">{$MemberSubjects['reason']}</span>
			</td>
		</tr>
    	{/Des::while}
	</table>
</div>
