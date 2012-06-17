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

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">{$lang['sections']}</a> &raquo; {$lang['section_del_confirmation']} : {$Inf['title']}</div>

<br />

<form action="admin.php?page=sections_del&amp;start=1&amp;id={$Inf['id']}" method="post">

<table width="60%" class="t_style_b" border="1" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		{$lang['youre_going_delete']}
		</td>
	</tr>
	<tr>
		<td class="row1">
		{$lang['what_to_do']}
		</td>
		<td class="row1">
			<select name="choose" id="choose_id">
				<option value="move">{$lang['move_forums']}</option>
				<option value="del">{$lang['delete_forums_topics']}</option>
				<option value="move_subjects">{$lang['delete_forums_move_topics']}</option>
			</select>
		</td>
	</tr>
	<tr id="move_section">
		<td class="row1">
		{$lang['move_to']}
		</td>
		<td class="row1">
			<select name="to" id="select_to">
				{DB::getInfo}{$sec_res}{$section}
				<option value="{$section['id']}">{$section['title']}</option>
				{/DB::getInfo}
			</select>
		</td>
	</tr>
	<tr id="move_subject">
		<td class="row1">
		{$lang['move_topics_to']}
		</td>
		<td class="row1">
			<select name="subject_to" id="select_subject_to">
				{DB::getInfo}{$forum_res}{$forum}
				<option value="{$forum['id']}">{$forum['title']}</option>
				{/DB::getInfo}
			</select>
		</td>
	</tr>
</table>

<br />

<div align="center">
	<input type="submit" value="{$lang['common']['submit']}" name="submit" />
</div>

</form>
