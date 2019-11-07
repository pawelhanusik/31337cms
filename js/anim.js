var divs = [];
var arrivalAnimatedDivs = 0;
var showedPixels = 0;
var pixelsSoFar = 0;
var maxX = 100;
var maxAngle = -40;
var outX = -100;
var outAngle = -40;
if(isMobile()){
	maxX = -100;
	maxAngle = 40;
}

function endAllAnimations()
{
	//end arrival animation
	arrivalAnimatedDivs = divs.length;
	for(let div of divs){
		$(div).css({
			transform: 'rotate(0deg)translate(0vw,0px)'
		});
	}
}

$(document).ready( function(){
	divs = document.getElementsByClassName("arrivalable");
	
	
	for(let div of divs){
		$(div).css({
			transform: 'translate(' + -100 + 'vw,' + 0 + 'px)'
		});
	}
	
	window.onscroll = animateArrival;
	animateArrival();
});

function animateArrival(){
	let scrollPos = window.scrollY;
	let delay = 0;
	
	for(let id = arrivalAnimatedDivs; id < divs.length; ++id){		
		if(pixelsSoFar > $(window).height() + scrollPos){
			break;
		}
		if(divs[id].clientHeight != 0){
			pixelsSoFar += divs[id].offsetHeight;
		}else{
			let imgs = divs[id].getElementsByTagName("img");
			if(imgs.length > 0){
				pixelsSoFar += imgs[0].height;
			}else{
				pixelsSoFar += divs[id].children[0].offsetHeight;
			}
		}
		
		
		setTimeout(function(){
			arrivalIn(divs[id]);
		}, delay);
		
		arrivalAnimatedDivs++;
		showedPixels += divs[id].offsetHeight;
		delay += 390;
	}
	
};

///===============================================================================================
function foreachDelay(divs, func, reverse=false, delay=390){
	if(!reverse){
		for(let id = 0; id < divs.length; ++id){
			setTimeout(function(){
				func(divs[id]);
			}, delay*id);
		}
	}else{
		for(let id = divs.length-1; id >= 0; --id){
			setTimeout(function(){
				func(divs[id]);
			}, delay*(divs.length-1-id));
		}
	}
}
//===============================

function arrivalInMultiple(divs){
	for(let id = 0; id < divs.length; ++id){
		setTimeout(function(){
			arrivalIn(divs[id]);
		}, 390*id);
	}
}
function arrivalIn(div){
	let divOrigHeight = div.clientHeight;
	if(divOrigHeight > 500){
		div.style.overflow = "hidden";
		div.style.height = '500px';
		let diff = div.clientHeight - 500;
		$({h: 500}).delay(1000).animate({h: divOrigHeight-diff}, {
			duration: 3 * (divOrigHeight - 500),
			step: function(now) {
				div.style.height = now + 'px';
			}
		});
	}
	
	$({b: 10}).animate({b: 0}, {
		duration: 750,
		step: function(now) {
			$(div).css({
				filter: 'blur(' + now + 'px)'
			});
		}
	});
	
	var tx = ty = tr = 0;
	$({x: maxX, y: 0, r: maxAngle}).animate({x: 0, y: 0, r: 0}, {
		duration: 1000,
		step: function(now, fx){
			if (fx.prop == "x")
				tx = now;
			else if (fx.prop == "y")
				ty = now;
			else if (fx.prop == "r")
				tr = now;
			
			$(div).css({
				transform: 'rotate(' + tr + 'deg)' + 'translate(' + tx + 'vw,' + ty + 'px)'
			});
		}
	});
}
function arrivalOut(div){
	var tx = ty = tr = 0;
	$({b: 0}).animate({b: 10}, {
		duration: 750,
		step: function(now) {
			$(div).css({
				filter: 'blur(' + now + 'px)'
			});
		}
	});
	
	$({x: 0, y: 0, r: 0}).animate({x: outX, y: 0, r: outAngle}, {
		duration: 1000,
		step: function(now, fx){
			if (fx.prop == "x")
				tx = now;
			else if (fx.prop == "y")
				ty = now;
			else if (fx.prop == "r")
				tr = now;
			
			$(div).css({
				transform: 'rotate(' + tr + 'deg)' + 'translate(' + tx + 'vw,' + ty + 'px)'
			});
		}
	});
	
	$(div).fadeOut(1000, ()=> {$(div).remove();} );
}

//==========SLIDE FROM BOTTOM====================
function slideFromBottomIn(div){
	$({y: 100}).animate({y: 0}, {
		duration: 2000,
		step: function(now){
			$(div).css({
				transform: 'translate(0, ' + now + 'vh)'
			});
		}
	});
}
function slideFromBottomOut(div){
	$({y: 0}).animate({y: 100}, {
		duration: 1000,
		step: function(now){
			$(div).css({
				transform: 'translate(0, ' + now + 'vh)'
			});
		}
	});
}