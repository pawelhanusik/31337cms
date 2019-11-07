$(document).ready(
	function() {
		var headerDiv = document.getElementById("header");
		
		if(headerDiv.classList.contains("slides")){	
			var headerImg = headerDiv.getElementsByTagName("img")[0];
			var headerFade = headerDiv.getElementsByClassName("fade")[0];
			var headerImgID = 0;
			var headerImgAnimSquareSize = 16;
			var headerImgCanvasesCount = 20;
			
			setInterval(function(){
				let canvases = [];
				for(let i = 0; i < headerImgCanvasesCount; ++i){
					canvases[i] = document.createElement('canvas');
					canvases[i].width  = headerImg.width;
					canvases[i].height = headerImg.height;
					headerFade.appendChild(canvases[i]);
				}
				
				let scaleFactorW = headerImg.width / headerImg.naturalWidth;
				let scaleFactorH = headerImg.height / headerImg.naturalHeight;
				for(let y = 0; y < headerImg.height; y += headerImgAnimSquareSize){
					for(let x = 0; x < headerImg.width; x += headerImgAnimSquareSize){
						let canvasID = parseInt(Math.random() * headerImgCanvasesCount);
						let newCtx = canvases[canvasID].getContext("2d");
						newCtx.drawImage(headerImg, x/scaleFactorW, y/scaleFactorH, headerImgAnimSquareSize/scaleFactorW, headerImgAnimSquareSize/scaleFactorH, x, y, headerImgAnimSquareSize, headerImgAnimSquareSize);
					}
				}
				
				if(++headerImgID >= 4) headerImgID = 0;
				headerImg.classList.add("hidden");
				headerImg = headerDiv.getElementsByTagName("img")[headerImgID];
				headerImg.classList.remove("hidden");
				
				//animate squares
				$(canvases).each(function(id){
					$(this).delay(50*id).fadeOut(200+50*id, "swing", ()=>{ $(this).remove(); } );
				});
				
				
				
			}, 5000);
		}
	}
);