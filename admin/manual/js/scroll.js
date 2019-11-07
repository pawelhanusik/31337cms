function scrollInto(site){
	endAllAnimations(); //from anim.js
	
	let s = document.getElementById(site);
	if(s != null){
		$.mPageScroll2id({
			layout:"auto",
			offset:20
		});
		$.mPageScroll2id("scrollTo", site);
	}else{
		changeSite(site, "homepage"); //from changeSite.js
	}
	
}

function scrollToTop(){
	console.log("Scrolling to top.");
	function tmp(){		
		window.scrollBy(0, -10);
		if(window.scrollY >= 10){
			setTimeout(tmp, 5);
		}
	}
	tmp();
}