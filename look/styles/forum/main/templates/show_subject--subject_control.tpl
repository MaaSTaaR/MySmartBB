{if {$_CONF['info_row']['ajax_moderator_options']}}

<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AjaxModerator()
{
	var AjaxState = {ajaxSend : $("#status").html("{$image_path}/loading.gif")};
	
	var data = {};
	
	data['section']		=	$("#section_i").val();
	data['subject']		=	$("#subject_i").val();
	data['oper']		=	$("#operator_i").val();

	$.post("index.php?page=ajax&management=1",data,function Success(xml) { $("#status").html(xml); });	
}

function AjaxClose()
{
	var AjaxState = {ajaxSend : $("#status").html("{$image_path}/loading.gif")};
	
	var data = {};
	
	data['section']		=	$("#section_i").val();
	data['subject']		=	$("#subject_i").val();
	data['reason']		=	$("#reason").val();
	data['oper']		=	'close';

	$.post("index.php?page=ajax&management=1&second=1",data,function Success(xml) { $("#status").html(xml); });	
}

function Ready()
{
	$("#control_id").click(AjaxModerator);
	$("#close_id").click(AjaxClose);
}

$(document).ready(Ready);

</script>

{/if}

{if !{$_CONF['info_row']['ajax_moderator_options']}}
<form method="get" action="index.php">
{/if}

<input type="hidden" name="page" value="management" />
<input type="hidden" name="subject" value="1" />
<input type="hidden" name="section" id="section_i" value="{$Info['section']}" />
<input type="hidden" name="subject_id" id="subject_i" value="{$Info['subject_id']}" />

<table align="center" border="1" cellpadding="2" cellspacing="2" class="t_style_b" width="50%">
	<tr align="center">
		<td class="main1 rows_space" width="50%">
			التحكم في الموضوع
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
			<select name="operator" id="operator_i">
				{if !{$Info['stick']}}
				<option value="stick">تثبيت الموضوع</option>
				{/if}
				{if {$Info['stick']}}
				<option value="unstick">إلغاء تثبيت الموضوع</option>
				{/if}
				{if !{$Info['close']}}
				<option value="close">إغلاق الموضوع</option>
				{/if}
				{if {$Info['close']}}
				<option value="open">فتح الموضوع</option>
				{/if}
				<option value="delete">حذف الموضوع</option>
				<option value="move">نقل الموضوع</option>
				<option value="edit">تحرير الموضوع</option>
				<option value="repeated">موضوع مكرر</option>
				<option value="up">رفع الموضوع</option>
				<option value="down">تنزيل الموضوع</option>
				{if {$Info['review_subject']}}
				<option value="unreview_subject">الموافقه على الموضوع</option>
				{/if}
			</select>
			{if {$_CONF['info_row']['ajax_moderator_options']}}
			<input type="button" name="control" id="control_id" value="موافق" />
			{else}
			<input type="submit" value="موافق" />
			{/if}
		</td>
	</tr>
</table>

{if {$_CONF['info_row']['ajax_moderator_options']}}
<br />
<div align="center" id="status"></div>
{/if}

</form>

<br />
