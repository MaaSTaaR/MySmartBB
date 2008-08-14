{if {{$_CONF['info_row']['ajax_search']}}}
<div id="result"></div>
{/if}

{$pager}

{if {{$_CONF['info_row']['fastreply_allow']}}}
{template}topic_end::fast_reply{/template}
{/if}
