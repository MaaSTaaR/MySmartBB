{template}address_bar_part1{/template}
<a href="{$init_path}profile/
{$username}">{$lang['profile_of']} {$username}</a>
 {$_CONF['info_row']['adress_bar_separate']}
 {$lang['replies_of']} {$username}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

{DB::getInfo}{$replies_res}{$row}
	<div class="content_box">
	<a href="{$init_path}
topic/{$row['topic_id']}/
{$row['topic_title']}">{$row['topic_title']}</a> <small>{$lang['author']} <a href="{$init_path}
profile/{$row['topic_writer']}">{$row['topic_writer']}</a></small>
	<br /><br />
	{$row['reply_text']}
	</div>
	<br />
{/DB::getInfo}

<br />

{$pager}

{hook}after_replies_list_table{/hook}