{template}usercp_menu{/template}

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} قائمة مواضيعك
{template}address_bar_part2{/template}

  	<table border="1" class="t_style_b" width="80%" align="center">
  		<tr align="center">
  			<td class="main1 rows_space" colspan="4">
     		مواضيعك
     		</td>
    	</tr>
    	<tr align="center">
    		<td class="main2" width="6%">
    		</td>
      		<td  class="main2" width="80%">
      		عنوان الموضوع
      		</td>
      		<td  class="main2" width="14%">
      		كاتب الموضوع
      		</td>
    	</tr>
    {Des::while}{MemberSubjects}
    <tr>
    	<td class="row1" width="6%" align="center">
    		<img src="{$_CONF['info_row']['icon_path']}{$MemberSubjects['icon']}" border="0">
    	</td>
      	<td class="row1" width="80%">
      		<a href="index.php?page=topic&amp;show=1&id={$MemberSubjects['id']}">{$MemberSubjects['title']}</a>
      	</td>
      	<td class="row1" width="14%" align="center">
      		<a href="index.php?page=profile&amp;show=1&username={$MemberSubjects['writer']}">{MemberSubjects['writer']}</a>
      		<br />
      		{$MemberSubjects['write_date']}
      	</td>
    </tr>
    {/Des::while}

  </table>
  

</td>
</tr>
</table>
<br />
