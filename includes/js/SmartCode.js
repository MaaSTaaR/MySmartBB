function code(Y)
{
	var form = document.topic.text;
	
	if (Y != 4)
	{
		var X = prompt("«·‰’","")
	
		if (X == "" || X == null)
		{
			return false;
		}
	}
	
	switch (Y)
	{
		case 1: // B
			form.value = form.value + "[b]" + X + "[/b]" + " ";
			form.focus();
			break;
		case 2: // I
			form.value = form.value + "[i]" + X + "[/i]" + " ";
			form.focus();
			break;
		case 3: // U
			form.value = form.value + "[u]" + X + "[/u]" + " ";
			form.focus();
			break;
		case 4: // URL
			var N = prompt("≈œŒ· «”„ «·„Êﬁ⁄ (≈Œ Ì«—Ï","");
			var X = prompt("≈œŒ· Ê’·… «·„Êﬁ⁄","http://");
			
			if (X.substr(0,7) != "http://")
			{
				alert("Ì—ÃÏ ﬂ «»… http://");
				form.focus();
				return false;
			}
			
			if (N == "" || N == null)
			{
				form.value = form.value + "[url]" + X + "[/url]" + " ";
				form.focus();
			}
			else
			{
				form.value = form.value + "[url=" + X + "]" + N + "[/url]" + " ";
				form.focus();
			}
			break;
		case 5: // Image
			form.value = form.value + "[img]" + X + "[/img]" + " ";
			form.focus();
			break;
		case 6: // Code
			form.value = form.value + "[code]" + X + "[/code]" + " ";
			form.focus();
			break;
		case 7: // Quote
			form.value = form.value + "[quote]" + X + "[/quote]" + " ";
			form.focus();
			break;
			
	}
}

function Sizes()
{
	var form 		= 	document.topic.text;
	var FontSize 	= 	document.topic.SizesList.value;
	
	if (FontSize == 0)
	{
		form.focus();
	}
	
	var X = prompt("≈œŒ· «·‰’","");
	
	if (X != "" & X != null)
	{
		form.value = form.value + "[size=" + FontSize + "]" + X + "[/size]";
  		document.topic.SizesList.selectedIndex = 0;
  		form.focus();
 	}
    else
    {
  		document.topic.SizesList.selectedIndex = 0;
  		form.focus();
    }
}

function Colors()
{
	var form 		= 	document.topic.text;
	var ColorName 	= 	document.topic.ColorsList.value;
	
	if (ColorName == 0)
	{
		form.focus();
	}
	
	var X = prompt("≈œŒ· «·‰’","");
	
	if (X != "" && X != null)
	{
		form.value = form.value + "[color=" + ColorName + "]" + X + "[/color]";
		document.topic.ColorsList.selectedIndex = 0;
  		form.focus();
 	}
    else
    {
  		document.topic.ColorsList.selectedIndex = 0;
  		form.focus();
    }
}

function Fonts()
{
	var form 		= 	document.topic.text;
	var FontName 	= 	document.topic.FontsList.value;
	
	if (FontName == 0)
	{
		form.focus();
	}
	
	var X = prompt("≈œŒ· «·‰’","");
	
	if (X != "" & X != null)
	{
		form.value = form.value + "[font=" + FontName + "]" + X + "[/font]";
		document.topic.FontsList.selectedIndex = 0;
		form.focus();
	}
	else
	{
		document.topic.FontsList.selectedIndex = 0;
		form.focus();
	}
}

function set_smile(X)
{
	var form = document.topic.text;
	
	form.value = form.value + " " + X + " ";
	form.focus();
}
