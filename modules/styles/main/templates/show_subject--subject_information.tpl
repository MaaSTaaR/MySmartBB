<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="50%" colspan="2">
			معلومات عن الموضوع
		</td>
	</tr>
	{if {$Info['stick']} or {$Info['close']} or {$Info['delete_topic']}}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			حالة الموضوع : 
			<strong>
			{if {$Info['stick']}}
			مُثبّت
			{/if}
			{if {$Info['close']}}
			مُغلق
			{/if}
			{if {$Info['delete_topic']}}
			محذوف
			{/if}
			</strong>
		</td>
	</tr>
	{/if}
	{if {$Info['close_reason']} != '' and {$Info['close']} }
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			سبب الاغلاق : <strong>{$Info['close_reason']}</strong>
		</td>
	</tr>
	{/if}
	{if {$Info['delete_reason']} != '' and {$Info['delete_topic']} }
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			سبب الحذف : <strong>{$Info['delete_reason']}</strong>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1 rows_space" width="25%">
			عدد الردود : {$Info['reply_number']}
		</td>
		<td class="row1 rows_space" width="25%">
			عدد الزوار : {$Info['subject_visitor']}
		</td>
	</tr>
	{if {$SHOW_TAGS}}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			<strong>
			علامات الموضوع : 
			{DB::getInfo}{$tags_res}{$tags}
			<a href="index.php?page=tags&amp;show=1&amp;id={$tags['tag_id']}">{$tags['tag']}</a>،
			{/DB::getInfo}
			</strong>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			<a href="index.php?page=download&amp;subject=1&amp;id={$Info['subject_id']}">تحميل محتوى الموضوع</a>
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			<a href="index.php?page=topic&amp;show=1&amp;id={$Info['subject_id']}&amp;print=1">عرض نسخة صالحة للطباعة</a>
		</td>
	</tr>
</table>

<br />
