<div id="reply_management_dialog_{$Info['reply_id']}" class="tab-container" style="width:600px;display: none;">
	{hook}before_management_tabs{/hook}
	<ul class='etabs' id="reply_management_tabs">
		{hook}before_first_management_tab{/hook}
		<li class='tab'><a href="#reply_basics">{$lang['basic_operations']}</a></li>
		<li class='tab'><a href="#reply_edit">{$lang['edit_reply']}</a></li>
		{hook}before_last_management_tab{/hook}
	</ul>
	{hook}after_management_tabs{/hook}
	<div class='panel-container' id="management_panal">
		<div id="reply_basics">
			<form id="reply_basics_form" method="post" action="">
			{hook}basic_tab_start{/hook}			
			<input name="delete" id="delete_reply_id" type="checkbox" {if {$Info['delete']}}checked="checked"{/if} /><label for="delete_reply_id">{$lang['delete_reply']}</label>
			<br /><br />
			{hook}basic_tab_end{/hook}
			<input type="submit" id="reply_basics_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="reply_edit">
			<form id="reply_edit_form" method="post" action="">
			{hook}edit_tab_start{/hook}
			{template}reply_edit{/template}
			<br />
			{hook}edit_tab_end{/hook}
			<input type="submit" id="reply_edit_submit" value="{$lang['common']['submit']}" />
			</form>
		</div>
		<div id="reply_message" align="center" style="display: none;">
			<img id="loading" src="{$image_path}/loading.gif" alt="" />
		</div>
		{hook}after_status_message{/hook}
	</div>
</div>
<script type="text/javascript">
function ajaxRequest( url, form_data )
{
	$( "#reply_message" ).show();
	
	$.ajax({
		type: 'POST',
		url: url,
		data: form_data,
		success: function (data) 
		{
			$( "#reply_message" ).html( data );
			location.reload();
		}
	});
}

$('#reply_basics_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_basics/{$Info['subject_id']}", data );

	return false;
} );

$('#reply_edit_form').submit( function ()
{
	var data = $(this).serialize();
	ajaxRequest( "{$init_path}"
				+ "topic_management_edit/{$Info['subject_id']}", data );

	return false;
} );

</script>