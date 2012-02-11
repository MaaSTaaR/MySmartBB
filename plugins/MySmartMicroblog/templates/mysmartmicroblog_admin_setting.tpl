<br />

<div class="address_bar">{$lang['common']['cp']} &raquo; MySmartMicroblog &raquo; {$plugin_lang['settings']}</div>

<br />

<form action="admin.php?page=plugins&amp;setting=1&amp;name=MySmartMicroblog&amp;start=1" method="post">

<table cellpadding="3" cellspacing="1" width="60%" class="t_style_b" border="1" align="center">
<tr align="center">
	<td class="main1" colspan="2">{$plugin_lang['settings']}</td>
</tr>
<tr>
    <td class="row1">{$plugin_lang['post_max_length']}</td>
    <td class="row1">
        <input type="text" name="length_of_post" value="{$_CONF['info_row']['mysmartmicroblog_post_max_len']}" />
    </td>
</tr>
</table>

<div align="center">
	<input type="submit" value="{$lang['common']['submit']}" name="submit" />
</div>

</form>
