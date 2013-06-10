<div class="usercp_menu {$_CONF['align']}_side">
	<table id="usercp_menu_table" border="1" class="t_style_b">
		<tr align="center">
     		<td class="main1 rows_space">
     			<a href="{$init_path}usercp">{$lang['usercp']}</a>
     		</td>
     	</tr>
     	{if {$_CONF['info_row']['pm_feature']}}
     	<tr align="center">
     		<td class="main2 rows_space">
     		{$lang['pms']}
     		</td>
     	</tr>
     	
     	<tr align="center">
     		<td class="row1">
     			<a href="{$init_path}pm_send">{$lang['send_pm']}</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="{$init_path}pm_list/inbox">{$lang['inbox']}</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="{$init_path}pm_list/sent">{$lang['sent_pms']}</a>
     		</td>
     	</tr>
     	<tr>
     		<td class="row1" align="center">
     			<a href="{$init_path}pm_setting">{$lang['pm_setting']}</a>
     		</td>
     	</tr>
     	{hook}end_of_pm_options{/hook}
     	{/if}
     	{hook}before_profile_options{/hook}
     	<tr>
     		<td class="main2 rows_space" align="center">
     		{$lang['profile_edit']}
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_control_info&amp;main=1">{$lang['personal_info']}</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_control_setting&amp;main=1">{$lang['settings']}</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_control_signature&amp;main=1">{$lang['change_sign']}</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_control_password&amp;main=1">{$lang['change_password']}</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_control_email&amp;main=1">{$lang['change_email']}</a>
     		</td>
     	</tr>
     	{if {$_CONF['info_row']['allow_avatar']}}
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_control_avatar&amp;main=1">{$lang['change_avatar']}</a>
     		</td>
     	</tr>
     	{/if}
     	{hook}end_of_profile_options{/hook}
     	<tr>
     		<td class="main2 rows_space" align="center">
     		{$lang['options']}
     		</td>
     	</tr>
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp_option_subject&amp;main=1">{$lang['own_topics']}</a>
     		</td>
     	</tr>
     	{hook}end_of_member_options{/hook}






     </table>
</div>
<br />
