{template}usercp_menu{/template}

<div class="usercp_context">
	<table border="1" class="t_style_b" width="80%" align="center">
    	<tr align="center">
      		<td class="main1 rows_space" colspan="4">
      		آخر المواضيع المشترك بها
      		</td>
    	</tr>
    	<tr align="center">
    	    <td class="main2" width="6%">
      			
      		</td>
      		<td class="main2" width="80%">
      			عنوان الموضوع
      		</td>
      		<td class="main2" width="14%">
      			كاتب الموضوع
      		</td>
    	</tr>
  	</table>
  	
  	<br />
  	
  	<table border="1" class="t_style_b" width="80%" align="center">
  		<tr align="center">
  			<td class="main1 rows_space" colspan="4">
     		آخر المواضيع التي قمت بكتابتها
     		</td>
    	</tr>
    	<tr align="center">
    		<td class="main2" width="6%">
    		</td>
      		<td  class="main2" width="80%">
      		عنوان الموضوع
      		</td>
      		<td  class="main2" width="14%">
      		آخر رد
      		</td>
    	</tr>
    	{Des::while}{MemberSubjects}
    	<tr align="center">
    		<td class="row1" width="6%">
    			<img src="{$_CONF['info_row']['icon_path']}{$MemberSubjects['icon']}" alt="" />
    		</td>
      		<td  class="row2" width="80%">
      			<a href="index.php?page=topic&amp;show=1&amp;id={$MemberSubjects['id']}">{$MemberSubjects['title']}</a>
				{if {$MemberSubjects['close']}}
				<small>(مغلق)</small>
				{/if}
			<br />
			<font class="small">{$stick_subject_list['subject_describe']}</font>
      		</td>
      		<td  class="row1" width="14%">
      		{if {$MemberSubjects['reply_number']} <= 0}
			لا يوجد ردود
			{else}
			<a href="index.php?page=profile&show=1&username={$MemberSubjects['last_replier']}">{$MemberSubjects['last_replier']}</a><br />
			{$MemberSubjects['reply_date']}
			{/if}
      		</td>
    	</tr>
    	{/Des::while}
	</table>

</div>
