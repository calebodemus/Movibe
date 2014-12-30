/* ========================================================================
 * Bootstrap: modal.js v3.1.1 Revised by DazeinCreative
 * http://getbootstrap.com/javascript/#modals
 * http://themeforest.net/user/DazeinCreative
 * ========================================================================
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
 'use strict';

  // MODAL CLASS DEFINITION
  // ======================

  var Modal = function (element, options) {
    this.options   = options
    this.$element  = $(element)
    this.$backdrop =
    this.isShown   = null

    if (this.options.remote) {
      this.$element
        .find('.modal-content')
        .load(this.options.remote, $.proxy(function () {
          this.$element.trigger('loaded.bs.modal')
        }, this))
    }
  }

  Modal.DEFAULTS = {
    backdrop: true,
    keyboard: true,
    show: true
  }

  Modal.prototype.toggle = function (_relatedTarget) {
    return this[!this.isShown ? 'show' : 'hide'](_relatedTarget)
  }

  Modal.prototype.show = function (_relatedTarget) {
    var that = this
    var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

    this.$element.trigger(e)

    if (this.isShown || e.isDefaultPrevented()) return

    this.isShown = true

    this.escape()

    this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

    this.backdrop(function () {
      // var transition = $.support.transition && that.$element.hasClass('fade')
      var transition = $.support.transition && that.$element.hasClass(that.options.easein);

      if (!that.$element.parent().length) {
        that.$element.appendTo(document.body) // don't move modals dom position
      }

      that.$element
        .show()
        .scrollTop(0)

      if (transition) {
        that.$element[0].offsetWidth // force reflow
      }

      that.$element
        // .addClass('in')
        .removeClass(that.options.easeout)
        .addClass('animated' + ' ' + that.options.easein)
        .attr('aria-hidden', false)

      that.enforceFocus()

      var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

      transition ?
        that.$element.find('.modal-dialog') // wait for modal to slide in
          .one($.support.transition.end, function () {
            that.$element.focus().trigger(e)
          })
          .emulateTransitionEnd(300) :
        that.$element.focus().trigger(e)
    })
  }
function eventsList(element) {
            // JQuery Versions compartibility
			var events;
           // events = element.data('events');
            //if (events !== undefined) return events;

            events = $.data(element, 'events');
            if (events !== undefined) return true;

            events = $._data(element, 'events');
            if (events !== undefined) return true;

           // events = $._data(element[0], 'events');
           // if (events !== undefined) return events;

            return false;
        }
  	function getEventType(e) {
2
    if (!e) e = window.event;
3
    alert(e.type);
4
}

  Modal.prototype.hide = function (e) {

  	if ({}.toString.call(e).slice(8,-1)=="HTMLAnchorElement") return
if (e) e.preventDefault()
	
    e = $.Event('hide.bs.modal')

    this.$element.trigger(e)

    if (!this.isShown || e.isDefaultPrevented()) return

    this.isShown = false

    this.escape()

    $(document).off('focusin.bs.modal')
    this.$element
      .removeClass('in ' + this.options.easein)
      .addClass('' + ' ' + this.options.easeout)
      .attr('aria-hidden', true)
      .off('click.dismiss.bs.modal')

    $.support.transition?
      this.$element
        .one($.support.transition.end, $.proxy(this.hideModal, this))
        .emulateTransitionEnd(300) :
      this.hideModal()
  }

  Modal.prototype.enforceFocus = function () {
    $(document)
      .off('focusin.bs.modal') // guard against infinite focus loop
      .on('focusin.bs.modal', $.proxy(function (e) {
        if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
          this.$element.focus()
        }
      }, this))
  }

  Modal.prototype.escape = function () {
    if (this.isShown && this.options.keyboard) {
      this.$element.on('keyup.dismiss.bs.modal', $.proxy(function (e) {
        e.which == 27 && this.hide()
      }, this))
    } else if (!this.isShown) {
      this.$element.off('keyup.dismiss.bs.modal')
    }
  }

  Modal.prototype.hideModal = function () {
    var that = this
    this.$element.hide()
    this.backdrop(function () {
      that.removeBackdrop()
      that.$element.trigger('hidden.bs.modal')
    })
  }

  Modal.prototype.removeBackdrop = function () {
    this.$backdrop && this.$backdrop.remove()
    this.$backdrop = null
  }

  Modal.prototype.backdrop = function (callback) {
    var animate = this.$element.hasClass('fade') ? 'fade' : ''

    if (this.isShown && this.options.backdrop) {
      var doAnimate = $.support.transition && animate

      this.$backdrop = $('<div class="modal-backdrop ' + animate + '" />')
        .appendTo(document.body)

      this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
        if (e.target !== e.currentTarget) return
        this.options.backdrop == 'static'
          ? this.$element[0].focus.call(this.$element[0])
          : this.hide.call(this)
      }, this))

      if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

      this.$backdrop.addClass('in')

      if (!callback) return

      doAnimate ?
        this.$backdrop
          .one($.support.transition.end, callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (!this.isShown && this.$backdrop) {
      this.$backdrop.removeClass('in')

      $.support.transition && this.$element.hasClass('fade') ?
        this.$backdrop
          .one($.support.transition.end, callback)
          .emulateTransitionEnd(150) :
        callback()

    } else if (callback) {
      callback()
    }
  }


  // MODAL PLUGIN DEFINITION
  // =======================

  var old = $.fn.modal

  $.fn.modal = function (option, _relatedTarget) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.modal')
      var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
      if (typeof option == 'string') data[option](_relatedTarget)
      else if (options.show) data.show(_relatedTarget)
    })
  }

  $.fn.modal.Constructor = Modal


  // MODAL NO CONFLICT
  // =================

  $.fn.modal.noConflict = function () {
    $.fn.modal = old
    return this
  }


  // MODAL DATA-API
  // ==============

  $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
    var $this   = $(this)
    var href    = $this.attr('href')
    var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) //strip for ie7
    var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

    if ($this.is('a')) e.preventDefault()

    $target
      .modal(option, this)
      .one('hide', function () {
        $this.is(':visible') && $this.focus()
      })
  })

  $(document)
    .on('show.bs.modal', '.modal', function () { $(document.body).addClass('modal-open') })
    .on('hidden.bs.modal', '.modal', function () { $(document.body).removeClass('modal-open') })

}(jQuery);

$(function() {

    // the global default ease in animation of the tab and popover
    var _easeIn = 'fadeInLeft';
    var _previewTabContent;
    var _previeweaseIn;

    enhanceTab($('#myTab1 a'), $('#tab-content1'));
    // enhanceTab($('#myTab2 a'), $('#tab-content2'));

    // add the animation to the tab
    function enhanceTab(tab, tabContent, easein){
      tab.click(function (e) {
          e.preventDefault();
          $(this).tab('show');
          var _existeaseIn = $(this).data('easein');
          if(_previewTabContent) _previewTabContent.removeClass(_previeweaseIn);
          if(_existeaseIn){
              tabContent.find('div.active').addClass('animated '+ _existeaseIn);
              _previeweaseIn = _existeaseIn;
          }else{
              if(easein){
                tabContent.find('div.active').addClass('animated '+ easein);
                _previeweaseIn = easein;
              }else{
                tabContent.find('div.active').addClass('animated '+ _easeIn);
                _previeweaseIn = _easeIn;
              }
          }
          _previewTabContent = tabContent.find('div.active');
      });

    }

    // add the animation to the popover
    $("a[rel=popover]").popover().click(function(e) {
        e.preventDefault();
        if($(this).data('easein')!=undefined){
		     $(this).next(".popover").removeClass($(this).data('easein')).addClass('animated ' + $(this).data('easein'));
        } else{
          $(this).next(".popover").addClass('animated ' + _easeIn);
        } 
    })
});

/*
 * jCal calendar multi-day and multi-month datepicker plugin for jQuery
 *	version 0.3.6
 * Author: Jim Palmer
 * Released under MIT license.
 */
(function($){$.fn.jCal=function(opt){$.jCal(this,opt);};$.jCal=function(target,opt){opt=$.extend({day:new Date(),days:1,showMonths:1,monthSelect:false,dCheck:function(day){return true;},callback:function(day,days){return true;},selectedBG:'rgb(0, 143, 214)',defaultBG:'rgb(255, 255, 255)',dayOffset:0,forceWeek:false,dow:['S','M','T','W','T','F','S'],ml:['January','February','March','April','May','June','July','August','September','October','November','December'],ms:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],_target:target},opt);opt.day=new Date(opt.day.getFullYear(),opt.day.getMonth(),1);if(!$(opt._target).data('days'))$(opt._target).data('days',opt.days);$(target).stop().empty();for(var sm=0;sm<opt.showMonths;sm++)$(target).append('<div class="jCalMo"></div>');opt.cID='c'+$('.jCalMo').length;$('.jCalMo',target).each(function(ind){drawCalControl($(this),$.extend({},opt,{'ind':ind,'day':new Date(new Date(opt.day.getTime()).setMonth(new Date(opt.day.getTime()).getMonth()+ind))}));drawCal($(this),$.extend({},opt,{'ind':ind,'day':new Date(new Date(opt.day.getTime()).setMonth(new Date(opt.day.getTime()).getMonth()+ind))}));});if($(opt._target).data('day')&&$(opt._target).data('days'))reSelectDates(target,$(opt._target).data('day'),$(opt._target).data('days'),opt);};function drawCalControl(target,opt){$(target).append('<div class="jCal">'+((opt.ind==0)?'<div class="left" />':'')+'<div class="month">'+'<span class="monthYear">'+opt.day.getFullYear()+'</span>'+'<span class="monthName">'+opt.ml[opt.day.getMonth()]+'</span>'+'</div>'+((opt.ind==(opt.showMonths-1))?'<div class="right" />':'')+'</div>');if(opt.monthSelect)$(target).find('.jCal .monthName, .jCal .monthYear').bind('mouseover',$.extend({},opt),function(e){$(this).removeClass('monthYearHover').removeClass('monthNameHover');if($('.jCalMask',e.data._target).length==0)$(this).addClass($(this).attr('class')+'Hover');}).bind('mouseout',function(){$(this).removeClass('monthYearHover').removeClass('monthNameHover');}).bind('click',$.extend({},opt),function(e){$('.jCalMo .monthSelector, .jCalMo .monthSelectorShadow').remove();var monthName=$(this).hasClass('monthName'),pad=Math.max(parseInt($(this).css('padding-left')),parseInt($(this).css('padding-left')))||2,calcTop=(($(this).offset()).top-((monthName?e.data.day.getMonth():2)*($(this).height()+0)));calcTop=calcTop>0?calcTop:0;var topDiff=($(this).offset()).top-calcTop;$('<div class="monthSelectorShadow" style="'+'top:'+$(e.data._target).offset().top+'px; '+'left:'+$(e.data._target).offset().left+'px; '+'width:'+($(e.data._target).width()+(parseInt($(e.data._target).css('paddingLeft'))||0)+(parseInt($(e.data._target).css('paddingRight'))||0))+'px; '+'height:'+($(e.data._target).height()+(parseInt($(e.data._target).css('paddingTop'))||0)+(parseInt($(e.data._target).css('paddingBottom'))||0))+'px;">'+'</div>').css('opacity',0.01).appendTo($(this).parent());$('<div class="monthSelector" style="'+'top:'+calcTop+'px; '+'left:'+(($(this).offset()).left)+'px; '+'width:'+($(this).width()+(pad*2))+'px;">'+'</div>').css('opacity',0).appendTo($(this).parent());for(var di=(monthName?0:-2),dd=(monthName?12:3);di<dd;di++)$(this).clone().removeClass('monthYearHover').removeClass('monthNameHover').addClass('monthSelect').attr('id',monthName?(di+1)+'_1_'+e.data.day.getFullYear():(e.data.day.getMonth()+1)+'_1_'+(e.data.day.getFullYear()+di)).html(monthName?e.data.ml[di]:(e.data.day.getFullYear()+di)).css('top',($(this).height()*di)).appendTo($(this).parent().find('.monthSelector'));var moSel=$(this).parent().find('.monthSelector').get(0),diffOff=$(moSel).height()-($(moSel).height()-topDiff);$(moSel).css('clip','rect('+diffOff+'px '+($(this).width()+(pad*2))+'px '+diffOff+'px 0px)').animate({'opacity':.92,'clip':'rect(0px '+($(this).width()+(pad*2))+'px '+$(moSel).height()+'px 0px)'},'fast',function(){$(this).parent().find('.monthSelectorShadow').bind('mouseover click',function(){$(this).parent().find('.monthSelector').remove();$(this).remove();});}).parent().find('.monthSelectorShadow').animate({'opacity':.1},'fast');$('.jCalMo .monthSelect',e.data._target).bind('mouseover mouseout click',$.extend({},e.data),function(e){if(e.type=='click')$(e.data._target).jCal($.extend(e.data,{day:new Date($(this).attr('id').replace(/_/g,'/'))}));else
$(this).toggleClass('monthSelectHover');});});$(target).find('.jCal .left').bind('click',$.extend({},opt),function(e){if($('.jCalMask',e.data._target).length>0)return false;var mD={w:0,h:0};$('.jCalMo',e.data._target).each(function(){mD.w+=$(this).width()+parseInt($(this).css('padding-left'))+parseInt($(this).css('padding-right'));var cH=$(this).height()+parseInt($(this).css('padding-top'))+parseInt($(this).css('padding-bottom'));mD.h=((cH>mD.h)?cH:mD.h);});$(e.data._target).prepend('<div class="jCalMo"></div>');e.data.day=new Date($('div[id*='+e.data.cID+'d_]:first',e.data._target).attr('id').replace(e.data.cID+'d_','').replace(/_/g,'/'));e.data.day.setDate(1);e.data.day.setMonth(e.data.day.getMonth()-1);drawCalControl($('.jCalMo:first',e.data._target),e.data);drawCal($('.jCalMo:first',e.data._target),e.data);if(e.data.showMonths>1){$('.right',e.data._target).clone(true).appendTo($('.jCalMo:eq(1) .jCal',e.data._target));$('.left:last, .right:last',e.data._target).remove();}$(e.data._target).append('<div class="jCalSpace" style="width:'+mD.w+'px; height:'+mD.h+'px;"></div>');$('.jCalMo',e.data._target).wrapAll('<div class="jCalMask" style="clip:rect(0px '+mD.w+'px '+mD.h+'px 0px); width:'+(mD.w+(mD.w/e.data.showMonths))+'px; height:'+mD.h+'px;">'+'<div class="jCalMove"></div>'+'</div>');$('.jCalMove',e.data._target).css('margin-left',((mD.w/e.data.showMonths)*-1)+'px').css('opacity',0.5).animate({marginLeft:'0px'},'fast',function(){$(this).children('.jCalMo:not(:last)').appendTo($(e.data._target));$('.jCalSpace, .jCalMask',e.data._target).empty().remove();if($(e.data._target).data('day'))reSelectDates(e.data._target,$(e.data._target).data('day'),$(e.data._target).data('days'),e.data);});});$(target).find('.jCal .right').bind('click',$.extend({},opt),function(e){if($('.jCalMask',e.data._target).length>0)return false;var mD={w:0,h:0};$('.jCalMo',e.data._target).each(function(){mD.w+=$(this).width()+parseInt($(this).css('padding-left'))+parseInt($(this).css('padding-right'));var cH=$(this).height()+parseInt($(this).css('padding-top'))+parseInt($(this).css('padding-bottom'));mD.h=((cH>mD.h)?cH:mD.h);});$(e.data._target).append('<div class="jCalMo"></div>');e.data.day=new Date($('div[id^='+e.data.cID+'d_]:last',e.data._target).attr('id').replace(e.data.cID+'d_','').replace(/_/g,'/'));e.data.day.setDate(1);e.data.day.setMonth(e.data.day.getMonth()+1);drawCalControl($('.jCalMo:last',e.data._target),e.data);drawCal($('.jCalMo:last',e.data._target),e.data);if(e.data.showMonths>1){$('.left',e.data._target).clone(true).prependTo($('.jCalMo:eq(1) .jCal',e.data._target));$('.left:first, .right:first',e.data._target).remove();}$(e.data._target).append('<div class="jCalSpace" style="width:'+mD.w+'px; height:'+mD.h+'px;"></div>');$('.jCalMo',e.data._target).wrapAll('<div class="jCalMask" style="clip:rect(0px '+mD.w+'px '+mD.h+'px 0px); width:'+(mD.w+(mD.w/e.data.showMonths))+'px; height:'+mD.h+'px;">'+'<div class="jCalMove"></div>'+'</div>');$('.jCalMove',e.data._target).css('opacity',0.5).animate({marginLeft:((mD.w/e.data.showMonths)*-1)+'px'},'fast',function(){$(this).children('.jCalMo:not(:first)').appendTo($(e.data._target));$('.jCalSpace, .jCalMask',e.data._target).empty().remove();if($(e.data._target).data('day'))reSelectDates(e.data._target,$(e.data._target).data('day'),$(e.data._target).data('days'),e.data);$(this).children('.jCalMo:not(:first)').removeClass('');});});$('.jCal',target).each(function(){var width=$(this).parent().width()-($('.left',this).width()||0)-($('.right',this).width()||0);$('.month',this).css('width',width).find('.monthName, .monthYear').css('width',((width/2)-4));});$(window).load(function(){$('.jCal',target).each(function(){var width=$(this).parent().width()-($('.left',this).width()||0)-($('.right',this).width()||0);$('.month',this).css('width',width).find('.monthName, .monthYear').css('width',((width/2)-4));});});};function reSelectDates(target,day,days,opt){var fDay=new Date(day.getTime());var sDay=new Date(day.getTime());for(var fC=false,di=0,dC=days;di<dC;di++){var dF=$(target).find('div[id*=d_'+(sDay.getMonth()+1)+'_'+sDay.getDate()+'_'+sDay.getFullYear()+']');if(dF.length>0){dF.stop().addClass('selectedDay');fC=true;}sDay.setDate(sDay.getDate()+1);}if(fC&&typeof opt.callback=='function')opt.callback(day,days);};function drawCal(target,opt){for(var ds=0,length=opt.dow.length;ds<length;ds++)$(target).append('<div class="dow">'+opt.dow[ds]+'</div>');var fd=new Date(new Date(opt.day.getTime()).setDate(1));var ldlm=new Date(new Date(fd.getTime()).setDate(0));var ld=new Date(new Date(new Date(fd.getTime()).setMonth(fd.getMonth()+1)).setDate(0));var copt={fd:fd.getDay(),lld:ldlm.getDate(),ld:ld.getDate()};var offsetDayStart=((copt.fd<opt.dayOffset)?(opt.dayOffset-7):1);var offsetDayEnd=((ld.getDay()<opt.dayOffset)?(7-ld.getDay()):ld.getDay());for(var d=offsetDayStart,dE=(copt.fd+copt.ld+(7-offsetDayEnd));d<dE;d++)$(target).append(((d<=(copt.fd-opt.dayOffset))?'<div id="'+opt.cID+'d'+d+'" class="pday">'+(copt.lld-((copt.fd-opt.dayOffset)-d))+'</div>':((d>((copt.fd-opt.dayOffset)+copt.ld))?'<div id="'+opt.cID+'d'+d+'" class="aday">'+(d-((copt.fd-opt.dayOffset)+copt.ld))+'</div>':'<div id="'+opt.cID+'d_'+(fd.getMonth()+1)+'_'+(d-(copt.fd-opt.dayOffset))+'_'+fd.getFullYear()+'" class="'+((opt.dCheck(new Date((new Date(fd.getTime())).setDate(d-(copt.fd-opt.dayOffset)))))?'day':'invday')+'">'+(d-(copt.fd-opt.dayOffset))+'</div>')));$(target).find('div[id^='+opt.cID+'d]:first, div[id^='+opt.cID+'d]:nth-child(7n+2)').before('<br style="clear:both; font-size:0.1em;" />');$(target).find('div[id^='+opt.cID+'d_]:not(.invday)').bind("mouseover mouseout click",$.extend({},opt),function(e){if($('.jCalMask',e.data._target).length>0)return false;var osDate=new Date($(this).attr('id').replace(/c[0-9]{1,}d_([0-9]{1,2})_([0-9]{1,2})_([0-9]{4})/,'$1/$2/$3'));if(e.data.forceWeek)osDate.setDate(osDate.getDate()+(e.data.dayOffset-osDate.getDay()));var sDate=new Date(osDate.getTime());if(e.type=='click')$('div[id*=d_]',e.data._target).stop().removeClass('selectedDay').removeClass('overDay').css('backgroundColor','');for(var di=0,ds=$(e.data._target).data('days');di<ds;di++){var currDay=$(e.data._target).find('#'+e.data.cID+'d_'+(sDate.getMonth()+1)+'_'+sDate.getDate()+'_'+sDate.getFullYear());if(currDay.length==0||$(currDay).hasClass('invday'))break;if(e.type=='mouseover')$(currDay).addClass('overDay');else if(e.type=='mouseout')$(currDay).stop().removeClass('overDay').css('backgroundColor','');else if(e.type=='click')$(currDay).stop().addClass('selectedDay');sDate.setDate(sDate.getDate()+1);}if(e.type=='click'){e.data.day=osDate;e.data.callback(osDate,di);$(e.data._target).data('day',e.data.day).data('days',di);}});};})(jQuery);
