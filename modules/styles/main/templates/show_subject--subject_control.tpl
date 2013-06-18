<div id="topic_management_dialog" class="tab-container" style="width:600px;display: none;">
	{hook}before_management_tabs{/hook}
	<ul class='etabs' id="management_tabs">
		{hook}before_first_management_tab{/hook}
		<li class='tab'><a href="#basics">{$lang['basic_operations']}</a></li>
		<li class='tab'><a href="#delete">{$lang['delete_subject']}</a></li>
		<li class='tab'><a href="#move">{$lang['move_subject']}</a></li>
		<li class='tab'><a href="#edit">{$lang['edit_subject']}</a></li>
		<li class='tab'><a href="#repeated">{$lang['repeated_subject']}</a></li>
		{hook}before_last_management_tab{/hook}
	</ul>
	{hook}after_management_tabs{/hook}
	<div class='panel-container' id="management_panal">
		<div id="basics">
			<form id="basics_form" method="post" action="">
			{hook}basic_tab_start{/hook}			
			<input name="stick" id="stick_id" type="checkbox" {if {$Info['stick']}}checked="checked"{/if} /><label for="stick_id">{$lang['stick_subject']}</label>
			<br />
			<input name="close" id="close_id" type="checkbox" {if {$Info['close']}}checked="checked"{/if} /><label for="close_id">{$lang['close_subject']}</label>
			<br /><br />
			{hook}basic_tab_end{/hook}
			<input type="submit" id="basics_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="delete">
			<form id="delete_form" method="post" action="">
			{hook}delete_tab_start{/hook}
			{template}subject_delete_reason{/template}
			<br /><br />
			{hook}delete_tab_end{/hook}
			<input type="submit" id="delete_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="move">
			{hook}move_tab_start{/hook}
			<form id="move_form" method="post" action="">
			{template}subject_move_index{/template}
			<br /><br />
			{hook}move_tab_end{/hook}
			<input type="submit" id="move_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="edit">
			<form id="edit_form" method="post" action="">
			{hook}edit_tab_start{/hook}
			{template}subject_edit{/template}
			<br />
			{hook}edit_tab_end{/hook}
			<input type="submit" id="edit_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="repeated">
			<form id="repeated_form" method="post" action="">
			{hook}repeated_tab_start{/hook}
			{template}subject_repeat_index{/template}
			<br /><br />
			{hook}repeated_tab_end{/hook}
			<input type="submit" id="repeated_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="message" align="center" style="display: none;">
			<img id="loading" src="{$image_path}/loading.gif" alt="" />
		</div>
		{hook}after_status_message{/hook}
	</div>
</div>
<script type="text/javascript">
function ajaxRequest( url, form_data )
{
	$( "#message" ).show();
	
	$.ajax({
		type: 'POST',
		url: url,
		data: form_data,
		success: function (data) 
		{
			$( "#message" ).html( data );
			location.reload();
		}
	});
}

$('#basics_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_basics/{$Info['subject_id']}", data );

	return false;
} );

$('#delete_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_delete/{$Info['subject_id']}", data );

	return false;
} );

$('#move_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_move/{$Info['subject_id']}", data );

	return false;
} );

$('#edit_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_edit/{$Info['subject_id']}", data );

	return false;
} );

$('#repeated_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_repeated/{$Info['subject_id']}", data );

	return false;
} );
</script>