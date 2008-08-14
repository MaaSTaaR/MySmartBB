<div align="center" dir="rtl">
{Des::foreach}{forums_list}{forum}
	{if {{$SHOW_SUB_SECTIONS}}}
		<table width="98%" border="1" width="98%" class="t_style_b" align="center">
		<tr align="right">
			<td class="main1 rows_space" colspan="3" align="center">
				المنتديات الفرعيه
			</td>
		</tr>
		<tr align="center">
			<td class="main2 rows_space small_text" width="55%" colspan="2">
				المنتدى
			</td>
			<td class="main2 rows_space small_text" width="45%">
				التفاصيل
			</td>
		</tr>
	{/if}
	{if {{$forum['parent']}} == 0}
		{if {{$forum['sort']}} != 1}
		</table>
		<br />
		{/if}
		<table width="98%" border="1" width="98%" class="t_style_b" align="center">
		<tr align="right">
			<td class="main1 rows_space" colspan="3" align="center">
				{$forum['title']}
			</td>
		</tr>
		<tr align="center">
			<td class="main2 rows_space small_text" width="55%" colspan="2">
				المنتدى
			</td>
			<td class="main2 rows_space small_text" width="45%">
				التفاصيل
			</td>
		</tr>
	{/if}
	{if {{$forum['parent']}} != 0}
		{if {{$forum['linksection']}} != '1'}
			<tr align="right">
				<td class="row1" rowspan="2" width="5%" align="center">
				{if {{$forum['use_section_picture']}} == 1}
					{if {{$forum['sectionpicture_type']}} == 1}
						<img src="{$forum['section_picture']}" alt="" />
					{else}
						<img src="{$image_path}/icon-67_new.gif" alt="" />
					{/if}
				{else}
					<img src="{$image_path}/icon-67_new.gif" alt="" />
				{/if}
			</td>
			<td class="row2 rows_space" width="50%">
					<a href="index.php?page=forum&amp;show=1&amp;id={$forum['id']}">{$forum['title']}</a>
					<br />
					{if {{$forum['use_section_picture']}} == 1}
						{if {{$forum['sectionpicture_type']}} == 2}
							<img src="{$forum['section_picture']}" alt="" />
							<br />
						{/if}
					{/if}
					{if {{$forum['describe']}} != ''}
					{$forum['describe']}
					<br />
					{/if}
							المواضيع : {$forum['subject_num']}
							 ، الردود : {$forum['reply_num']}
					</td>
					<td class="row1 rows_space" width="45%">
					
					{if {{$forum['last_subject']}} != ''}
												آخر مشاركه : 
												
					<a href="index.php?page=topic&amp;show=1&amp;id={$forum['last_subjectid']}">{$forum['last_subject']}</a> 
												
												بواسطة 
												
												<a href="index.php?page=profile&amp;show=1&amp;username={$forum['last_writer']}">{$forum['last_writer']}</a> 
												
												بتاريخ 
												
												{$forum['last_date']}
						<br />
						
					{else}
					لا توجد مشاركات
					{/if}
				
						تاريخ الانشاء : غير معروف
					</td>
				</tr>
				<tr>
					<td class="row1 rows_space" colspan="2">
						<strong>منتديات فرعيه :</strong> لا يوجد
						<br />
						<strong>المشرفين :</strong> لا يوجد
					</td>
				</tr>
		{else}
		<tr>
			<td width="3%" align="center" class="row1">
				{if {{$forum['use_section_picture']}} == 1}
					{if {{$forum['sectionpicture_type']}} == 1}
						<img src="{$forum['section_picture']}" alt="" />
					{/comif}
					{else}
						<img src="{$image_path}/icon-67_new.gif" alt="" />
					{/else}
				{/comif}
				{else}
					<img src="{$image_path}/icon-67_new.gif" alt="" />
				{/else}
			</td>
			<td width="40%" align="right" class="row1">
				<a href="index.php?page=forum&amp;show=1&amp;id={$forum['id']}">{$forum['title']}</a>
				<br />
				{if {{$forum['use_section_picture']}} == 1}
					{if {{$forum['sectionpicture_type']}} == 2}
						<img src="{$forum['section_picture']}" alt="" />
						<br />
					{/if}
				{/if}
				{$forum['describe']}
			</td>
			<td width="50%" align="center" class="row1" colspan="3">
				عدد الزيارات : {$forum['linkvisitor']}
			</td>
		</tr>
		{/if}
		{/if}
	{/Des::foreach}
	</table>
		
</div>
<br />
