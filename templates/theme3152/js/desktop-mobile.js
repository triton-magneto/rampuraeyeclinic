//To desktop Version script

//create cookie
function createCookie(name,value,days)
{
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

//read cookie
function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

//erase cookie
function eraseCookie(name)
{
	createCookie(name,"",-1);
}

//main function
function toDeskTop(){
	var isMobile = navigator.userAgent.match(/(iPhone)|(iPod)|(android)|(Windows Phone)|(BlackBerry)|(iemobile)|(symbian)|(BB10)|(PlayBook)|(webOS)/i)
	if(isMobile){
		if(jQuery('#to-desktop').length){
			jQuery('#to-desktop a').click(function(e){
				disableMobile = readCookie('disableMobile');
				if(disableMobile&&disableMobile!='false'){
					createCookie('disableMobile', false, 365);
					eraseCookie('screenWidth');
				}
				else{
					createCookie('disableMobile', true, 365);
					createCookie('screenWidth', window.screen.width, 365);
				}
				window.location.href = 'index.php'
				return false;
			});
		}
		else{
			eraseCookie('disableMobile');
			eraseCookie('screenWidth');
		}
	}
}

jQuery(document).ready(function(){
	toDeskTop();
});