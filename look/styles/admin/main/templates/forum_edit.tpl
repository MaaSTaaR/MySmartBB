<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">المنتديات</a> &raquo; تحرير : {$Inf['title']}</div>

<br />

<form action="admin.php?page=forums&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
	<table width="90%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1" colspan="2">
			تحرير المنتدى : {$Inf['title']}
			</td>
		</tr>
		<tr>
			<td class="row1">
			اسم المنتدى
			</td>
			<td class="row1">
				<input type="text" name="name" value="{$Inf['title']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			ترتيبه
			</td>
			<td class="row2">
				<input type="text" name="sort" value="{$Inf['sort']}" size="5" />
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			صورة المنتدى
			</td>
		</tr>
		<tr>
			<td class="row1">
			السماح بظهور صوره للمنتدى
			</td>
			<td class="row1">
				<select name="use_section_picture">
				{if {$Inf['use_section_picture']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			صورة المنتدى
			</td>
			<td class="row2">
				<input type="text" name="section_picture" value="{$Inf['section_picture']}" />
			</td>
		</tr>
		<tr>
			<td class="row1">
			مكان صورة المنتدى
			</td>
			<td class="row1">
				<select name="sectionpicture_type">
				{if {$Inf['sectionpicture_type']} == 1}
					<option value="1" selected="selected">مكان ايقونة المنتدى</option>
					<option value="2">فوق الوصف الخاص بالمنتدى</option>
				{elseif {$Inf['sectionpicture_type']} == 2}
					<option value="1">مكان ايقونة المنتدى</option>
					<option value="2" selected="selected">فوق الوصف الخاص بالمنتدى</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			تواجد المنتدى
			</td>
		</tr>
		<tr>
			<td class="row2">
			يقع تحت القسم الرئيسي
			</td>
			<td class="row2">
				<select name="parent" id="select_parent">
				{Des::foreach}{forums_list}{forum}
					{if {$forum['parent']} == 0}
					{if {$forum['id']} == {$Inf['parent']}}
					<option value="{$forum['id']}" class="main_section" selected="selected">- {$forum['title']}</option>
					{else}
					<option value="{$forum['id']}" class="main_section">- {$forum['title']}</option>
					{/if}
					{else}
					{if {$forum['id']} == {$Inf['parent']}}
					<option value="{$forum['id']}" selected="selected">-- {$forum['title']}</option>
					{else}
					<option value="{$forum['id']}">-- {$forum['title']}</option>
					{/if}
					{/if}
				{/Des::foreach}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			نوع المنتدى
			</td>
		</tr>
		<tr>
			<td class="row1">
			المنتدى عباره عن وصله
			</td>
			<td class="row1">
				<select name="linksection">
				{if {$Inf['linksection']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			الوصله
			</td>
			<td class="row2">
				<input type="text" name="linksite" value="{$Inf['linksite']}" />
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			خيارات
			</td>
		</tr>
		<tr>
			<td class="row1">
			كلمه سريه للمنتدى
			</td>
			<td class="row1">
				<input type="text" name="section_password" value="{$Inf['section_password']}" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			عرض التواقيع في المنتدى
			</td>
			<td class="row2">
				<select name="show_sig">
				{if {$Inf['show_sig']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			منع تكرار التواقيع في المنتدى
			</td>
			<td class="row1">
				<select name="sig_iteration">
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			امكانية استخدام SmartCode
			</td>
			<td class="row2">
				<select name="usesmartcode_allow">
				{if {$Inf['usesmartcode_allow']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			حالة عرض الموضوع
			</td>
			<td class="row1">
				<select name="subject_order">
				{if {$Inf['subject_order']} == 1}
					<option value="1" selected="selected">صاحب الردود الجديده في الاعلى</option>
					<option value="2">الموضوع الجديد في الاعلى</option>
					<option value="3">الموضوع القديم في الاعلى</option>
				{elseif {$Inf['subject_order']} == 2}
					<option value="1">صاحب الردود الجديده في الاعلى</option>
					<option value="2" selected="selected">الموضوع الجديد في الاعلى</option>
					<option value="3">الموضوع القديم في الاعلى</option>
				{elseif {$Inf['subject_order']} == 3}
					<option value="1">صاحب الردود الجديده في الاعلى</option>
					<option value="2">الموضوع الجديد في الاعلى</option>
					<option value="3" selected="selected">الموضوع القديم في الاعلى</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			إخفاء المواضيع عن غير اصحابها
			</td>
			<td class="row2">
				<select name="hide_subject">
				{if {$Inf['hide_subject']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			قسم سرّي اي لا يتم عرض مواضيع هذا القسم في الاماكن العامّه
			</td>
			<td class="row1">
				<select name="sec_section">
				{if {$Inf['hide_subject']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1">
			المواضيع المنشوره لا يتم طرحها إلا بعد الموافقه عليها من خلال المشرف او المدير
			</td>
			<td class="row1">
				<select name="review_subject">
				{if {$Inf['review_subject']}}
					<option value="1" selected="selected">نعم</option>
					<option value="0">لا</option>
				{else}
					<option value="1">نعم</option>
					<option value="0" selected="selected">لا</option>
				{/if}
				</select>
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			الوصف
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="describe" rows="10" cols="40" wrap="virtual" dir="rtl">{$Inf['section_describe']}</textarea>
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			نص يظهر اعلى المنتدى (يمكنك استخدام HTML)
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="head" rows="10" cols="40" wrap="virtual" dir="rtl">{$Inf['header']}</textarea> 
			</td>
		</tr>
		<tr align="center">
			<td class="main1" colspan="2">
			نص يظهر اسفل المنتدى(يمكنك استخدام HTML)
			</td>
		</tr>
		<tr align="center">
			<td class="row1" colspan="2">
				<textarea name="foot" rows="10" cols="40" wrap="virtual" dir="rtl">{$Inf['footer']}</textarea> 
			</td>
		</tr>
	</table>
	
	<br />
	
	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
</form>
