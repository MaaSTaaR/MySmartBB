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

<script type="text/javascript">
$('.box_link').fancybox();
$('.tab-container').easytabs( { "animate" : false } );
$('.ext_img').each( function () 
{
	if ( $(this).width() > 700 )
		$(this).width( 700 );
} );
</script>