
var ScrollDisplay = ScrollDisplay || {};
;(function($, undefined) {
  ScrollDisplay = (function() {
    var func = {},
    currentCount = 0,
    footerHeight = 0,
    step = 3,/*3column*/
    root = '.js-displayItem',
    column = '.columnWrap.column5',
    loadingHTML = '<div class="loading"><img src="' + BaseURL + '/images/common/loader.gif"></div>',
    loadingElm = undefined,
    busy = false,
    accomplished = false,
    pairMode = false,
    settings = function(){
      //resetTopMargin();
      measureFooter();
      appendLoading();
      attachScrollEvent();
      makeFiveWrap();
      attachElement();
    },
    resettings = function(){
      currentCount = 0;
      accomplished = false;
      busy = false;
      makeFiveWrap();
      attachElement();
      measureFooter();
      appendLoading();
    },
    attachElement = function(){
      $(root).find(column).each(function(i){
        $(this).attr('data-index', i).removeAttr('style');
      });
    },
	/*
    resetTopMargin = function(){
      $(root).find(column).each(function(){
        if($(this).find('.new_icon').length <= 0){
          $(this).find('.column').css({'margin-top': 0})
        }
      });
    },
	*/
    makeFiveWrap = function(){
      var p = $('.columnWrap.lineupWrap.column5').eq(0), w = '', cnt = 1, fivecount = 0;
      w += '<div class="columnWrap lineupWrap column5">';
      w += '<ul class="clearfix"></ul>';
      w += '</div>';
      if(pairMode){
        var pidcache = undefined, pid;
        $('.columnWrap.lineupWrap.column5').children('ul').children('li').each(function(i){
          pid = $(this).find('input[type="hidden"][name="pairid"]').val();
          if((pid != pidcache && i >= 5) || fivecount >= 5){
            $('.columnWrap.lineupWrap.column5').eq(cnt - 1).after(w);
            p = $('.columnWrap.lineupWrap.column5').eq(cnt);
            cnt ++;
            fivecount = 0;
          };
          var e = $(this).remove();
          p.children('ul').append(e);
          pidcache = pid;
          fivecount ++;
        });
      } else {
        $('.columnWrap.lineupWrap.column5').children('ul').children('li').each(function(i){
          if(i % 5 == 0 && i >= 5){
            $('.columnWrap.lineupWrap.column5').eq(cnt - 1).after(w);
            p = $('.columnWrap.lineupWrap.column5').eq(cnt);
            cnt ++;
          }
          if(i >= 5){
            var e = $(this).remove();
            p.children('ul').append(e);
          };
        });
      }
    },
    makeElementHeight = function(){
      $(column).find('li.column').tile(5);
    },
    measureFooter = function(){
      footerHeight = $('.footer').outerHeight();
    },
    appendLoading = function(){
      if($(root).find('.loading').length > 0) return;
      $(root).append(loadingHTML);
      loadingElm = $(root).find('.loading');
    },
    fadeInColumn = function(sel){
      var i, l, stid, d = 500;
      $(sel).show().animate({
        opacity:1
      },{
        step: function(now, fx) {
          var opacity = Math.round(now * 100);
          $(sel).css('-ms-filter', 'progid:DXImageTransform.Microsoft.Alpha(Opacity=' + opacity + ')');
        },
        complete: function(e) {
          //makeElementHeight();
        },
        duration: d
      });
      stid = setTimeout(function(){
        clearTimeout(stid);
        currentCount += step;
        busy = false;
        showAndHideLoading(false);
      }, d);
    },
    showAndHideLoading = function(b){
      loadingElm.css({'display': b ? 'block' : 'none'})
    },
    showSelectedColumn = function(){
      var i, l, sel = [];
      for(i = currentCount, l = currentCount + step; i < l; i ++){
        if($(column + '[data-index=' + i +']').length > 0){
          sel.push(column + '[data-index=' + i +']')
        }else{
          accomplished = true;
        }
      }
      sel = sel.join(',');
      $(sel).find('img').each(function(){
        $(this).attr('src', $(this).attr('data-src'));
      });
      $(sel).imagesLoaded().done(function(e){
        fadeInColumn(sel);
      }).fail(function(e) {
        fadeInColumn(sel);
      });
    },
    startDisplay = function(){
      if(!busy && !accomplished){
        busy = true;
        showAndHideLoading(true)
        showSelectedColumn();
      }
    },
    removeInner = function(){
      $(root).children().remove();
    }
    displayByTrigger = function(){
      startDisplay();
    }
    attachScrollEvent = function(){
      $(window).on('scroll.o', function(){
        if($(window).scrollTop() >= $(document).height() - $(window).height() - footerHeight){
          startDisplay();
        }
      });
    };
    func = {
      init: function(mode){
        func.setPairMode(mode === 'pair')
        settings();
      },
      restart: function(mode){
        //removeInner();
        func.setPairMode(mode === 'pair')
        resettings();
      },
      clearnUpInside: function(){
        removeInner();
      },
      setStep: function(i){
        step = i;
      },
      forceTrigger: function(){
        displayByTrigger();
      },
      forceTrigger: function(){
        displayByTrigger();
      },
      setPairMode: function(b){
        if(typeof b === 'boolean'){
          pairMode = b;
        } else {
          return;
        }
      },
      getPairMode: function(){
        return pairMode;
      }
	  
    }
    return func;
  }());
//   $(function() {
//     ScrollDisplay.init('pair');
//   });
}(jQuery));
