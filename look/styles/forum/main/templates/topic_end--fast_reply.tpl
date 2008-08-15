{if {{$_CONF['info_row']['ajax_freply']}}}

<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AjaxReply()
{
	var AjaxState = {ajaxSend : Wait};
	
	var data = {};
	
	data['title']	=	$("#title_id").val();
	data['text']	=	$("#text_id").val();
	data['ajax']	=	true;
		
	$.post("index.php?page=new_reply&start=1&id={$id}{$password}",data,Success);
}

function Wait()
{
	$("#status").html("جاري تنفيذ العمليه");
}

function Success(xml)
{
	$("#status").hide();
	$("#result").hide();
	$("#result").html(xml);
	$("#result").fadeIn("slow");
}

function Ready()
{
	$("#reply_id").click(AjaxReply);
}

$(document).ready(Ready);

</script>

{/if}

<br />

<form name="topic" method="post" action="index.php?page=new_reply&amp;start=1&amp;id={$id}{$password}">

{if {{$_CONF['info_row']['icons_show']}}}
{template}iconbox{/template}
{/if}

<br />

{if {{$_CONF['info_row']['toolbox_show']}}}
{template}toolbox{/template}
{/if}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الرد
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			عنوان الرد :
			<input name="title" id="title_id" type="text" {if {{$_CONF['info_row']['title_quote']}}}value="رد : {$Info['title']}"{/if} />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<div id="status"></div>
			<textarea rows="12" name="text" id="text_id" cols="69"></textarea>
			<br />
			<br />
			{if {{$_CONF['info_row']['ajax_freply']}}}
			<input name="insert" type="button" id="reply_id" value="موافق" />
			{else}
			<input name="insert" type="submit" value="موافق" />
			{/if}
		</td>
	</tr>
</table>

<br />

{if {{$_CONF['info_row']['smiles_show']}}}
{template}smilebox{/template}
{/if}

</form>

<br />
