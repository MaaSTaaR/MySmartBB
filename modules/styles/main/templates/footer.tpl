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
				
				<a href="index.php?page=latest&amp;today=1">{$lang['common']['todays_topics']}</a> {if {$_CONF['group_info']['admincp_allow']}} ، <a href="admin.php">{$lang['common']['control_panel']}</a>{/if}
			</div>
		</div>

		<!-- -->
		
		<div id="footer">
		Powered By <a href="">MySmartBB</a> {$_CONF['info_row']['MySBB_version']} <br />
		Copyleft for MySmartBB team 2005, 2011
		</div>
	</div>

	</body>
</html>
