<div class="usercp_menu">
	<table border="1" class="t_style_b">
		<tr align="center">
     		<td class="main1 rows_space">
     			<a href="index.php?page=usercp&amp;index=1">لوحة التحكم</a>
     		</td>
     	</tr>
     	{if {$_CONF['info_row']['pm_feature']}}
     	<tr align="center">
     		<td class="main2 rows_space">
     		الرسائل الخاصة
     		</td>
     	</tr>
     	
     	<tr align="center">
     		<td class="row1">
     			<a href="index.php?page=pm_send&amp;send=1&amp;index=1">إرسال رسالة</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=pm_list&amp;list=1&amp;folder=inbox">صندوق الرسائل</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=pm_list&amp;list=1&amp;folder=sent">الرسائل الصادرة</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=pm_list&amp;send_list=1&amp;index=1">قائمة المراسلات</a>
     		</td>
     	</tr>
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=pm_setting&amp;setting=1&amp;index=1">اعدادات الرسائل الخاصه</a>
     		</td>
     	</tr>
     	{/if}
     	<tr>
     		<td class="main2 rows_space" align="center">
     		إدارة الملف الشخصي
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;control=1&amp;info=1&amp;main=1">معلوماتك الشخصية</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;control=1&amp;setting=1&amp;main=1">خياراتك الخاصة</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;control=1&amp;sign=1&amp;main=1">تغيير التوقيع</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;control=1&amp;password=1&amp;main=1">تغيير الكلمة السرية</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;control=1&amp;email=1&amp;main=1">تغيير البريد الالكتروني</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;control=1&amp;avatar=1&amp;main=1">تغيير الصورة الشخصية</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="main2 rows_space" align="center">
     		الخيارات
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;options=1&amp;reply=1&amp;main=1">المواضيع المشترك بها</a>
     		</td>
     	</tr>
     	
     	<tr>
     		<td class="row1" align="center">
     			<a href="index.php?page=usercp&amp;options=1&amp;subject=1&amp;main=1">مواضيعك الخاصة</a>
     		</td>
     	</tr>
     	
     	{if {$_CONF['info_row']['bookmark_feature']}}
		<tr>
			<td class="row1" align="center">
				<a href="index.php?page=usercp&amp;bookmark=1&amp;show=1">المواضيع المفضلة</a>
			</td>
		</tr>
		{/if}
     </table>
</div>
<br />
