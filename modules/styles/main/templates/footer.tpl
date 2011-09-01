		</div>
		
		<!-- -->
		
		<div id="info_bar">
			<div class="right_side">
				<select OnChange="window.location='index.php?page=change_style&amp;change=1&amp;id=' + this.value" size="1" name="style">
   				{DB::getInfo}{$style_res}{$style}
   					{if {$_CONF['style_info']['id']} == {$style['id']}}
   					<option selected="selected" value="{$style['id']}">{$style['style_title']}</option>
   					{else}
   					<option value="{$style['id']}">{$style['style_title']}</option>
   					{/if}
				{/DB::getInfo}
				</select>
			</div>
			<div class="left_side">
				
				<a href="index.php?page=latest&amp;today=1">مواضيع اليوم</a> {if {$_CONF['group_info']['admincp_allow']}} ، <a href="admin.php">لوحة الإدارة</a>{/if}
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
		Powered By <a href="">MySmartBB</a> 2.0.0 THETA 1 <br />
		Copyleft for MySmartBB team 2005, 2011
		</div>
	</div>

	</body>
</html>
