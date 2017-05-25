
var NewsBitByBit = NewsBitByBit || {};
;(function($, undefined) {
  NewsBitByBit = (function() {
    var currentCount = 0,
    root = '.js-newsWrap',
    list = '.column',
    button = '.js-readMore',
    busy = false,
    accomplished = false,
    options = {
      start: 4,
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
    $('#js-keyvisualSlider').slick({
      centerMode: true,
      variableWidth: true,
      dots: true,
      speed: 600,
      autoplay: true,
      autoplaySpeed: 5000,
      easing: 'easeInOutCubic',
      appendArrows: $('#js-keyvisualSliderArrow'),
      prevArrow: '<li class="keyvisualSliderArrow_item prev"><a href="">prev</a></li>',
      nextArrow: '<li class="keyvisualSliderArrow_item next"><a href="">next</a></li>'
    });
    $('.js-openModal').magnificPopup({
      type: 'iframe'
    });
    $('.suportColumn_text').tile();
  });
}(jQuery));

$(function(){
  function zeroPadding(number, digit) {
    return ('00' + number).slice(digit * -1);
  }
  $('.js-lineupIndex_item a').each(function(i){
    $(this).attr('data-label', '#lineup' + zeroPadding((i + 1) , 2));
  })
  $('.js-lineupIndex_item a').on('mouseenter', function(){
    $('.js-lineupIndex_item a').css('opacity','1');
    $(this).css('opacity','.7');
    $('div[id ^="lineup"]').css('display','none');
    $($(this).attr('data-label')).css('display','block');
    return false;
  });
});



