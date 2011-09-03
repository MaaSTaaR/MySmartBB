<a href="index.php?page=profile&amp;show=1&amp;username={$Info['username']}">{$Info['display_username']}</a>
<br />
{$Info['user_title']}
<br />
{if {$Info['avater_path']} != ''}
	<br />
	<img src="{$Info['avater_path']}" border="0" align="center" alt="صوره {$Info['username']} الشخصيه" />
{else}
	{if {$_CONF['info_row']['default_avatar']} != '' and {$_CONF['info_row']['default_avatar']} != 'http://'}
	<img src="{$_CONF['info_row']['default_avatar']}" border="0" align="center" alt="صوره {$Info['username']} الشخصيه" />
	{/if}
{/if}

<br /><br />

<fieldset>
	<legend><a href="index.php?page=profile&amp;show=1&amp;username={$Info['username']}">الهويه الشخصيه</a></legend>
	
	<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
		<tr align="center">
			<td width="60%">
				رقم العضويه :
			</td>
			<td width="40%">
				{$Info['id']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				تاريخ التسجيل :
			</td>
			<td width="40%">
				{$Info['register_date']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				الحاله :
			</td>
			<td width="40%">
				{if {$status} == 'online'}
				<span class='online'>متصل</span>
				{else}
				<span class='offline'>غير متصل</span>
				{/if}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				المشاركات :
			</td>
			<td width="40%">
				{$Info['posts']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				الدوله :
			</td>
			<td width="40%">
				{$Info['user_country']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				الجنس :
			</td>
			<td width="40%">
				{$Info['user_gender']}
			</td>
		</tr>
		<tr align="center">
			<td width="60%">
				الزيارات :
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
		<legend>العضو غائب</legend>
		{$Info['away_msg']}
	</fieldset>
{/if}
