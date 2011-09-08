<script src="includes/js/jquery.js"></script>

<br />

<form name="topic" method="post" action="index.php?page=new_reply&amp;start=1&amp;id={$id}{$password}">

{if {$_CONF['info_row']['icons_show']}}
{template}iconbox{/template}
{/if}

<br />

{if {$_CONF['info_row']['toolbox_show']}}
{template}toolbox{/template}
{/if}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		{$lang['reply_context']}
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			{$lang['reply_title']} {$lang['common']['colon']}
			<input name="title" id="title_id" type="text" {if {$_CONF['info_row']['title_quote']}} 
			value="{$lang['reply']} {$lang['common']['colon']} {$Info['title']}" {/if} />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<div id="status"></div>
			<textarea rows="12" name="text" id="text_id" cols="69"></textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="{$lang['common']['submit']}" />
		</td>
	</tr>
</table>

<br />

{if {$Admin}}
{if {$_CONF['info_row']['activate_closestick']}}
<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="2">
		{$lang['management_options']}
		</td>
	</tr>
	<tr>
		<td class="row2 rows_space" colspan="2">
			<input name="stick" id="stick_id" type="checkbox" {if {$stick}}checked="checked"{/if} /> <label for="stick_id">{$lang['stick_subject']}</label>
			<br />
			<input name="close" id="close_id" type="checkbox" {if {$close}}checked="checked"{/if} /> <label for="close_id">{$lang['close_subject']}</label>
		</td>
	</tr>
</table>
<br />
{/if}
{/if}

{if {$_CONF['info_row']['smiles_show']}}
{template}smilebox{/template}
{/if}

</form>

<br />
