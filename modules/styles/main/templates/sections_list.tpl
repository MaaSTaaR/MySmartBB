<div align="center" dir="{$lang_info['direction']}">
{hook}before_subforums_table{/hook}

{if {$SHOW_SUB_SECTIONS}}
	<table id="subforums_table" width="98%" border="1" class="t_style_b" align="center">
		<tr>
			<td class="main1 rows_space" colspan="3" align="center">
				{$lang['common']['subforums']}
			</td>
		</tr>
		<tr align="center">
			<td class="main2 rows_space small_text" width="55%" colspan="2">
				{$lang['common']['forum']}
			</td>
			<td class="main2 rows_space small_text" width="45%">
				{$lang['common']['details']}
			</td>
		</tr>
{/if}

{hook}after_subforums_table{/hook}

{Des::foreach}{forums_list}{forum}
	{if {$forum['parent']} == 0}
		{if {$forum['sort']} != 1}
		</table>
		<br />
		{/if}
		<table id="forums_table" width="98%" border="1" class="t_style_b" align="center">
		<tr>
			<td class="main1 rows_space" colspan="3" align="center">
				{$forum['title']}
			</td>
		</tr>
		<tr align="center">
			<td class="main2 rows_space small_text" width="55%" colspan="2">
				{$lang['common']['forum']}
			</td>
			<td class="main2 rows_space small_text" width="45%">
				{$lang['common']['details']}
			</td>
		</tr>
	{/if}
	{if {$forum['parent']} != 0}
		{if {$forum['linksection']} != '1'}
			<tr>
				<td class="row1" rowspan="2" width="5%" align="center">
				{if {$forum['use_section_picture']} == 1}
					{if {$forum['sectionpicture_type']} == 1}
						<img src="{$forum['section_picture']}" alt="" />
					{else}
						<img src="{$image_path}/icon-67_new.gif" alt="" />
					{/if}
				{else}
					<img src="{$image_path}/icon-67_new.gif" alt="" />
				{/if}
			</td>
			<td class="row2 rows_space" width="50%">
					<a href="{$init_path}forum/{$forum['id']}/{$forum['title']}">{$forum['title']}</a>
					<br />
					{if {$forum['use_section_picture']} == 1}
						{if {$forum['sectionpicture_type']} == 2}
							<img src="{$forum['section_picture']}" alt="" />
							<br />
						{/if}
					{/if}
					{if {$_CONF['info_row']['describe_feature']}}
					{if {$forum['section_describe']} != ''}
					{$forum['section_describe']}
					<br />
					{/if}
					{/if}
							{$lang['common']['topics']} : {$forum['subject_num']}
							{$lang['common']['comma']} {$lang['common']['replies']} : {$forum['reply_num']}
					</td>
					<td class="row1 rows_space" width="45%">
					
					{if {$forum['last_subject']} != ''}
					{$lang['common']['last_post']}							
					<a href="{$init_path}topic/{$forum['last_subjectid']}/{$forum['last_subject']}">{$forum['last_subject']}</a> 
												
					{$lang['common']['written_by']}
					<a href="{$init_path}profile/{$forum['last_writer']}">{$forum['last_writer']}</a> 
												
					{$lang['common']['on_date']} 
					{$forum['last_date']}
					<br />
						
					{else}
					{$lang['common']['no_posts']}
					{/if}
					</td>
				</tr>
				<tr>
					<td class="row1 rows_space" colspan="2">
						<strong>{$lang['common']['subforums']} {$lang['common']['colon']}</strong>
						{if {$forum['is_sub']}}
							{$forum['sub']}
						{else}
							{$lang['common']['na']}
						{/if}
						<br />
						<strong>{$lang['common']['moderators']} {$lang['common']['colon']}</strong>
						{if {$forum['is_moderators']}}
							{$forum['moderators_list']}
						{else}
							{$lang['common']['na']}
						{/if}
					</td>
				</tr>
		{else}
		<tr>
			<td width="3%" align="center" class="row1">
				{if {$forum['use_section_picture']} == 1}
					{if {$forum['sectionpicture_type']} == 1}
						<img src="{$forum['section_picture']}" alt="" />
					{else}
						<img src="{$image_path}/icon-67_new.gif" alt="" />
					{/if}
				{else}
					<img src="{$image_path}/icon-67_new.gif" alt="" />
				{/if}
			</td>
			<td width="40%" class="row1">
				<a href="{$init_path}forum/{$forum['id']}/{$forum['title']}">{$forum['title']}</a>
				<br />
				{if {$forum['use_section_picture']} == 1}
					{if {$forum['sectionpicture_type']} == 2}
						<img src="{$forum['section_picture']}" alt="" />
						<br />
					{/if}
				{/if}
				{if {$_CONF['info_row']['describe_feature']}}
				{$forum['describe']}
				{/if}
			</td>
			<td width="50%" align="center" class="row1" colspan="3">
				{$lang['common']['visit_number']} {$lang['common']['colon']} {$forum['linkvisitor']}
			</td>
		</tr>
		{/if}
		{/if}
	{/Des::foreach}
	</table>
		
</div>
<br />

{hook}after_forums_table{/hook}
