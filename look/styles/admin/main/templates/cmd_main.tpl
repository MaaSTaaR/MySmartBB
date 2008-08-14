<script src="includes/js/ajax.js" type="text/javascript" language="javascript"></script>
		
<script language="javascript">
	var ajax = new MySmartAjax();
	var command;
	
	ajax.InitAjax();
	
	function Ready()
	{	
		if (ajax.ajax.readyState == 0)
		{
			document.getElementById("result").innerHTML += "يرجى الانتظار<br />";
		}
		else if (ajax.ajax.readyState > 0 && ajax.ajax.readyState < 4)
		{
			document.getElementById("result").innerHTML += "جاري تنفيذ الامر<br />";
		}
		else if (ajax.ajax.readyState == 4)
		{
			document.getElementById("result").innerHTML += ajax.ajax.responseText + "<br />";
		}
	}
	
	function ApplyCommand()
	{
		command = document.getElementById("input_command").value;
		
		var param = "command=" + command;
		
		ajax.SendRequest("admin.php?page=cmd&execute=1",Ready,param);
	}
</script>

<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=cmd&amp;index=1">سطر الاوامر</a></div>

<br />
		
<div id="result"></div>

<table width="70%" class="t_style_b" border="1" align="center">
	<tr align="center">
		<td class="main1 rows_space" colspan="2">
		سطر الاوامر
		</td>
	</tr>
	<tr align="center">
		<td class="row1" colspan="2">
			<input type="text" name="command" id="input_command" value="" size="50" />
		</td>
	</tr>
</table>

<br />

<input type="button" id="enter" value="موافق" size="30" onclick="ApplyCommand()" />
