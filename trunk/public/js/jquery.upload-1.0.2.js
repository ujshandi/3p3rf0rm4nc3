
<!-- saved from url=(0065)http://lagoscript.org/files/jquery/upload/jquery.upload-1.0.2.min -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"></head><body><pre style="word-wrap: break-word; white-space: pre-wrap;">/*
 * jQuery.upload v1.0.2
 *
 * Copyright (c) 2010 lagos
 * Dual licensed under the MIT and GPL licenses.
 *
 * http://lagoscript.org
 */
(function(b){function m(e){return b.map(n(e),function(d){return'&lt;input type="hidden" name="'+d.name+'" value="'+d.value+'"/&gt;'}).join("")}function n(e){function d(c,f){a.push({name:c,value:f})}if(b.isArray(e))return e;var a=[];if(typeof e==="object")b.each(e,function(c){b.isArray(this)?b.each(this,function(){d(c,this)}):d(c,b.isFunction(this)?this():this)});else typeof e==="string"&amp;&amp;b.each(e.split("&amp;"),function(){var c=b.map(this.split("="),function(f){return decodeURIComponent(f.replace(/\+/g," "))});
d(c[0],c[1])});return a}function o(e,d){var a;a=b(e).contents().get(0);if(b.isXMLDoc(a)||a.XMLDocument)return a.XMLDocument||a;a=b(a).find("body").html();switch(d){case "xml":a=a;if(window.DOMParser)a=(new DOMParser).parseFromString(a,"application/xml");else{var c=new ActiveXObject("Microsoft.XMLDOM");c.async=false;c.loadXML(a);a=c}break;case "json":a=window.eval("("+a+")");break}return a}var p=0;b.fn.upload=function(e,d,a,c){var f=this,g,j,h;h="jquery_upload"+ ++p;var k=b('&lt;iframe name="'+h+'" style="position:absolute;top:-9999px" /&gt;').appendTo("body"),
i='&lt;form target="'+h+'" method="post" enctype="multipart/form-data" /&gt;';if(b.isFunction(d)){c=a;a=d;d={}}j=b("input:checkbox",this);h=b("input:checked",this);i=f.wrapAll(i).parent("form").attr("action",e);j.removeAttr("checked");h.attr("checked",true);g=(g=m(d))?b(g).appendTo(i):null;i.submit(function(){k.load(function(){var l=o(this,c),q=b("input:checked",f);i.after(f).remove();j.removeAttr("checked");q.attr("checked",true);g&amp;&amp;g.remove();setTimeout(function(){k.remove();c==="script"&amp;&amp;b.globalEval(l);
a&amp;&amp;a.call(f,l)},0)})}).submit();return this}})(jQuery);
</pre></body></html>