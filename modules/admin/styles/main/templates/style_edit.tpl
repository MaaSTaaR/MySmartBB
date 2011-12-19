<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; <a href="admin.php?page=style&amp;control=1&amp;main=1">{$lang['styles']}</a> &raquo; {$lang['common']['edit']} : {$Inf['style_title']}</div>

<br />

<form action="admin.php?page=style&amp;edit=1&amp;start=1&amp;id={$Inf['id']}"  name="myform" method="post">
<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr valign="top" align="center">
	<td class="main1" colspan="2">{$lang['edit_style']}</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['style_title']}</td>
		<td class="row1">
<input type="text" name="name" id="input_name" value="{$Inf['style_title']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">

		<td class="row2">{$lang['active_style']}</td>
		<td class="row2">
		<select name="style_on" id="select_style_on">
		{if {$Inf['style_on']}}
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
		<td class="row1">{$lang['order']}</td>
		<td class="row1">
<input type="text" name="order" id="input_order" value="{$Inf['style_order']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['css_path']}</td>
		<td class="row2">
<input type="text" name="style_path" id="input_style_path" value="{$Inf['style_path']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['images_path']}</td>

		<td class="row1">
<input type="text" name="image_path" id="input_image_path" value="{$Inf['image_path']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row2">{$lang['templates_path']}</td>
		<td class="row2">
<input type="text" name="template_path" id="input_template_path" value="{$Inf['template_path']}" size="30" />&nbsp;
</td>
</tr>
<tr valign="top">
		<td class="row1">{$lang['compiled_path']}</td>

		<td class="row1">
<input type="text" name="cache_path" id="input_cache_path" value="{$Inf['cache_path']}" size="30" />&nbsp;
</td>
</tr>
</table><br />
<div align="center"><tr>
	<td class="submit-buttons" colspan="2" align="center">
	<input class="submit" type="submit" value="{$lang['common']['submit']}" name="submit" accesskey="s" /></td>
</tr>
</table><br />
</form>
