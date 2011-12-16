<br />

<div class="address_bar">
{$lang['common']['cp']} &raquo; <a href="admin.php?page=plugin&amp;control=1&amp;main=1"> {$lang['plugins_system']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr align="center">
	<td class="main1" colspan="3">{$lang['installed_plugins']}</td>
</tr>
<tr align="center">
	<td class="main1">{$lang['plugin_name']}</td>
	<td class="main1">{$lang['enable_disable']}</td>
	<td class="main1">{$lang['uninstall']}</td>
</tr>
{DB::getInfo}{$installed}
<tr align="center">
	<td class="row1">{$installed['title']}</td>
	<td class="row1">
		{if {$installed['active']} == 1}
		<a href="admin.php?page=plugins&amp;deactive=1&amp;id={$installed['id']}">{$lang['enable']}</a>
		{else}
		<a href="admin.php?page=plugins&amp;active=1&amp;id={$installed['id']}">{$lang['disable']}</a>
		{/if}
	</td>
	<td class="row1"><a href="admin.php?page=plugins&amp;uninstall=1&amp;main=1&amp;id={$installed['id']}">{$lang['uninstall']}</a></td>
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
