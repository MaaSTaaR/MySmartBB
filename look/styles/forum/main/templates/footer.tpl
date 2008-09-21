		</div>
		
		<!-- -->
		
		<div id="info_bar">
			<div class="right_side">
				<select OnChange="window.location='index.php?page=change_style&amp;change=1&amp;id=' + this.value" size="1" name="style">
   					{Des::while}{StyleList}<option value="{$StyleList['id']}" {if {$StyleList['id']} == {$_CONF['rows']['style']['id']}}selected="selected" style="background : #EEEEEE"{/if}>{$StyleList['style_title']}</option>
				{/Des::while}
				</select>
			</div>
			<div class="left_side">
				<a href="index.php?page=latest&amp;today=1">مواضيع اليوم</a> ، <a href="">مراسلة الاداره</a>
			</div>
		</div>
		
		<!-- -->
		
		<div id="footer">
			<a href="{$_SERVER['PHP_SELF']}{if {$_SERVER['QUERY_STRING']} != ''}
			?{$_SERVER['QUERY_STRING']}&amp;debug=1
			{else}
			?debug=1 
			{/if}">Queries number</a> : {$query_num} , Memory usage : {$memory_usage} KB
		</div>
		
		<!-- -->
		
		<div id="footer">
		Powered By <a href="">MySmartBB</a> 2.0 THETA 1<br />
		Copyleft for MySmartBB team 2005, 2007
		</div>
	</div>

	</body>
</html>
