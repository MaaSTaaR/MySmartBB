{$pager}

{if {$_CONF['info_row']['samesubject_show']}}
{if {$SHOW_SIMILAR}}
{template}topic_end--same_subject{/template}
{/if}
{/if}


{if {$_CONF['info_row']['fastreply_allow']}}
{if {$_CONF['member_permission']} and !{$Info['close']} or ({$Mod})}
{template}topic_end--fast_reply{/template}
{/if}
{/if}