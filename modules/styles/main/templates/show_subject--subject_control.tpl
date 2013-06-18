<form method="post" action="">
<div id="topic_management_dialog" class="tab-container" style="width:600px;display: none;">
	<ul class='etabs' id="management_tabs">
		<li class='tab'><a href="#basics">{$lang['basic_operations']}</a></li>
		<li class='tab'><a href="#delete">{$lang['delete_subject']}</a></li>
		<li class='tab'><a href="#move">{$lang['move_subject']}</a></li>
		<li class='tab'><a href="#edit">{$lang['edit_subject']}</a></li>
	</ul>
	<div class='panel-container' id="management_panal">
		<div id="basics">
			{if !{$Info['stick']}}
			<input name="stick" id="stick_id" type="checkbox" /><label for="stick_id">{$lang['stick_subject']}</label>
			{else}
			<input name="unstick" id="unstick_id" type="checkbox" /><label for="unstick_id">{$lang['unstick_subject']}</label>
			{/if}
			<br />
			{if !{$Info['close']}}
			<input name="close" id="close_id" type="checkbox" /><label for="close_id">{$lang['close_subject']}</label>
			{else}
			<input name="open" id="open_id" type="checkbox" /><label for="open_id">{$lang['open_subject']}</label>
			{/if}
			<br />
			<input name="repeated" id="repeated_id" type="checkbox" /><label for="repeated_id">{$lang['repeated_subject']}</label>
			<br /><br />
			<input type="submit" id="basics_submit" value="{$lang['common']['submit']}" />
		</div>
		<div id="delete">
			{template}subject_delete_reason{/template}
			<br /><br />
			<input type="submit" id="delete_submit" value="{$lang['common']['submit']}" />
		</div>
		<div id="move">
			{template}subject_move_index{/template}
			<br /><br />
			<input type="submit" id="move_submit" value="{$lang['common']['submit']}" />
		</div>
		<div id="edit">
			{template}subject_edit{/template}
			<br />
			<input type="submit" id="edit_submit" value="{$lang['common']['submit']}" />
		</div>
		<div id="message" align="center" style="display: none;">
			<img id="loading" src="{$image_path}/loading.gif" alt="" />
		</div>
	</div>
</div>
</form>
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
			$( "#message" ).text( data );
		}
	});
}

$('#topic_management_dialog').easytabs( { "animate" : false } );

$('#basics_submit').on( 'click', 
		function () 
		{
			ajaxRequest( "{$init_path}"
					+ "topic_management_basics/{$Info['subject_id']}", null );
		} );
$('#delete_submit').on( 'click', function () { alert( 'Delete' ) } );
$('#move_submit').on( 'click', function () { alert( 'Move' ) } );
$('#edit_submit').on( 'click', function () { alert( 'Edit' ) } );
</script>