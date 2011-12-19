<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="">{$lang['mass_delete']}</a></div>

<br />
<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<p align="center">{$lang['choose_forum_mass_delete']}</p>
<br />
{Des::foreach}{forums_list}{forum}
<tr valign="top" align="center">
{if {$forum['parent']} == 0}
	<td class="main1" colspan="2">
		{$forum['title']}
	</td>
{else}
	<td class="row1" colspan="2">
		<a href="admin.php?page=subject&amp;mass_del=1&amp;confirm=1&amp;id={$forum['id']}" target="main">{$forum['title']}</a>
	</td>
{/if}
</tr>
{/Des::foreach}
</table>
