<div align="center">
<a href="index.php?page=profile&amp;show=1&amp;username={$Info['username']}">{$Info['display_username']}</a>
<br />
{$Info['user_title']}
<br />
{if {$Info['avater_path']} != ''}
	<br />
	<img src="{$Info['avater_path']}" border="0" align="center" alt="{$lang['member_avatar']} 
	{$Info['username']}" />
{else}
	{if {$_CONF['info_row']['default_avatar']} != '' and {$_CONF['info_row']['default_avatar']} != 'http://'}
	<img src="{$_CONF['info_row']['default_avatar']}" border="0" align="center" alt="{$lang['member_avatar']} {$Info['username']}" />
	{/if}
{/if}
</div>

<br /><br />

<fieldset>
	<legend>
	<a href="index.php?page=profile&amp;show=1&amp;username={$Info['username']}">{$lang['member_profile']}</a>
	</legend>
	
	<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
		<tr align="center">
			<td width="60%">
				{$lang['member_id']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{$Info['id']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				{$lang['register_date']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{$Info['register_date']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				{$lang['status']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{if {$status} == 'online'}
				<span class='online'>{$lang['online']}</span>
				{else}
				<span class='offline'>{$lang['offline']}</span>
				{/if}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				{$lang['posts']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{$Info['posts']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				{$lang['country']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{$Info['user_country']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				{$lang['gender']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{$Info['user_gender']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				{$lang['visits']} {$lang['common']['colon']}
			</td>
			<td width="40%">
				{$Info['visitor']}
			</td>
		</tr>
	</table>
</fieldset>

{if {$Info['away']}}
	<br />
	<fieldset>
		<legend>{$lang['member_is_away']}</legend>
		{$Info['away_msg']}
	</fieldset>
{/if}
