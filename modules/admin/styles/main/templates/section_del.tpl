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

<p align="center">{$lang['youre_going_delete']}</p>

<table width="60%" class="t_style_b" border="1" align="center">
	<tr>
		<td class="main1 rows_space">
		{$lang['what_to_do']}
		</td>
	</tr>
	<tr>
		<td class="row1">
			<select name="choose" id="choose_id">
				<option value="move">{$lang['move_forums']}</option>
				<option value="del">{$lang['delete_forums_topics']}</option>
				<option value="move_subjects">{$lang['delete_forums_move_topics']}</option>
			</select>
		</td>
	</tr>
</table>

<br />

<div id="move_section">
<table width="60%" class="t_style_b" border="1" align="center">
	<tr>
		<td class="main1 rows_space">
		{$lang['move_to']}
		</td>
	</tr>
		<td class="row2">
			<select name="to" id="select_to">
				{DB::getInfo}{$sec_res}{$section}
				<option value="{$section['id']}">{$section['title']}</option>
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
		{$lang['move_topics_to']}
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
	<input type="submit" value="{$lang['common']['submit']}" name="submit" />
</div>

<br />
</form>
