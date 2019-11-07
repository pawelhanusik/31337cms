function homepage(){
	changeSite('main', '..');
}
function changeSite(href, type="internal"){
	console.log("Changing site to:", href);
	href = "articles/?type=" + type + "&name=" + href;
	endAllAnimations(); //function from anim.js
	
	//ArrivalOut
	foreachDelay(document.getElementById("content").children, arrivalOut, true); //function from anim.js
	
	scrollToTop(); //function from scroll.js
	let footer = document.getElementById("footer");
	slideFromBottomOut(footer); //function from anim.js
	
	$.ajax({
		url: href,
		success: function(result){
			function tmp(){
				if( document.getElementById("content").childElementCount != 0 ){
					setTimeout(tmp, 10);
				}else{
					let content = document.getElementById("content");
					content.style.visibility = "hidden";
					content.innerHTML = result;
					let divs = content.getElementsByClassName("arrivalable");
					for(let d of divs){
						$(d).css({
							transform: 'translate(-100vw, 0)'
						});
					}
					content.style.visibility = "visible";
					
					arrivalInMultiple(divs); //function from anim.js
					slideFromBottomIn(footer); //function from anim.js
				}
			}
			tmp();
		}
	});
}