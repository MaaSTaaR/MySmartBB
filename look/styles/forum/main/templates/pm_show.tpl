{template}usercp_menu{/template}

{template}address_bar_part1{/template}
<a href="index.php?page=pm&amp;list=1&amp;folder=inbox">الرسائل الخاصه</a> {$_CONF['info_row']['adress_bar_separate']} قراءة الرساله : {$MassegeRow['title']}
{template}address_bar_part2{/template}

	<table border="1" class="t_style_b" width="96%" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
				<img src="{$MassegeRow['icon']}" border="0" /> {$MassegeRow['title']}
			</td>
		</tr>
      	<tr align="center">
        	<td class="main2" width="20%">
        		الكاتب
        	</td>
        	<td class="main2" width="50%">
        		النص
        	</td>
      	</tr>
      	<tr>
      	<td class="row1" width="25%" valign="top">
      		{template}writer_info{/template}
      	</td>
		<td class="row1" width="50%">
			{$MassegeRow['text']}
			
			{if {$Info['user_sig']} != ''}
				{template}signature_show{/template}
			{/if}
			{if {$ATTACH_SHOW}}
				{template}attach_show{/template}
			{/if}
		</td>
		</tr>
      	<tr align="center">
        	<td class="row1" width="20%">
        		بتاريخ : {$MassegeRow['date']}
        	</td>
        	<td class="row1" width="50%">
        	</td>
      	</tr>
</table>

</td>
</tr>
</table>

<br />

{template}pm_send{/template}

<br />
