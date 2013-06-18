<span>{$lang['move_subject_to']}</span>
<select size="1" name="section" id="section_id">
	{Des::foreach}{forums_list}{forum} 
	{if {$forum['parent']} == 0}
	<option value="{$forum['id']}" disabled="disabled">-{$forum['title']}</option> 
	{else} 
	{if {$forum['id']} == {$section}}
	<option value="{$forum['id']}">-- {$forum['title']}</option>
	{else}
	<option value="{$forum['id']}" selected="selected">--{$forum['title']}</option> 
	{/if} 
	{/if} 
	{/Des::foreach}
</select>