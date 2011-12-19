<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AjaxTitle()
{	
	var data = {};
	
	data['title']	=	$("#title_id").val();
	data['id']		=	$("#m_section_id").val();
	data['ajax']	=	true;
		
	$.post("admin.php?page=ajax&sections=1&rename=1",data,Success);
}

function Success(xml)
{
	$("#title-" + $("#m_section_id").val()).html(xml);
}

function AjaxEdit()
{	
	$(this).html('<input type="text" name="title" id="title_id" value="' + $(this).text() + '" /><input type="hidden" name="m_section" id="m_section_id" value="' + $(".section_id").val() + '" /><input type="button" name="button" class="input_button" value="{$lang['common']['submit']}" />');
	
	$(".input_button").click(AjaxTitle);
}

function Ready()
{
	$("td[id]").dblclick(AjaxEdit);
}

$(document).ready(Ready);
</script>

<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=sections&amp;control=1&amp;main=1">{$lang['sections']}</a></div>

<br />

<div id="status" align="center"></div>

<br />
		
<form action="admin.php?page=sections_sort&amp;start=1" method="post">
<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['section_title']}</td>
	<td class="main1">{$lang['permissions']}</td>
	<td class="main1">{$lang['common']['edit']}</td>
	<td class="main1">{$lang['common']['delete']}</td>
	<td class="main1">{$lang['section_order']}</td>
</tr>
{DB::getInfo}{$SecList}
<tr valign="top" align="center">
	<td class="row1" id="title-{#SecList['id']#}"><input type="hidden" name="section" class="section_id" value="{$SecList['id']}" />{$SecList['title']}</td>
	<td class="row1"><a href="./admin.php?page=sections_groups&amp;index=1&amp;id={$SecList['id']}">{$lang['permissions']}</a></td>
	<td class="row1"><a href="./admin.php?page=sections_edit&amp;main=1&amp;id={$SecList['id']}">{$lang['common']['edit']}</a></td>
	<td class="row1"><a href="./admin.php?page=sections_del&amp;main=1&amp;id={$SecList['id']}">{$lang['common']['delete']}</a></td>
	<td class="row1"><input type="text" name="order-{$SecList['id']}" id="input_order-{$SecList['id']}" value="{$SecList['sort']}" size="5" /></td>
</tr>
{/DB::getInfo}
</table>

<br />
<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" />
</form>
