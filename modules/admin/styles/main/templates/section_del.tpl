<script src="includes/js/jquery.js"></script>

<script language="javascript">

function OrderChange()
{
	value = $("#choose_id").val();
	
	if (value == 'move')
	{
		$("#move_section").fadeIn();
		$("#move_subject").fadeOut();
	}
	else if (value == 'del')
	{
		$("#move_section").fadeOut();
		$("#move_subject").fadeOut();
	}
	else
	{
		$("#move_section").fadeOut();
		$("#move_subject").fadeIn();
	}
}

function Ready()
{
	value = $("#choose_id").val();
	
	if (value == 'move')
	{
		$("#move_section").show();
		$("#move_subject").hide();
	}
	else if (value == 'del')
	{
		$("#move_section").hide();
		$("#move_subject").hide();
	}
	else
	{
		$("#move_section").hide();
		$("#move_subject").show();
	}
	
	$("#choose_id").change(OrderChange);
}

$(document).ready(Ready);

</script>

<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">الاقسام الرئيسيه</a> &raquo; تأكيد حذف : {$Inf['title']}</div>

<br />

<form action="admin.php?page=sections_del&amp;start=1&amp;id={$Inf['id']}" method="post">

<p align="center">انت الآن مُقدم على حذف قسم رئيسي</p>

<table width="60%" class="t_style_b" border="1" align="center">
	<tr>
		<td class="main1 rows_space">
		ما الذي تريد فعله؟
		</td>
	</tr>
	<tr>
		<td class="row1">
			<select name="choose" id="choose_id">
				<option value="move">نقل جميع المنتديات التي تحته إلى قسم رئيسي آخر</option>
				<option value="del">حذف جميع المنتديات و مواضيعهم</option>
				<option value="move_subjects">حذف جميع المنتديات مع نقل المواضيع إلى منتدى آخر</option>
			</select>
		</td>
	</tr>
</table>

<br />

<div id="move_section">
<table width="60%" class="t_style_b" border="1" align="center">
	<tr>
		<td class="main1 rows_space">
		نقل إلى
		</td>
	</tr>
		<td class="row2">
			<select name="to" id="select_to">
				{DB::getInfo}{$sec_res}{$section}
				<option value="{$SecList['id']}">{$section['title']}</option>
				{/DB::getInfo}
			</select>
		</td>
	</tr>
</table>
</div>

<br />

<div id="move_subject">
<table width="60%" class="t_style_b" border="1" align="center">
	<tr>
		<td class="main1 rows_space">
		نقل المواضيع إلى
		</td>
	</tr>
	<tr>
		<td class="row1">
			<select name="subject_to" id="select_subject_to">
				{DB::getInfo}{$forum_res}{$forum}
				<option value="{$forum['id']}">{$forum['title']}</option>
				{/DB::getInfo}
			</select>
		</td>
	</tr>
</table>
</div>

<br />

<div align="center">
	<input type="submit" value="موافق" name="submit" />
</div>

<br />
</form>
