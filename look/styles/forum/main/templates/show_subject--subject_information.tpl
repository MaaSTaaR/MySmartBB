<table align="center" border="1" class="t_style_b" width="60%">
	<tr align="center">
		<td class="main1 rows_space" width="50%" colspan="2">
			معلومات عن الموضوع
		</td>
	</tr>
	{if {{$Info['stick']}} or {{$Info['close']}} or {{$Info['delete_topic']}}}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			حالة الموضوع : 
			<strong>
			{if {{$Info['stick']}}}
			مُثبّت
			{elseif {{$Info['close']}}}
			مُغلق
			{elseif {{$Info['delete_topic']}}}
			محذوف
			{/if}
			</strong>
		</td>
	</tr>
	{/if}
	{if {{$Info['close_reason']}} != '' and {{$Info['close']}} }
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			سبب الاغلاق : <strong>{$Info['close_reason']}</strong>
		</td>
	</tr>
	{/if}
	<tr align="center">
		<td class="row1 rows_space" width="25%">
			عدد الردود : {$Info['reply_number']}
		</td>
		<td class="row1 rows_space" width="25%">
			عدد الزوار : {$Info['visitor']}
		</td>
	</tr>
	{if {{$SHOW_TAGS}}}
	<tr align="center">
		<td class="row1 rows_space" width="50%" colspan="2">
			علامات الموضوع : 
			{Des::while}{tags}
			<a href="index.php?page=tags&amp;show=1&amp;id={$tags['tag_id']}">{$tags['tag']}</a>،
			{/Des::while}
	</tr>
	{/if}
</table>

<br />
