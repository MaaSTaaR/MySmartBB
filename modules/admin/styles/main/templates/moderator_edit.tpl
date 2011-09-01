<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;main=1">المشرفين</a> &raquo; <a href="admin.php?page=moderators&amp;control=1&amp;section=1&amp;id={$Section['id']}">{$Section['title']}</a> &raquo; تحرير : {$Inf['username']}</div>

<br />

<form action="admin.php?page=moderators&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">

	<table width="60%" class="t_style_b" border="1" align="center">
		<tr align="center">
			<td class="main1 rows_space" colspan="2">
			تحرير
			</td>
		</tr>
		<tr>
			<td class="row1">
			اسم المستخدم
			</td>
			<td class="row1">
				<input type="text" name="username" readonly="readonly" value="{$Inf['username']}" size="30" />
			</td>
		</tr>
		<tr>
			<td class="row2">
			مشرف على
			</td>
			<td class="row2">
				<select size="1" name="section" id="section_id">
				{Des::foreach}{forums_list}{forum}
        		{if {$forum['parent']} == 0}
				<option value="{$forum['id']}" class="main_section">- {$forum['title']}</option>
				{else}
					{if {$Inf['section_id']} == {$forum['id']}}
					<option value="{$forum['id']}" selected="selected">-- {$forum['title']}</option>
					{else}
					<option value="{$forum['id']}">-- {$forum['title']}</option>
					{/if}
				{/if}
				{/Des::foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="row2">
			مجموعة الاشراف
			</td>
			<td class="row2">
				<select size="1" name="group" id="group_id">
				{DB::getInfo}{$group_res}{$group}
				{if {$Inf['section_id']} == {$group['id']}}
				<option value="{$group['id']}" selected="selected">{$group['title']}</option>
				{else}
				<option value="{$group['id']}">{$group['title']}</option>
				{/if}
				{/DB::getInfo}
				</select>
			</td>
		</tr>
	</table>

	<br />
	
	<div align="center">
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="موافق" name="submit" />
			</td>
		</tr>
	</table>
	
	<br />

</form>
