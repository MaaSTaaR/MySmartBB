<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=extension&amp;search=1&amp;main=1">{$lang['search_attachments']}</a> &raquo; <a href="admin.php?page=extension&amp;search=1&amp;main=1">{$lang['search']}</a> &raquo; {$lang['search_result']}</div>

<br />

<div align="center">

	<table width="90%" class="t_style_b" border="1">
		<tr align="center">
			<td class="main1">
			{$lang['filename']}
			</td>
			<td class="main1">
			{$lang['downloads']}
			</td>
			<td class="main1">
			{$lang['filesize']}
			</td>
			<td class="main1">
			{$lang['see_topic']}
			</td>
		</tr>
		<tr align="center">
			<td class="row1">
				<a href="./index.php?page=download&amp;attach=1&amp;id={$Inf['id']}">{$Inf['filename']}</a>
			</td>
			<td class="row1">
				{$Inf['visitor']}
			</td>
			<td class="row1">
				{$Inf['filesize']}
			</td>
			<td class="row1">
				<a href="./index.php?page=topic&amp;show=1&amp;id={$Inf['subject_id']}" target="_blank">[{$lang['see_topic']}‎]‏</a>
			</td>
		</tr>
	</table>
</div>
