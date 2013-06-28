<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; {$lang['attachment_statistics']}</div>

<br />

<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">{$lang['attachment_statistics']}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['attach_total']}</td>
		<td class="row2" width="40%">{$stat['attach_total']}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['attach_size']}</td>
		<td class="row2" width="40%">{$stat['size_total']} MB</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['downloads_total']}</td>
		<td class="row2" width="40%">{$stat['downloads_total']}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">{$lang['most_downloaded']}</td>
		<td class="row2" width="40%">{$stat['top_downloaded']['filename']} 
		<small>({$lang['in_topic']} <a target="_blank" href="{$init_path}topic/
{$stat['top_downloaded']['subject_id']}/{$stat['top_downloaded']['topic_title']}">{$stat['top_downloaded']['topic_title']}</a> {$lang['author']} 
<a target="_blank" href="{$init_path}profile/
{$stat['top_downloaded']['topic_writer']}">{$stat['top_downloaded']['topic_writer']}</a> {$lang['downloads']} {$stat['top_downloaded']['visitor']})</small></td>
	</tr>
</table>