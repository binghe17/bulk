'use strict';
function tagDrop(tag,callback){
	var css = '.dragenter{border:1px solid #f00 !important;}\n.drop{border:1px solid #00f;background:#ddd !important;}';

	if(callback===null) {
		tag.ondrop=tag.ondragleave=tag.ondragover=tag.ondragenter=null;
		return ;
	}

	var dropCss=document.querySelector('#dropCss');
	if(dropCss===null){
		dropCss = document.createElement('style');
		dropCss.setAttribute('id','dropCss');
		dropCss.textContent = css;
		document.head.appendChild(dropCss);
	}
	
	tag.ondragenter=function(e){
		e.preventDefault();
		tag.classList.add('dragenter');
	}
	tag.ondragover=function(e){
		e.preventDefault();
	}
	tag.ondragleave=function(e){
		e.preventDefault();
		tag.classList.remove('dragenter');
	}
	tag.ondrop=function(e){
		e.preventDefault();
		tag.classList.add('drop');
		var
		files = e.dataTransfer.files,
		len=files.length,
		i=0;
		var file,fr,result=[];
		if(len){
			while(file=files.item(i)) {
				fr = new FileReader();
				fr.file = file;
				fr.readAsText(file);
				fr.onload=function(e){
					var fr = e.target, file=fr.file, i=file.name.lastIndexOf('.')+1;
					file.text = fr.result;
					file.ext = i ? file.name.slice(i) : '';
					result.push(file);
					if(--len ===0) {
						tag.classList.remove('dragenter');
						tag.classList.remove('drop');
						callback(result);
					}
				}
				i++;
			}
		}else{
			callback(result);
		}
	}
}