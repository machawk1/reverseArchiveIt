window.onload = function(){

	var x;

	chrome.tabs.getSelected(null,function(tab){
		var xhr = new XMLHttpRequest();
		//chrome.browserAction.defaultIcon = "loading.gif";
		xhr.open("GET", "http://cs695.matkelly.com/index.php?url="+tab.url, true);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				document.getElementById('loading').style.paddingLeft = "0px";
				document.getElementById('loading').style.backgroundImage = "none";
				document.getElementById('loading').innerHTML = xhr.responseText; //currently returns xml, TODO: make the php result in JSON
				
				//var resp = JSON.parse(xhr.responseText);
				
			}
		};
		xhr.send();

	});
};