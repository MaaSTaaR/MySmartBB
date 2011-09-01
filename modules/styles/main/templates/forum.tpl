{template}address_bar_part1{/template}
{$section_info['title']}
{template}address_bar_part2{/template}

{if {$SHOW_SUB_SECTIONS}}
{template}sections_list{/template}
{/if}

{template}forum--online_table{/template}

{if {$SHOW_ANNOUNCEMENT}}
{template}forum--announcement_table{/template}
{/if}

{if {$SHOW_MODERATORS}}
{template}forum--moderator_table{/template}
{/if}


{template}add_subject_link{/template}
{template}forum--subject_table{/template}
