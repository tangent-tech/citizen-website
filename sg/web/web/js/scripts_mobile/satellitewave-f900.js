
var NewsBitByBit = NewsBitByBit || {};
;(function($, undefined) {
  NewsBitByBit = (function() {
    var currentCount = 0,
    root = '.js-readMore',
    list = '.js-readMoreItem',
    button = '.js-readMoreBtn',
    busy = false,
    accomplished = false,
    options = {
      start: 3,
      step: 2,
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
        busy = false;
      }, d)
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
        checkNoMore(currentCount + (options.step * 2) <= root.find(list).length);
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

;(function($, undefined) {
$(function() {
  $('#js-productSlider').bxSlider();
  $('#js-popularListSlider').slick({
    infinite: true,
    centerMode: true,
    slidesToShow: 3,
    variableWidth: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 3000
  });
  $('.js-openModal').magnificPopup({
    type: 'iframe'
  });
  $('.recommend_tab li').tile(2);
  $(window).on('orientationchange resize', function(){
    $('.recommend_tab li').tile(2);
  });
});
}(jQuery));



