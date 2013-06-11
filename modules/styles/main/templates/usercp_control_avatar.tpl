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

<div class="usercp_context {$_CONF['opp_align']}_side">

{template}address_bar_part1{/template}
<a href="{$init_path}usercp">{$lang['usercp']}</a> {$_CONF['info_row']['adress_bar_separate']} {$lang['avatar']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

{if {$_CONF['member_row']['avater_path']} != ''}
	<table id="current_avatar_table" align="center" border="1" width="50%" class="t_style_b">
		<tr align="center">
			<td width="50%" class="main1">
			{$lang['your_avatar']}
			</td>
		</tr>
		<tr align="center">
			<td width="50%" class="row1">
				<img border="0" alt="{$lang['your_avatar']}" src="{$_CONF['member_row']['avater_path']}" />
			</td>
		</tr>
	</table>
	<br />
{/if}

{hook}after_current_avatar_table{/hook}

<form enctype="multipart/form-data" name="avatar" method="post" action="{$init_path}usercp_control_avatar/start">
	<table id="avatar_options_table" align="center" border="1" width="80%" class="t_style_b">
		<tr align="center">
			<td width="80%" class="main1 rows_space">
				{$lang['options']}
			</td>
		</tr>
		{if {$SHOW_AVATAR_LIST}}
		<tr align="center">
			<td width="80%" class="row1">
				<input name="options" type="radio" value="list" id="option1" />
				<label for="option1">
				{$lang['avatar_from_list']}
				</label>
			</td>
		</tr>
		{/if}
		<tr align="center">
			<td width="80%" class="row2">
				<input name="options" type="radio" value="site" id="option2">
				<label for="option2">
				{$lang['avatar_from_website']}
				</label>
			</td>
		</tr>
		{if {$_CONF['info_row']['upload_avatar']}}
		<tr align="center">
			<td width="80%" class="row1">
				<input name="options" type="radio" value="upload" id="option3" />
				<label for="option3">
				{$lang['avatar_from_pc']}
				</label>
			</td>
		</tr>
		{/if}
		<tr align="center">
			<td width="80%" class="row2">
				<input name="options" type="radio" value="no" id="option4"/>
				<label for="option4">
				{$lang['no_avatar']}
				</label>
			</td>
		</tr>
	</table>

	<br />
	
	{if {$SHOW_AVATAR_LIST}}
	<div id="avatar_list" style="display: none; margin-top: 1ex; margin-bottom: 2ex;">
	{template}avatar_options_list{/template}
	</div>
	{/if}
	
	<div id="from_another_site" style="display: none; margin-top: 1ex; margin-bottom: 2ex;">
	{template}avatar_options_site{/template}
	</div>
	
	<div id="from_pc" style="display: none; margin-top: 1ex; margin-bottom: 2ex;">
	{template}avatar_options_upload{/template}
	</div>
	
	<div align="center">
		<input type="submit" name="change_avatar" value="{$lang['common']['submit']}" />
	</div>
</form>

</div>

<br />

{hook}after_avatar_options_table{/hook}
