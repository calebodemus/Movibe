jQuery.fn.clockpick=function(options,callback){function errorcheck(){if(settings.starthour>=settings.endhour){alert("Error - start hour must be less than end hour.");return false}else if(60%settings.minutedivisions!=0){alert("Error - param minutedivisions must divide evenly into 60.");return false}}var settings={starthour:8,endhour:18,showminutes:true,minutedivisions:4,military:false,event:"click",layout:"vertical",valuefield:null,hoursopacity:1,minutesopacity:1};if(options){jQuery.extend(settings,options)}var callback=callback||function(){},v=settings.layout=="vertical";errorcheck();jQuery(this)[settings.event](function(e){function renderhours(){var e=1;for(var t=settings.starthour;t<=settings.endhour;t++){if(t==12){e=1}var n=!settings.military&&t>12?t-12:t;if(!settings.military&&t==0){n="12"}if(settings.military&&t<10){n="0"+n}if(settings.military){n+=":00"}var r=jQuery("<div class='CP_hour' id='hr_"+t+"_"+e+"'>"+n+set_tt(t)+"</div>");binder(r);if(!v){r.css("float","left")}t<12?$hourcol1.append(r):$hourcol2.append(r);e++}$hourcont.append($hourcol1);!v?$hourcont.append("<div style='clear:left' />"):"";$hourcont.append($hourcol2)}function renderminutes(e){var t=e;var n=!settings.military&&e>12?e-12:e;if(!settings.military&&e==0){n="12"}if(settings.military&&e<10){n="0"+n}$mc.empty();var r=60/settings.minutedivisions,i=set_tt(t),s=1;for(var o=0;o<60;o=o+r){$md=jQuery("<div class='CP_minute' id='"+t+"_"+o+"'>"+n+":"+(o<10?"0":"")+o+i+"</div>");if(!v){$md.css("float","left");if(settings.minutedivisions>6&&s==settings.minutedivisions/2+1){$mc.append("<div style='clear:left' />")}}$mc.append($md);binder($md);s++}}function set_tt(e){if(!settings.military){return e>=12?" PM":" AM"}else{return""}}function putcontainer(){if(e.type!="focus"){$hourcont[0].style.left=e.pageX-5+"px";$hourcont[0].style.top=e.pageY-Math.floor($hourcont.height()/2)+"px";rectify($hourcont)}else{$self.after($hourcont)}$hourcont.slideDown("fast")}function rectify(e){var t=document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight;var n=document.documentElement.clientWidth?document.documentElement.clientWidth:document.body.clientWidth;var r=parseInt(e[0].style.top);var i=parseInt(e[0].style.left);var s=document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop;if(r<=s&&!e.is("#CP_minutecont")){e.css("top",s+10+"px")}else if(r+e.height()-s>t){e.css("top",s+t-e.height()-10+"px")}if(i<=0){e.css("left","10px")}}function binder(e){if(e.attr("id")=="CP_hourcont"){e.mouseout(function(e){hourcont_out(e)})}else if(e.attr("id")=="CP_minutecont"){e.mouseout(function(e){minutecont_out(e)})}else if(e.attr("class")=="CP_hour"){e.mouseover(function(t){hourdiv_over(e,t)});e.mouseout(function(){hourdiv_out(e)});e.click(function(){hourdiv_click(e)})}else if(e.attr("class")=="CP_minute"){e.mouseover(function(){minutediv_over(e)});e.mouseout(function(){minutediv_out(e)});e.click(function(){minutediv_click(e)})}}function hourcont_out(e){try{var t=e.toElement?e.toElement:e.relatedTarget;if(!jQuery(t).is("div[class^=CP], iframe")){cleardivs()}}catch(e){cleardivs()}}function minutecont_out(e){try{var t=e.toElement?e.toElement:e.relatedTarget;if(!jQuery(t).is("div[class^=CP], iframe")){cleardivs()}}catch(e){cleardivs()}}function hourdiv_over(e,t){var n=e.attr("id").split("_")[1],r=e.attr("id").split("_")[2],i,s;e.addClass("CP_over");if(settings.showminutes){$mc.hide();renderminutes(n);if(v){s=t.type=="mouseover"?t.pageY-15:$hourcont.offset().top+2+e.height()*r;if(n<12)i=$hourcont.offset().left-$mc.width()-2;else i=$hourcont.offset().left+$hourcont.width()+2}else{i=t.type=="mouseover"?t.pageX-10:$hourcont.offset().left+(e.width()-5)*r;if(n<12){s=$hourcont.offset().top-$mc.height()-2}else{s=$hourcont.offset().top+$hourcont.height()}}$mc.css("left",i+"px").css("top",s+"px");rectify($mc);$mc.show()}return false}function hourdiv_out(e){e.removeClass("CP_over");return false}function hourdiv_click(e){var t=e.attr("id").split("_")[1],n=set_tt(t),r=e.text();if(r.indexOf(" ")!=-1){var i=r.substring(0,r.indexOf(" "))}else{var i=r}e.text(i+":00"+n);setval(e);cleardivs()}function minutediv_over(e){e.addClass("CP_over");return false}function minutediv_out(e){e.removeClass("CP_over");return false}function minutediv_click(e){setval(e);cleardivs()}function setval(e){if(!settings.valuefield){self.value=e.text()}else{jQuery("input[name="+settings.valuefield+"]").val(e.text())}callback.apply($self,[e.text()]);$self.unbind("keydown",keyhandler)}function cleardivs(){if(settings.showminutes){$mc.hide()}$hourcont.slideUp("fast");$self.unbind("keydown",keyhandler)}function keyhandler(e){function divprev($obj){if($obj.prev().size()){eval(divtype+"div_out($obj)");eval(divtype+"div_over($obj.prev(), e)")}else{return false}}function divnext($obj){if($obj.next().size()){eval(divtype+"div_out($obj)");eval(divtype+"div_over($obj.next(), e)")}else{return false}}function hourtohour(t){var n=h>=12?"#hourcol1":"#hourcol2";$newobj=jQuery(".CP_hour[id$=_"+hi+"]",n);if($newobj.size()){hourdiv_out(t);hourdiv_over($newobj,e)}else{return false}}function hourtominute(e){hourdiv_out(e);minutediv_over($(".CP_minute:first"))}function minutetohour(t){minutediv_out(t);var n=h>=12?"#hourcol2":"#hourcol1";var r=jQuery(".CP_hour[id^=hr_"+h+"]",n);hourdiv_over(r,e)}var $obj=$("div.CP_over").size()?$("div.CP_over"):$("div.CP_hour:first"),divtype=$obj.is(".CP_hour")?"hour":"minute",hi=divtype=="hour"?$obj[0].id.split("_")[2]:0,h=divtype=="minute"?$obj[0].id.split("_")[0]:$obj[0].id.split("_")[1];if(divtype=="minute"){var curloc=h<12?"m1":"m2"}else{var curloc=h<12?"h1":"h2"}switch(e.keyCode){case 37:if(v){switch(curloc){case"m1":return false;break;case"m2":minutetohour($obj);break;case"h1":hourtominute($obj);break;case"h2":hourtohour($obj);break}}else{divprev($obj)}break;case 38:if(v){divprev($obj)}else{switch(curloc){case"m1":return false;break;case"m2":minutetohour($obj);break;case"h1":hourtominute($obj);break;case"h2":hourtohour($obj);break}}break;case 39:if(v){switch(curloc){case"m1":minutetohour($obj);break;case"m2":return false;break;case"h1":hourtohour($obj);break;case"h2":hourtominute($obj);break}}else{divnext($obj)}break;case 40:if(v){divnext($obj)}else{switch(curloc){case"m1":minutetohour($obj);break;case"m2":return false;break;case"h1":hourtohour($obj);break;case"h2":hourtominute($obj);break}}break;case 13:eval(divtype+"div_click($obj)");break;default:return true}return false}var self=this,$self=jQuery(this),$body=jQuery("body");if(!settings.valuefield){$self.unbind("keydown").bind("keydown",keyhandler)}else{var inputfield=jQuery("[name="+settings.valuefield+"]");inputfield.unbind("keydown").bind("keydown",keyhandler)[0].focus();inputfield.bind("click",function(){inputfield.unbind("keydown")})}jQuery("#CP_hourcont,#CP_minutecont").remove();var $hourcont=jQuery("<div id='CP_hourcont' class='CP' />").appendTo($body);$hourcont.css("opacity",settings.hoursopacity);binder($hourcont);var $hourcol1=jQuery("<div class='CP_hourcol' id='hourcol1' />").appendTo($body);var $hourcol2=jQuery("<div class='CP_hourcol' id='hourcol2' />").appendTo($body);if(settings.showminutes){var $mc=jQuery("<div id='CP_minutecont' class='CP' />").appendTo($body);$mc.css("opacity",settings.minutesopacity);binder($mc)}if(!v){$hourcont.css("width","auto");if(settings.showminutes){$mc.css("width","auto")}}else{$hourcol1.addClass("floatleft");$hourcol2.addClass("floatleft")}renderhours();putcontainer();return false});return this}