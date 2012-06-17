<script src="includes/js/jquery.js"></script>

<script language="javascript">

function OrderChange()
{
	value = $("#choose_id").val();
	
	if (value == 'move')
	{
		$("#move").fadeIn();
	}
	else
	{
		$("#move").fadeOut();
	}
}

function Ready()
{
	value = $("#choose_id").val();
	
	if (value == 'move')
	{
		$("#move").show();
	}
	else
	{
		$("#move").hide();
	}
	
	$("#choose_id").change(OrderChange);
}

$(document).ready(Ready);

</script>

<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=forums&amp;control=1&amp;main=1">{$lang['forums']}</a> &raquo; {$lang['forum_del_confirmation']} : {$Inf['title']}</div>

<br />

	<form action="admin.php?page=forums_del&amp;start=1&amp;id={$Inf['id']}" method="post">
		<table width="60%" class="t_style_b" border="1" align="center">
			<tr>
				<td class="main1" colspan="2">
				{$lang['youre_going_to_del']}
				</td>
			</tr>
			<tr>
				<td class="row1">
				{$lang['what_to_do']}
				</td>
				<td class="row1">
					<select name="choose" id="choose_id">
						<option value="move">{$lang['move_all_topics']}</option>
						<option value="del">{$lang['del_all_topics']}</option>
					</select>
				</td>
			</tr>
			<tr id="move">
				<td class="row1">
				{$lang['move_to']}	
				</td>
				<td class="row1">
					<select name="to" id="select_to">
						{DB::getInfo}{$SecList}
						<option value="{$SecList['id']}">{$SecList['title']}</option>
						{/DB::getInfo}
					</select>
				</td>
			</tr>
		</table>
		
		<br />
		
		<div align="center">
			<input type="submit" value="{$lang['common']['submit']}" name="submit" />
		</div>
		
		<br />
</form>
