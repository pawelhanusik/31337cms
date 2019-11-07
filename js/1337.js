$(document).ready(function(){
	
	if(document.body.classList.contains("1337")){
		function convert2leet(){
			console.log("1337");
			function str2leet(str){
				str = str.replace("l", "1");
				str = str.replace("e", "3");
				str = str.replace("a", "4");
				str = str.replace("s", "5");
				str = str.replace("g", "6");
				str = str.replace("t", "7");
				str = str.replace("b", "8");
				return str;
			}
			
			function tmp(ele){
				if(ele.childElementCount == 0){
					ele.innerHTML = str2leet(ele.innerHTML);
				}else{
					for(let e of ele.children){
						tmp(e);
					}
				}
			}
			
			let divs = document.getElementsByTagName("div");
			for(let div of divs){
				tmp(div);
			}
		}
		
		convert2leet();
		setInterval(convert2leet, 1000);
	}
});