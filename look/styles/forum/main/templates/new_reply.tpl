{template}address_bar_part1{/template}
<a href="index.php?page=forum&amp;show=1&amp;id={$id}{$password}">{$section_info['title']}</a> {$_CONF['info_row']['adress_bar_separate']} <a href="index.php?page=topic&amp;show=1&amp;id={$id}{$password}">{$subject_info['title']}</a> {$_CONF['info_row']['adress_bar_separate']} اضافة رد جديد
{template}address_bar_part2{/template}

<br />

<form name="topic" method="post" action="index.php?page=new_reply&amp;start=1&amp;id={$id}{$password}">

{template}iconbox{/template}

<br />

{template}toolbox{/template}

<br />

<table border="1" width="98%" class="t_style_b" align="center">
	<tr>
		<td class="main1 rows_space" colspan="7">
		محتوى الرد
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space">
			عنوان الرد : <input name="title" type="text" />
		</td>
	</tr>
	<tr align="center">
		<td class="row1 rows_space" colspan="2">
			<textarea rows="12" name="text" cols="69"></textarea>
			<br />
			<br />
			<input name="insert" type="submit" value="موافق" />
		</td>
	</tr>
</table>

<br />

{template}smilebox{/template}

</form>

<br />
