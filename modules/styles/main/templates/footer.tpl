		</div>
		
		<!-- -->
		
		<div id="info_bar">
			<div class="right_side">
				<select OnChange="window.location='{$init_path}change_style/' + this.value" size="1" name="style">
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
				<a href="{$init_path}latest/today">{$lang['common']['todays_topics']}</a> {if {$_CONF['group_info']['admincp_allow']}} {$lang['common']['comma']} <a href="admin.php">{$lang['common']['control_panel']}</a>{/if}
			</div>
		</div>
		
		{hook}after_styles_list{/hook}

		<!-- -->
		
	<div id="footer">
		Powered By <a href="http://www.mysmartbb.com" target="_blank">MySmartBB</a> {$_CONF['info_row']['MySBB_version']} <br />
		Copyleft for MySmartBB team 2005, 2013
	</div>
	
	{hook}after_copyright{/hook}
	
	</body>
</html>
