<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="">{$lang['closed_topics']}</a></div>

<br />

<table cellpadding="3" cellspacing="1" width="90%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1">{$lang['topic_title']}</td>
	<td class="main1">{$lang['writer']}</td>
</tr>
{DB::getInfo}{$CloseList}
<tr valign="top" align="center">
	<td class="row1"><a href="{$init_path}topic/
	{$CloseList['id']}/
	{$CloseList['title']}" traget="_blank">{$CloseList['title']}</a></td>
	<td class="row1"><a href="{$init_path}profile/
	{$CloseList['writer']}" traget="_blank">{$CloseList['writer']}</a></td>
</tr>
{/DB::getInfo}
</table>
