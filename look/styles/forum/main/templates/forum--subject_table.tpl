<br /><br />

{$pager}

<table border="1" class="t_style_b" width="98%" align="center">
	<tr>
		<td width="30%" class="main1 rows_space small_text" align="center" colspan="2">
			عنوان الموضوع
		</td>
		<td width="20%" class="main1 rows_space small_text" align="center">
			الكاتب
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
	{if !{$NO_REVIEW_SUBJECTS}}
	<tr>
		<td width="98%" colspan="7" class="main2" align="center">
			<strong>مواضيع بإنتظار الموافقة على النشر</strong>
		</td>
	</tr>
	{Des::while}{review_subject_list}
	<tr>
		<td width="3%" class="review_subject1" align="center">
			<img src="{$subject_list['icon']}" alt="" />
		</td>

		<td width="40%" class="review_subject2">
			<a href="index.php?page=topic&show=1&id={$review_subject_list['id']}{$password}">
				{$review_subject_list['title']} 
			</a> 
			{if {$review_subject_list['close']}}
			<small>(مغلق)</small>
			{/if}
			{if {$subject_list['special']}}
			<small>(<font color="#FF0000">موضوع مميز</font>)</small><span align="left">
			<img border="0" src="{$image_path}/special.png" alt="موضوع مميز" /> </span>
			{/if}
			<br />
			<font class="small">{$review_subject_list['subject_describe']}</font>
		</td>
		<td width="20%" class="review_subject1" align="center">
			<a href="index.php?page=profile&show=1&username={$review_subject_list['writer']}">{$review_subject_list['writer']}</a><br />
			{$review_subject_list['write_date']}
		</td>
		<td width="5%" class="review_subject2" align="center">
			{$review_subject_list['reply_number']}
		</td>
		<td width="5%" class="review_subject1" align="center">
			{$review_subject_list['visitor']}
		</td>
		<td width="28%" class="review_subject2" align="center">
			{if {$review_subject_list['reply_number']} <= 0}
			لا يوجد ردود
			{else}
			<a href="index.php?page=profile&show=1&username={$review_subject_list['last_replier']}">{$review_subject_list['last_replier']}</a><br />
			{$review_subject_list['reply_date']}
			{/if}
		</td>
	</tr>
	{/Des::while}
	{/if}
	{if !{$NO_STICK_SUBJECTS}}
	<tr>
		<td width="98%" colspan="6" class="main2" align="center">
			المواضيع المثبته
		</td>
	</tr>
	{/if}
	{Des::while}{stick_subject_list}
	<tr>
		<td width="3%" class="row1" align="center">
			<img src="{$stick_subject_list['icon']}" alt="" />
		</td>
		<td width="30%" class="row2">
			<a href="index.php?page=topic&show=1&id={$stick_subject_list['id']}{$password}">
				{$stick_subject_list['title']}
			</a> 
			{if {$stick_subject_list['close']}}
			<small>(مغلق)</small>
			{/if}
			{if {$stick_subject_list['special']}}
			<small>(<font color="#FF0000">موضوع مميز</font>)</small><span align="left">
			<img border="0" src="{$image_path}/special.png" alt="موضوع مميز" /> </span>
			{/if}
			<br />
			<font class="small">{$stick_subject_list['subject_describe']}</font>
		</td>
		<td width="20%" class="row1" align="center">
			<a href="index.php?page=profile&show=1&username={$stick_subject_list['writer']}">{$stick_subject_list['writer']}</a><br />
			{$stick_subject_list['write_date']}
		</td>
		<td width="8%" class="row2" align="center">
			{$stick_subject_list['reply_number']}
		</td>
		<td width="8%" class="row1" align="center">
			{$stick_subject_list['visitor']}
		</td>
		<td width="28%" class="row2" align="center">
			{if {$stick_subject_list['reply_number']} <= 0}
			لا يوجد ردود
			{else}
			<a href="index.php?page=profile&show=1&username={$stick_subject_list['last_replier']}">{$stick_subject_list['last_replier']}</a><br />
			{$stick_subject_list['reply_date']}
			{/if}
		</td>
	</tr>
	{/Des::while}
	<tr>
		<td width="98%" colspan="6" class="main2" align="center">
			قائمة المواضيع
		</td>
	</tr>
	{Des::while}{subject_list}
	<tr>
		<td width="3%" class="row1" align="center">
			<img src="{$subject_list['icon']}" alt="" />
		</td>
		<td width="30%" class="row2">
			<a href="index.php?page=topic&show=1&id={$subject_list['id']}{$password}">
				{$subject_list['title']}
			</a>
			{if {$subject_list['close']}}
			<small>(مغلق)</small>
			{/if}
			{if {$subject_list['special']}}
			<small>(<font color="#FF0000">موضوع مميز</font>)</small><span align="left">
			<img border="0" src="{$image_path}/special.png" alt="موضوع مميز" /> </span>
			{/if}
			<br />
			<font class="small">{$subject_list['subject_describe']}</font>
		</td>
		<td width="20%" class="row1" align="center">
			<a href="index.php?page=profile&show=1&username={$subject_list['writer']}">{$subject_list['writer']}</a><br />
			{$subject_list['write_date']}
		</td>
		<td width="8%" class="row2" align="center">
			{$subject_list['reply_number']}
		</td>
		<td width="8%" class="row1" align="center">
			{$subject_list['visitor']}
		</td>
		<td width="28%" class="row2" align="center">
			{if {$subject_list['reply_number']} <= 0}
			لا يوجد ردود
			{else}
			<a href="index.php?page=profile&show=1&username={$subject_list['last_replier']}">{$subject_list['last_replier']}</a><br />
			{$subject_list['reply_date']}
			{/if}
		</td>
	</tr>	
{/Des::while}
</table>

<br />

{$pager}

<br />
