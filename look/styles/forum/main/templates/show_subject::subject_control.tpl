<form method="get" action="index.php">

<input type="hidden" name="page" value="management" />
<input type="hidden" name="subject" value="1" />
<input type="hidden" name="section" value="{$Info['section']}" />
<input type="hidden" name="subject_id" value="{$Info['id']}" />

<table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="50%">
	<tr align="center">
		<td class="main1 rows_space" width="50%">
			التحكم في الموضوع
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
			<select name="operator">
				{if !{{$Info['stick']}}}
				<option value="stick">تثبيت الموضوع</option>
				{/if}
				{if {{$Info['stick']}}}
				<option value="unstick">إلغاء تثبيت الموضوع</option>
				{/if}
				{if !{{$Info['close']}}}
				<option value="close">إغلاق الموضوع</option>
				{/if}
				{if {{$Info['close']}}}
				<option value="open">فتح الموضوع</option>
				{/if}
				<option value="delete">حذف الموضوع</option>
				<option value="move">نقل الموضوع</option>
				<option value="edit">تحرير الموضوع</option>
				<option value="repeated">موضوع مكرر</option>
			</select>
			<input type="submit" value="موافق" />
		</td>
	</tr>
</table>

</form>

<br />
