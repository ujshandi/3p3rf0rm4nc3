// JavaScript Document

function adjustHeight(obj, offset){
	try {
		var doc = window.frames[obj.name].document;
		if (navigator.userAgent.indexOf("IE")) { 
			var the_height=obj.contentWindow.document.body.scrollHeight; 
			obj.height = the_height + offset; 
			obj.style.height = obj.height;
		} else { 
			obj.style.height = (doc.body.offsetHeight+offset)+'px'; 
		}
		doc.body.style.borderWidth = '0px'; 
	}
	catch (err) {
		alert(err.description );
		obj.style.height = "100px";
	}
}
