{template}address_bar_part1{/template}
{$GetPage['title']}
{template}address_bar_part2{/template}

{hook}after_adress_bar{/hook}

<h1>{$GetPage['title']}</h1>
{hook}after_page_title{/hook}
<br />
{$GetPage['html_code']}
{hook}after_html_code{/hook}
