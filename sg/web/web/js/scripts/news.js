
$(function(){
  $('.news_popup_sliderImg img').not('img:first-child').css('display','none');
  $('.js-thumbs li').on('click', function(){
    var clickObj = $(this);
    var img = $(this).parents('.news_popup_slider').find('.news_popup_sliderImg img');
    clickObj.parent().find('li').removeClass('active');
    clickObj.addClass('active');
    img.css('display','none');
    img.eq(clickObj.parent().find('li').index(this)).fadeIn(300);
  });
});

var NewsBitByBit = NewsBitByBit || {};
;(function($, undefined) {
  NewsBitByBit = (function() {
    var currentCount = 0,
    root = '.js-newsWrap',
    list = '.news_main_item',
    button = '.js-readMore',
    busy = false,
    accomplished = false,
    options = {
      start: 8,
      step: 4,
      end: undefined
    },
    settings = function(){
      attachElement();
      attachUIEvent();
      startDisplay();
    },
    resettings = function(){
    },
    attachElement = function(){
      root = $(root);
      root.find(list).each(function(i){
        $(this).attr('data-index', i).css({
          'display': 'none',
          'opacity': 0,
          '-ms-filter': 'progid:DXImageTransform.Microsoft.Alpha(Opacity=0)'
        })
      });
    },
    fadeInColumn = function(sel){
      var i, l, stid, d = currentCount == 0 ? 0 : 500;
      root.find(sel).show().animate({
        opacity:1
      },{
        step: function(now, fx) {
          var opacity = Math.round(now * 100);
          $(sel).css('-ms-filter', 'progid:DXImageTransform.Microsoft.Alpha(Opacity=' + opacity + ')');
        },
        complete: function(e) {
        },
        duration: d
      });
      stid = setTimeout(function(){
        clearTimeout(stid);
        if(currentCount == 0){
          currentCount += options.start;
        }else{
          currentCount += options.step;
        }
        checkNoMore(currentCount < root.find(list).length);
        busy = false;
      }, d);
    },
    showSelectedColumn = function(){
      var i, l, sel = [], inc = currentCount == 0 ? options.start : options.step;
      for(i = currentCount, l = currentCount + inc; i < l; i ++){
        if(root.find('[data-index=' + i +']').length > 0){
          sel.push('[data-index=' + i +']');
        }else{
          accomplished = true;
        }
      }
      sel = sel.join(',');
      fadeInColumn(sel);
    },
    startDisplay = function(){
      if(!busy && !accomplished){
        busy = true;
        showSelectedColumn();
        checkNoMore((currentCount + options.step) < root.find(list).length);
      }
    },
    displayByTrigger = function(){
      startDisplay();
    },
    checkNoMore = function(b){
      if(!b){
        $(button).parent().css({'display':'none'});
      }
    },
    attachUIEvent = function(){
      root.on('click.o', button, function(e){
        checkNoMore((currentCount + options.step) < root.find(list).length);
        startDisplay();
        return;
      });
    };
    return {
      init: function(){
        settings();
      },
      forceDisplay: function(){
        displayByTrigger();
      },
      get : function(){
        return options
      },
      set : function(o){
        if(typeof o != 'undefined' && typeof o === 'object'){
          for(var key in o){
            if(key in options) options[key] = o[key];
          }
        }
      }
    }
  }());
  $(function() {
    NewsBitByBit.init();
  });
}(jQuery));



