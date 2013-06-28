<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; إحصائيات المرفقات</div>

<br />

<table width="80%" class="t_style_b rows_space" border="1" align="center">
	<tr align="center">
		<td class="main1" colspan="2">إحصائيات المرفقات</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">إجمالي المرفقات</td>
		<td class="row2" width="40%">{$stat['attach_total']}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">الحجم المُستهلك</td>
		<td class="row2" width="40%">{$stat['size_total']} MB</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">إجمالي التحميلات</td>
		<td class="row2" width="40%">{$stat['downloads_total']}</td>
	</tr>
	<tr align="center">
		<td class="row1" width="40%">أكثر الملفات تحميلاً</td>
		<td class="row2" width="40%">{$stat['top_downloaded']['filename']} 
		<small>(في الموضوع <a target="_blank" href="{$init_path}topic/
{$stat['top_downloaded']['subject_id']}/{$stat['top_downloaded']['topic_title']}">{$stat['top_downloaded']['topic_title']}</a> للكاتب
<a target="_blank" href="{$init_path}profile/
{$stat['top_downloaded']['topic_writer']}">{$stat['top_downloaded']['topic_writer']}</a> بعدد {$stat['top_downloaded']['visitor']})</small></td>
	</tr>
</table>