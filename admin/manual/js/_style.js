function apply(){
	var h = document.getElementById('header');
	var m = document.getElementById('menu');
	
	h.style.height = h.getElementsByTagName("img")[0].height + "px";
}

$(document).ready(function(){
	function tmp(){
		if(document.getElementById('header').style.height != document.getElementById('header').getElementsByTagName("img")[0].height + "px"){
			apply();
			setTimeout(tmp, 50);
		}
	}
	tmp();
	setTimeout(function(){
		if(document.getElementById('header').style.height != document.getElementById('header').getElementsByTagName("img")[0].height + "px"){
			apply();
		}
	}, 500);
	
	changeStyleForMobile();
});
window.onresize = apply;


function changeStyleForMobile(){
	if(isMobile()){
		document.body.style.width = "100%";
	}
}
