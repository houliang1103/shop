function ChunHaiSoft_IeLowVer()
{
	var chuanhai_r=false;
	
	var browser= window.navigator.appName;
	var b_version= window.navigator.appVersion;
	var version=b_version.split(";");
	var trim_Version='';
	if(version && version[1]){trim_Version=version[1].replace(/[ ]/g,""); }
	
	if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE6.0") 
	{ 
		chuanhai_r=true;
	} 
	else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE7.0") 
	{ 
	 	chuanhai_r=true;
	} 
	else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE8.0") 
	{ 
		chuanhai_r=true;
	} 
	else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE9.0") 
	{ 
		chuanhai_r=true;
	}
	
	return chuanhai_r;
}

if(ChunHaiSoft_IeLowVer())
{document.write('<script type="text/javascript" src="http://msg.yunhuatong.com/im2.js"></script>');}
else{document.write('<script type="text/javascript" src="http://msg.yunhuatong.com/im.js"></script>');}