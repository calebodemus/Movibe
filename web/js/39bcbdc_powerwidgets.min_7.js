/* ______________________________________
________| |_______
\ | PowerWidget | /
\ | Copyright © 2014 MyOrange | /
/ |______________________________________| \
/__________) (_________\
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
* =======================================================================
* PowerWidget is FULLY owned and LICENSED by MYORANGE INC.
* This script may NOT be RESOLD or REDISTRUBUTED under any
* circumstances.
* =======================================================================
* author: Sunny (@bootstraphunt)
* email: info@myorange.ca
*/


(function(e,t,n,r){function s(t,n){this.obj=e(t);this.o=e.extend({},e.fn[i].defaults,n);this.objId=this.obj.attr("id");this.pwCtrls=".powerwidget-ctrls";this.widget=this.obj.find(this.o.widgets);this.toggleClass=this.o.toggleClass.split("|");this.editClass=this.o.editClass.split("|");this.fullscreenClass=this.o.fullscreenClass.split("|");this.init()}var i="powerWidgets";s.prototype={_settings:function(){var e=this;storage=!!function(){var e,t=+(new Date);try{localStorage.setItem(t,t);e=localStorage.getItem(t)==t;localStorage.removeItem(t);return e}catch(n){}}()&&localStorage;if(storage&&e.o.localStorage){keySettings="powerwidgets_settings_"+location.pathname+"_"+e.objId;getKeySettings=localStorage.getItem(keySettings);keyPosition="powerwidgets_position_"+location.pathname+"_"+e.objId;getKeyPosition=localStorage.getItem(keyPosition)}if("ontouchstart"in t||t.DocumentTouch&&n instanceof DocumentTouch){clickEvent="touchstart"}else{clickEvent="click"}},_runLoaderWidget:function(e){var t=this;if(t.o.indicator===true){e.parents(t.o.widgets).find(".powerwidget-loader").stop(true,true).fadeIn(100).delay(t.o.indicatorTime).fadeOut(100)}},_getPastTimestamp:function(e){var t=this;var n=new Date(e);r=n.getMonth()+1;i=n.getDate();tsYear=n.getFullYear();s=n.getHours();o=n.getMinutes();u=n.getUTCSeconds();if(r<10){var r="0"+r}if(i<10){var i="0"+i}if(s<10){var s="0"+s}if(o<10){var o="0"+o}if(u<10){var u="0"+u}var a=t.o.timestampFormat.replace(/%d%/g,i).replace(/%m%/g,r).replace(/%y%/g,tsYear).replace(/%h%/g,s).replace(/%i%/g,o).replace(/%s%/g,u);return a},_loadAjaxFile:function(t,n,r){var i=this;t.find(".powerwidget-ajax-placeholder").load(n,function(n,r,s){if(r=="error"){e(this).html('<div class="inner-spacer">'+i.o.labelError+"<b>"+s.status+" "+s.statusText+"</b></div>")}if(r=="success"){var o=t.find(i.o.timestampPlaceholder);if(o.length){o.html(i._getPastTimestamp(new Date))}if(typeof i.o.afterLoad=="function"){i.o.afterLoad.call(this,t)}}});i._runLoaderWidget(r)},_saveSettingsWidget:function(){var t=this;t._settings();if(storage&&t.o.localStorage){var n=[];t.obj.find(t.o.widgets).each(function(){var t={};t["id"]=e(this).attr("id");t["style"]=e(this).attr("data-widget-attstyle");t["title"]=e(this).children("header").children("h2").text();t["hidden"]=e(this).is(":hidden")?1:0;t["collapsed"]=e(this).hasClass("powerwidget-collapsed")?1:0;n.push(t)});var r=JSON.stringify({widget:n});if(getKeySettings!=r){localStorage.setItem(keySettings,r)}}if(typeof t.o.onSave=="function"){t.o.onSave.call(this,null,r)}},_savePositionWidget:function(){var t=this;t._settings();if(storage&&t.o.localStorage){var n=[];t.obj.find(t.o.grid+".sortable-grid").each(function(){var r=[];e(this).children(t.o.widgets).each(function(){var t={};t["id"]=e(this).attr("id");r.push(t)});var i={section:r};n.push(i)});var r=JSON.stringify({grid:n});if(getKeyPosition!=r){localStorage.setItem(keyPosition,r,null)}}if(typeof t.o.onSave=="function"){t.o.onSave.call(this,r)}},init:function(){var t=this;t._settings();if(!e("#"+t.objId).length){alert("It looks like your using a class instead of an ID, dont do that!")}if(t.o.rtl===true){e("body").addClass("rtl")}e(t.o.grid).each(function(){if(e(this).find(t.o.widgets).length){e(this).addClass("sortable-grid")}});if(storage&&t.o.localStorage&&getKeyPosition){var n=JSON.parse(getKeyPosition);for(var r in n.grid){var i=t.obj.find(t.o.grid+".sortable-grid").eq(r);for(var s in n.grid[r].section){i.append(e("#"+n.grid[r].section[s].id))}}}if(storage&&t.o.localStorage&&getKeySettings){var o=JSON.parse(getKeySettings);for(var r in o.widget){var u=e("#"+o.widget[r].id);if(o.widget[r].style){u.addClass(o.widget[r].style).attr("data-widget-attstyle",""+o.widget[r].style+"")}if(o.widget[r].hidden==1){u.hide(1)}else{u.show(1).removeAttr("data-widget-hidden")}if(o.widget[r].collapsed==1){u.addClass("powerwidget-collapsed").children("div").hide(1)}if(u.children("header").children("h2").text()!=o.widget[r].title){u.children("header").children("h2").text(o.widget[r].title)}}}t._build(false);t._ajax(false);t._sortable();if(t.o.buttonsHidden===true){t.widget.children("header").hover(function(){e(this).children(t.o.pwCtrls).stop(true,true).fadeTo(100,1)},function(){e(this).children(t.o.pwCtrls).stop(true,true).fadeTo(100,0)})}t._clickEvents();e(t.o.deleteSettingsKey).on(clickEvent,this,function(n){if(t.o.confirmReplacer&&typeof e.fn.modal==="function"){var r=e(t.o.confirmReplacer);e("#bootconfirm_confirm",r).off(clickEvent).on(clickEvent,function(e){localStorage.removeItem(keySettings);r.modal("hide")});e(".modal-title",r).text(t.o.settingsKeyLabel);r.modal()}else{if(storage&&t.o.localStorage){var i=confirm(t.o.settingsKeyLabel);if(i){localStorage.removeItem(keySettings)}}}n.preventDefault()});e(t.o.deletePositionKey).on(clickEvent,this,function(n){if(t.o.confirmReplacer&&typeof e.fn.modal==="function"){var r=e(t.o.confirmReplacer);e("#bootconfirm_confirm",r).off(clickEvent).on(clickEvent,function(e){localStorage.removeItem(keyPosition);r.modal("hide")});e(".modal-title",r).text(t.o.positionKeyLabel);r.modal()}else{if(storage&&t.o.localStorage){var i=confirm(t.o.positionKeyLabel);if(i){localStorage.removeItem(keyPosition)}}}n.preventDefault()});if(storage&&t.o.localStorage){if(getKeySettings===null||getKeySettings.length<1){t._saveSettingsWidget()}if(getKeyPosition===null||getKeyPosition.length<1){t._savePositionWidget()}}},_sortable:function(e){var t=this;if(t.o.sortable===true&&jQuery.ui){var n=t.obj.find(".sortable-grid").not("[data-widget-excludegrid]");n.sortable({items:n.find(".powerwidget-sortable"),connectWith:n,placeholder:t.o.placeholderClass,cursor:"move",revert:true,opacity:t.o.opacity,delay:200,cancel:".button-icon, #powerwidget-fullscreen-mode > div",zIndex:1e4,handle:t.o.dragHandle,forcePlaceholderSize:true,forceHelperSize:true,containment:".content-wrapper",update:function(e,n){t._runLoaderWidget(n.item.children());t._savePositionWidget();if(typeof t.o.onChange=="function"){t.o.onChange.call(this,n.item)}}})}},_clickEvents:function(n){function i(){if(e("#powerwidget-fullscreen-mode").length){var n=e(t).height();var i=e("#powerwidget-fullscreen-mode").find(r.o.widgets).children("header").height();e("#powerwidget-fullscreen-mode").find(r.o.widgets).children("div").height(n-i-3)}}var r=this;r._settings();r.obj.on(clickEvent,".powerwidget-toggle-btn",function(t){var n=e(this);var i=n.parents(r.o.widgets);r._runLoaderWidget(n);if(i.hasClass("powerwidget-collapsed")){n.children().removeClass(r.toggleClass[1]).addClass(r.toggleClass[0]).parents(r.o.widgets).removeClass("powerwidget-collapsed").children("[role=content]").slideDown(r.o.toggleSpeed,function(){r._saveSettingsWidget()})}else{n.children().removeClass(r.toggleClass[0]).addClass(r.toggleClass[1]).parents(r.o.widgets).addClass("powerwidget-collapsed").children("[role=content]").slideUp(r.o.toggleSpeed,function(){r._saveSettingsWidget()})}if(typeof r.o.onToggle=="function"){r.o.onToggle.call(this,i)}t.preventDefault()});r.obj.on(clickEvent,".powerwidget-fullscreen-btn",function(t){var n=e(this).parents(r.o.widgets);var s=n.children("div");r._runLoaderWidget(e(this));if(e("#powerwidget-fullscreen-mode").length){e(".nooverflow").removeClass("nooverflow");n.unwrap("<div>").children("div").removeAttr("style").end().find(".powerwidget-fullscreen-btn").children().removeClass(r.fullscreenClass[1]).addClass(r.fullscreenClass[0]).parents(r.pwCtrls).children("a").show();if(s.hasClass("powerwidget-visible")){s.hide().removeClass("powerwidget-visible")}}else{e("body").addClass("nooverflow");n.wrap('<div id="powerwidget-fullscreen-mode"/>').parent().find(".powerwidget-fullscreen-btn").children().removeClass(r.fullscreenClass[0]).addClass(r.fullscreenClass[1]).parents(r.pwCtrls).children("a:not(.powerwidget-fullscreen-btn)").hide();if(s.is(":hidden")){s.show().addClass("powerwidget-visible")}}i();if(typeof r.o.onFullscreen=="function"){r.o.onFullscreen.call(this,n)}t.preventDefault()});e(t).resize(function(){i()});r.obj.on(clickEvent,".powerwidget-edit-btn",function(t){var n=e(this).parents(r.o.widgets);r._runLoaderWidget(e(this));if(n.find(r.o.editPlaceholder).is(":visible")){e(this).children().removeClass(r.editClass[1]).addClass(r.editClass[0]).parents(r.o.widgets).find(r.o.editPlaceholder).slideUp(r.o.editSpeed,function(){r._saveSettingsWidget()})}else{e(this).children().removeClass(r.editClass[0]).addClass(r.editClass[1]).parents(r.o.widgets).find(r.o.editPlaceholder).slideDown(r.o.editSpeed)}if(typeof r.o.onEdit=="function"){r.o.onEdit.call(this,n)}t.preventDefault()});e(r.o.editPlaceholder).find("input").keyup(function(){e(this).parents(r.o.widgets).children("header").children("h2").text(e(this).val())});r.obj.on(clickEvent,"[data-widget-setstyle]",function(t){var n=e(this).data("widget-setstyle");var i="";e(this).parents(r.o.editPlaceholder).find("[data-widget-setstyle]").each(function(){i+=e(this).data("widget-setstyle")+" "});e(this).parents(r.o.widgets).attr("data-widget-attstyle",""+n+"").removeClass(i).addClass(n);r._runLoaderWidget(e(this));r._saveSettingsWidget();t.preventDefault()});r.obj.on(clickEvent,".powerwidget-delete-btn",function(t){if(typeof r.o.onDelete=="function"){r.o.onDelete.call(this,"#"+e(this).parents(r.o.widgets).attr("id"))}t.preventDefault()});r.obj.on(clickEvent,".powerwidget-refresh-btn",function(t){var n=e(this).parents(r.o.widgets);var i=n.data("widget-load");var s=n.children();r._loadAjaxFile(n,i,s);t.preventDefault()})},_build:function(t){var n=this;if(t===false){var i=n.widget}else if(t===r){var i=e(".powerwidget")}else{var i=t}i.each(function(){var t=e(this);var i=e(this).children("header");if(!i.parent().attr("role")){if(t.data("widget-hidden")===true){t.hide()}if(t.data("widget-collapsed")===true){t.addClass("powerwidget-collapsed").children("div").hide()}if(t.data("widget-icon")){i.prepend('<i class="powerwidget-icon '+t.data("widget-icon")+'"></i>')}if(n.o.deleteButton===true&&t.data("widget-deletebutton")===r){var s='<a href="#" class="button-icon powerwidget-delete-btn"><i class="'+n.o.deleteClass+'"></i></a>'}else{s=""}if(n.o.editButton===true&&t.data("widget-editbutton")===r){var o='<a href="#" class="button-icon powerwidget-edit-btn"><i class="'+n.editClass[0]+'"></i></a>'}else{o=""}if(n.o.fullscreenButton===true&&t.data("widget-fullscreenbutton")===r){var u='<a href="#" class="button-icon powerwidget-fullscreen-btn"><i class="'+n.fullscreenClass[0]+'"></i></a>'}else{u=""}if(n.o.toggleButton===true&&t.data("widget-togglebutton")===r){if(t.data("widget-collapsed")===true||t.hasClass("powerwidget-collapsed")){var a=n.toggleClass[1]}else{a=n.toggleClass[0]}var f='<a href="#" class="button-icon powerwidget-toggle-btn"><i class="'+a+'"></i></a>'}else{f=""}if(n.o.refreshButton===true&&t.data("widget-refreshbutton")!=false&&t.data("widget-load")){var l='<a href="#" class="button-icon powerwidget-refresh-btn"><i class="'+n.o.refreshButtonClass+'"></i></a>'}else{l=""}var c=n.o.buttonOrder.replace(/%refresh%/g,l).replace(/%delete%/g,s).replace(/%fullscreen%/g,u).replace(/%edit%/g,o).replace(/%toggle%/g,f);if(l!=""||s!=""||u!=""||o!=""||f!=""){i.append('<div class="powerwidget-ctrls">'+c+"</div>")}if(n.o.sortable===true&&t.data("widget-sortable")===r){t.addClass("powerwidget-sortable")}if(t.find(n.o.editPlaceholder).length){t.find(n.o.editPlaceholder).find("input").val(i.children("h2").text())}i.append('<span class="powerwidget-loader"></span>');t.attr("role","widget").children("div").attr("role","content").prev("header").attr("role","heading").children("div").attr("role","menu")}});if(n.o.buttonsHidden===true){e(n.o.pwCtrls).hide()}},_ajax:function(t){var n=this;if(t===false){var i=n.obj}else if(t===r){var i=e("body")}else{var i=t}i.find("[data-widget-load]").each(function(){var t=e(this);var r=t.children();var i=t.data("widget-load");var s=t.data("widget-refresh")*1e3;var o=t.children();if(!t.find(".powerwidget-ajax-placeholder").length){t.children("div:first").append('<div class="powerwidget-ajax-placeholder"><span style="margin:10px">'+n.o.loadingLabel+"</span></div>");if(t.data("widget-refresh")>0){n._loadAjaxFile(t,i,r);setInterval(function(){n._loadAjaxFile(t,i,r)},s)}else{n._loadAjaxFile(t,i,r)}}})},update:function(e){var t=this;if(e===r){var n=r}else{var n=e}t._build(n);t._ajax(n);t._sortable();t._clickEvents()},destroy:function(){}};e.fn[i]=function(t,n){return this.each(function(){var r=e(this);var o=r.data(i);var u=typeof t=="object"&&t;if(!o){r.data(i,o=new s(this,u))}if(typeof t=="string"){o[t](n)}})};e.fn[i].defaults={grid:".bootstrap-grid",widgets:".powerwidget",localStorage:true,deleteSettingsKey:"#deletesettingskey-options",settingsKeyLabel:"Reset settings?",deletePositionKey:"#deletepositionkey-options",positionKeyLabel:"Reset position?",sortable:true,buttonsHidden:false,toggleButton:true,toggleClass:"fa fa-chevron-circle-up | fa fa-chevron-circle-down",toggleSpeed:200,onToggle:function(){},deleteButton:true,deleteClass:"fa fa-times-circle",onDelete:function(t){e("#delete-widget").modal();e(t).addClass("deletethiswidget")},editButton:true,editPlaceholder:".powerwidget-editbox",editClass:"fa fa-cog | fa fa-cog",editSpeed:200,onEdit:function(){},fullscreenButton:true,fullscreenClass:"fa fa-arrows-alt | fa fa-arrows-alt",fullscreenDiff:3,onFullscreen:function(){},buttonOrder:"%refresh% %delete% %edit% %fullscreen% %toggle%",opacity:1,dragHandle:"> header",placeholderClass:"powerwidget-placeholder",indicator:true,indicatorTime:600,ajax:true,timestampPlaceholder:".powerwidget-timestamp",timestampFormat:"Last update: %m%/%d%/%y% %h%:%i%:%s%",refreshButton:true,refreshButtonClass:"fa fa-refresh",labelError:"Sorry but there was a error:",labelUpdated:"Last Update:",labelRefresh:"Refresh",labelDelete:"Delete widget:",afterLoad:function(){},rtl:false,onChange:function(){},onSave:function(){}}})(jQuery,window,document)