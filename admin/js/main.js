
$(document).ready(function(){
	///fade out on init
	let elems = document.getElementsByClassName("onInitFadeOut");
	for(let e of elems){
		$(e).fadeOut(1);
	}
	
	///load color pickers
	jsColorPicker('input.colorpicker', {
		customBG: '#222',
		readOnly: true,
		init: function(elm, colors) {
			elm.style.backgroundColor = elm.value;
			elm.style.color = colors.rgbaMixCustom.luminance > 0.22 ? '#222' : '#ddd';
		},
		noResize: false,
	});
});

function visibilityShowNth(n, elementClass="visibilityNth"){
	let depElems = document.getElementsByClassName(elementClass);
	console.log(n, depElems);
	for(let i = 0; i < depElems.length; ++i){
		if(i === n){
			$(depElems[i]).delay(500).fadeIn(500);
		}else{
			$(depElems[i]).fadeOut(500);
		}
	}
}
function visibilityDependantElementUpdate(visible, elementClass="visibilityDependant"){	
	let depEles = document.getElementsByClassName(elementClass);
	for(let e of depEles){
		if(visible){
			$(e).fadeIn(1000);
		}else{
			$(e).fadeOut(1000);
		}
	}
	let depElesRev = document.getElementsByClassName(elementClass + "Rev");
	for(let e of depElesRev){
		if(visible){
			$(e).fadeOut(1000);
		}else{
			$(e).fadeIn(1000);
		}
	}
}