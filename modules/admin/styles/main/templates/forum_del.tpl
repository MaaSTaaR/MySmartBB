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
		<p align="center">{$lang['youre_going_to_del']}</p>
		
		<table width="60%" class="t_style_b" border="0" align="center">
			<tr>
				<td class="main1 rows_space">
				{$lang['what_to_do']}
				</td>
			</tr>
			<tr>
				<td class="row1">
					<select name="choose" id="choose_id">
						<option value="move">{$lang['move_all_topics']}</option>
						<option value="del">{$lang['del_all_topics']}</option>
					</select>
				</td>
			</tr>
		</table>
		
		<br />
		
		<div id="move">
			<table width="60%" class="t_style_b" border="0" align="center">
				<tr>
					<td class="main1 rows_space">
				{$lang['move_to']}	
					</td>
				</tr>
					<td class="row2">
						<select name="to" id="select_to">
						{DB::getInfo}{$SecList}
							<option value="{$SecList['id']}">{$SecList['title']}</option>
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
