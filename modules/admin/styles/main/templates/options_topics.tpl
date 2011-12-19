<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=options&amp;index=1">{$lang['board_setting']}</a> &raquo; <a href="admin.php?page=options&amp;topics=1&amp;main=1">{$lang['posts_options']}</a></div>

<br />

<form action="admin.php?page=options&amp;topics=1&amp;update=1"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['posts_options']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['min_length_context']}</td>
		<td class="row1">
<input type="text" name="post_text_min" id="input_post_text_min" value="{$_CONF['info_row']['post_text_min']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">{$lang['max_length_context']}</td>
		<td class="row2">
<input type="text" name="post_text_max" id="input_post_text_max" value="{$_CONF['info_row']['post_text_max']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['min_length_title']}</td>
		<td class="row1">
<input type="text" name="post_title_min" id="input_post_title_min" value="{$_CONF['info_row']['post_title_min']}" size="30" />&nbsp;
</td>
</tr>

<tr valign="top">
		<td class="row2">{$lang['max_length_title']}</td>
		<td class="row2">
<input type="text" name="post_title_max" id="input_post_title_max" value="{$_CONF['info_row']['post_title_max']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['activate_similar_topics']}</td>
		<td class="row1">
<select name="samesubject_show" id="select_samesubject_show">
	{if {$_CONF['info_row']['samesubject_show']}}
	<option value="1" selected="selected">{$lang['common']['yes']}</option>
	<option value="0">{$lang['common']['no']}</option>
	{else}
	<option value="1">{$lang['common']['yes']}</option>
	<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['show_topic_context_pages']}</td>
		<td class="row2">
<select name="show_subject_all" id="select_show_subject_all">
	{if {$_CONF['info_row']['show_subject_all']}}
	<option value="1" selected="selected">{$lang['common']['yes']}</option>
	<option value="0">{$lang['common']['no']}</option>
	{else}
	<option value="1">{$lang['common']['yes']}</option>
	<option value="0" selected="selected">{$lang['common']['no']}</option>
	{/if}
</select>
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>

