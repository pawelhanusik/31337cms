$(document).ready(function(){
	///EDITOR
	let elems = document.getElementsByClassName("editor");
	let paths = [];
	for(let e of elems){
		paths.push(e.innerHTML);
		e.innerHTML = "";
		
		let editorTextarea = document.createElement("textarea");
		editorTextarea.name = "editor";
		editorTextarea.classList.add('editorTinyMCE', 'editorCodeMirror');
		
		let editorChangerDiv = document.createElement("div");
		editorChangerDiv.className = "right";
		
		var tinyBtn = document.createElement("input");
		var codemirrorBtn = document.createElement("input");
		tinyBtn.type = "button";
		codemirrorBtn.type = "button";
		tinyBtn.style.width = "auto";
		codemirrorBtn.style.width = "auto";
		tinyBtn.value = "TinyMCE";
		codemirrorBtn.value = "CodeMirror";
		tinyBtn.disabled = true;
		codemirrorBtn.disabled = false;
		
		tinyBtn.onclick = function(){
			tinyBtn.disabled = true;
			codemirrorBtn.disabled = false;
			
			let codeMirrorEditor = document.getElementsByClassName("CodeMirror")[0].CodeMirror;
			codeMirrorEditor.toTextArea();
			
			tinymce.init({
				selector:'.editorTinyMCE',
				height: 400
			});
			
		};
		codemirrorBtn.onclick = function(){
			tinyBtn.disabled = false;
			codemirrorBtn.disabled = true;
			
			tinymce.activeEditor.remove();
			
			CodeMirror.fromTextArea(document.getElementsByClassName("editorCodeMirror")[0], {
				lineNumbers: true
			});
		};
		
		
		editorChangerDiv.appendChild(tinyBtn);
		editorChangerDiv.appendChild(codemirrorBtn);
		
		e.appendChild(editorTextarea);
		e.appendChild(editorChangerDiv);
	}
	
	var editorID = 0;
	tinymce.init({
		selector: '.editorTinyMCE',
		height: 400,
		init_instance_callback : function(editor) {
			console.log(editorID);
			if(paths[editorID] != undefined && paths[editorID] != ""){
				console.log("Article URL:", paths[editorID]);
				$.ajax({
					url: paths[editorID],
					success: function(source) {
						let c = source.substr(source.indexOf(">")+1, source.lastIndexOf("</div>"));
						editor.setContent(c);
					}
				});
			}
			editorID++;
		}
	});
});

