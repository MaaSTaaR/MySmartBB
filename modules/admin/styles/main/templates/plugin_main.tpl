<br />

<div class="address_bar">
{$lang['common']['cp']} &raquo; <a href="admin.php?page=plugin&amp;control=1&amp;main=1"> {$lang['plugins_system']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr align="center">
	<td class="main1" colspan="4">{$lang['installed_plugins']}</td>
</tr>
<tr align="center">
	<td class="main1">{$lang['plugin_name']}</td>
	<td class="main1">{$lang['enable_disable']}</td>
	<td class="main1">{$lang['uninstall']}</td>
	<td class="main1">{$lang['setting']}</td>
</tr>
{DB::getInfo}{$installed}
<tr align="center">
	<td class="row1">{$installed['title']}</td>
	<td class="row1">
		{if {$installed['active']} == 1}
		<a href="admin.php?page=plugins&amp;deactive=1&amp;id={$installed['id']}">{$lang['disable']}</a>
		{else}
		<strong><a href="admin.php?page=plugins&amp;active=1&amp;id={$installed['id']}">{$lang['enable']}</a></strong>
		{/if}
	</td>
	<td class="row1"><a href="admin.php?page=plugins&amp;uninstall=1&amp;main=1&amp;id={$installed['id']}">{$lang['uninstall']}</a></td>
	<td class="row1">
	    {if {$installed['setting_page']} == 1}
	    <strong>
	    <a href="admin.php?page=plugins&amp;setting=1&amp;name={$installed['path']}&amp;main=1">
	    {else}
	    <del>
	    {/if}
	    {$lang['setting']}
	    {if {$installed['setting_page']} == 1}
	    </a>
	    </strong>
	    {else}
	    </del>
	    {/if}
	</td>
</tr>
{/DB::getInfo}
</table>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr align="center">
	<td class="main1" colspan="2">{$lang['installable_plugins']}</td>
</tr>
<tr align="center">
	<td class="main1">{$lang['plugin_path']}</td>
	<td class="main1">{$lang['install']}</td>
</tr>
{Des::foreach}{uninstalled_list}{list}
<tr align="center">
	<td class="row1">{$list}</td>
	<td class="row1"><a href="admin.php?page=plugins&amp;install=1&amp;path={$list}">{$lang['install']}</a></td>
</tr>
{/Des::foreach}
</table>
