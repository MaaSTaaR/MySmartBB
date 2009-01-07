<br />

{if {$_CONF['info_row']['ajax_search']}}
<script src="includes/js/jquery.js"></script>

<script language="javascript">
function AjaxSearch()
{
	var AjaxState = {ajaxSend : Wait};
	
	var data = {};
	
	data['keyword'] 	= 	$("#keyword_id").val();
	data['username'] 	= 	$("#username_id").val();
	data['section'] 	= 	$("#section_id").val();
	data['ajax']		=	1;
	
	$.post("index.php?page=search&start=1",data,Success);
}

function Wait()
{
	$("#result").html("جاري تنفيذ العمليه");
}

function Success(xml)
{
	$("#result").html(xml);
}

function Ready()
{
	$("#search_id").click(AjaxSearch);
}

$(document).ready(Ready);
</script>
{/if}

{template}address_bar_part1{/template}
البحث
{template}address_bar_part2{/template}

<form name="search" method="get">

<input type="hidden" name="page" value="search">
<input type="hidden" name="start" value="1">

<table border="1" width="60%" class="t_style_b" align="center">
	<tr align="center">
		<td class="main1 rows_space" width="60%" colspan="2">
		محرك البحث
		</td>
	</tr>
	<tr align="center">
		<td class="row1" width="25%">
		الكلمة البحث
		</td>

        <td class="row1" width="25%">
        	<input type="text" name="keyword" id="keyword_id" />
        </td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
		بمعرّف معين
		</td>
        <td class="row1" width="50%">
        	<input type="text" name="username" id="username_id" />
        </td>
	</tr>
	<tr align="center">
		<td class="row1" width="50%">
		المنتدى
		</td>

        <td class="row1" width="50%">
        	<select size="1" name="section" id="section_id">
        		<option selected="selected" value="all">[جميع المنتديات]</option>
        		{Des::foreach}{forums_list}{forum}
        		{if {$forum['parent']} == 0}
				<option value="{$forum['id']}" class="main_section">- {$forum['title']}</option>
				{else}
				<option value="{$forum['id']}">-- {$forum['title']}</option>
				{/if}
				{/Des::foreach}
			</select>
		</td>
	</tr>
</table>

<br />

<div align="center">
{if {$_CONF['info_row']['ajax_search']}}
	<input type="button" value="بحث" name="search" id="search_id">
{else}
	<input type="submit" value="بحث" name="search">
{/if}
</div>

</form>

{if {$_CONF['info_row']['ajax_search']}}
<br />
<div id="result">
</div>
{/if}
