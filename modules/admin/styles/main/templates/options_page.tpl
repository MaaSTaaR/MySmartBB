<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;pages=1&amp;main=1">{$lang['page_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;pages=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['page_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['page_counts']}</td>
		<td class="row1">
<input type="text" name="page_max" id="input_page_max" value="{$_CONF['info_row']['page_max']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">{$lang['max_topics']}</td>
		<td class="row2">
<input type="text" name="subject_perpage" id="input_subject_perpage" value="{$_CONF['info_row']['subject_perpage']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['max_replies']}</td>
		<td class="row1">
<input type="text" name="reply_perpage" id="input_reply_perpage" value="{$_CONF['info_row']['perpage']}" size="30" />&nbsp;
</td>
</tr>

<tr valign="top">
		<td class="row2">{$lang['max_avatar']}</td>
		<td class="row2">
<input type="text" name="avatar_perpage" id="input_avatar_perpage" value="{$_CONF['info_row']['avatar_perpage']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />

</form>
