<script type="text/javascript">

function ShowAvatarList()
{
	$("#from_another_site").hide(0);
	$("#from_pc").hide(0);
	$("#avatar_list").fadeIn();
}

function ShowSiteBox()
{
	$("#avatar_list").hide(0);
	$("#from_pc").hide(0);
	$("#from_another_site").fadeIn();
}

function ShowUploadBox()
{
	$("#from_another_site").hide(0);
	$("#avatar_list").hide(0);
	$("#from_pc").fadeIn();
}

function HideAll()
{
	$("#from_pc").fadeOut();
	$("#from_another_site").fadeOut();
	$("#avatar_list").fadeOut(); 
}

function Ready()
{
	$("#option1").click(ShowAvatarList);
	$("#option2").click(ShowSiteBox);
	$("#option3").click(ShowUploadBox); 
	$("#option4").click(HideAll);
}

$(document).ready(Ready);
</script>

{template}usercp_menu{/template}

{template}address_bar_part1{/template}
<a href="index.php?page=usercp&amp;index=1">لوحة تحكم العضو</a> {$_CONF['info_row']['adress_bar_separate']} الصوره الشخصيه
{template}address_bar_part2{/template}

{if {$_CONF['rows']['member_row']['avater_path']} != ''}
	<table align="center" border="1" width="50%" class="t_style_b">
		<tr align="center">
			<td width="50%" class="thead">
			صورتك الحاليه
			</td>
		</tr>
		<tr align="center">
			<td width="50%" class="row1">
				<img border="0" alt="صورتك الحاليه" src="{$_CONF['rows']['member_row']['avater_path']}" />
			</td>
		</tr>
	</table>
	<br />
{/if}
<form enctype="multipart/form-data" name="avatar" method="post" action="index.php?page=usercp&amp;control=1&amp;avatar=1&amp;start=1">
	<table align="center" border="1" width="80%" class="t_style_b">
		<tr align="center">
			<td width="80%" class="main1 rows_space">
				الخيارات
			</td>
		</tr>
		<tr align="center">
			<td width="80%" class="row1">
				<input name="options" type="radio" value="list" id="option1" />
				<label for="option1">
				اختيار صوره شخصيه من القائمه
				</label>
			</td>
		</tr>
		<tr align="center">
			<td width="80%" class="row2">
				<input name="options" type="radio" value="site" id="option2">
				<label for="option2">
				صوره شخصيه من موقع خارجي
				</label>
			</td>
		</tr>
		{if {$_CONF['info_row']['upload_avatar']}}
		<tr align="center">
			<td width="80%" class="row1">
				<input name="options" type="radio" value="upload" id="option3" />
				<label for="option3">
				صوره شخصيه من حاسوبك الشخصي
				</label>
			</td>
		</tr>
		{/if}
		<tr align="center">
			<td width="80%" class="row2">
				<input name="options" type="radio" value="no" id="option4"/>
				<label for="option4">
				بدون صوره شخصيه
				</label>
			</td>
		</tr>
	</table>

	<br />
	
	<div id="avatar_list" style="display: none; margin-top: 1ex; margin-bottom: 2ex;">
	{template}avatar_options_list{/template}
	</div>
	
	<div id="from_another_site" style="display: none; margin-top: 1ex; margin-bottom: 2ex;">
	{template}avatar_options_site{/template}
	</div>
	
	<div id="from_pc" style="display: none; margin-top: 1ex; margin-bottom: 2ex;">
	{template}avatar_options_upload{/template}
	</div>
	
	<div align="center">
		<input type="submit" name="change_avatar" value="موافق" />
	</div>
</form>

</td>
</tr>
</table>
<br />
