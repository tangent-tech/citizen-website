// if (!console) console = {log: function(){}};
/**
 * 全ページに読み込むことを想定。
 * 汎用的な処理をまとめたファイルです。
 */
var CTZN = CTZN || {};
;(function($, undefined) {
  /**
   *汎用的な処理群
   */
  CTZN.util = {
    checkbox: function() {
      var btn = $('.js-btn_checkbox > a'),
        self;

      btn.on('click.checkbox', function(e) {
        e.preventDefault();
        self = $(this);

        if($('input[type="checkbox"]', self).prop('checked') === false) {
          $('input[type="checkbox"]', self).prop('checked', true);
          self.parent().addClass('active');
        } else {
          $('input[type="checkbox"]', self).prop('checked', false);
          self.parent().removeClass('active');
        }
      });
    },
    /**
     * タブ
     * 大枠をjs-tabWrapで囲み、
     * 内包する形でトリガーとコンテンツを記述する。
     * <div class="js-tabWrap">
     *   <ul>
     *     <li class="js-tabTrigger><a href="#任意のID">トリガー</a></li>
     *     <li class="js-tabTrigger><a href="#任意のID2">トリガー</a></li>
     *   </ul>
     *   <div id="任意のID" class="js-tabTarget">コンテンツ</div>
     *   <div id="任意のID2" class="js-tabTarget">コンテンツ</div>
     * </div>
     */
    tab: function() {
      if(!$('.js-tabWrap')[0]) return;

      var owner = $('.js-tabWrap'),
        btn = $('.js-tabTrigger > a'),
        panel = $('.js-tabTarget'),
        cls = 'active';

      owner.on('click.tab', '.js-tabTrigger > a', function(e) {
        e.preventDefault();
		if ($(this).hasClass('disabled'))
			return;
		
        if(!$(this).parent().hasClass(cls)) {
          btn.parent().removeClass(cls);
          $(this).parent().addClass(cls);
          panel.removeClass(cls);
          $($(this).attr('href')).addClass(cls);
        } else {
          return;
        }
      });
    },
    /**
     * アコーディオン
     * 大枠をjs-accordionWrapで囲み、
     * 内包する形でトリガーとコンテンツを記述する。
     * <div class="js-accordionWrap">
     *   <div class="js-accordionTrigger">トリガー</div>
     *   <div class="js-accordionTarget">コンテンツ</div>
     * </div>
     */
    accordion: function() {
      if(!$('.js-accordionWrap')[0]) return;

      var owner = $('.js-accordionWrap'),
        btn = $('.js-accordionTrigger > a'),
        panel = $('.js-accordionTarget'),
        cls = 'active';

      owner.on('click.accordion', '.js-accordionTrigger > a', function(e) {
        e.preventDefault();
        if(!$(this).closest(owner).hasClass(cls)) {
          $(this).parent().next(btn).slideDown('swing');
          $(this).closest(owner).addClass(cls);
          /**
           * コールバックがあった時に実行
           */
          if(typeof callbackAccordion === 'function') {
            callbackAccordion();
          }
        } else {
          $(this).parent().next(btn).slideUp('swing', function() {
            $(this).closest(owner).removeClass(cls);
          });
        }
      });
    },
    hashCtrl: function(){
      var h = location.hash;
      if($(h).length > 0 && h.indexOf('#js-modalPopup') == -1){
        $(window).load(function() {
          var target = $(h), position = 0;
          if (target.length >= 1) {
            position = Number(target.offset().top) || position;
            $('html, body').animate({
              scrollTop : position - 89
            }, 500, 'easeOutExpo');
          }
        });
      }
      $('a[href^=#]').filter(function(){
        return $(this).parent().attr('id') != 'pagetop' &&
          !$(this).parent().hasClass('js-accordionTrigger') &&
          !$(this).parent().hasClass('js-tabTrigger') &&
          $(this).attr('href').indexOf('#js-modalPopup') == -1 &&
          !$(this).hasClass('js-openModal');
      }).on('click.o',  function() {
        var target = $($(this).attr('href')), position = 0;
          if (target.length >= 1) {
            position = Number(target.offset().top) || position;
            $('html, body').animate({
              scrollTop : position - 89
            }, 500, 'easeOutExpo');
          }
        return;
      });
    }
  };
  /**
  *検索周りの処理群
  */
  CTZN.search = {
    clearButton: function() {
      if(!$('#js-search_clearButton')[0]) return;

      var btn = $('#js-search_clearButton > a');

      btn.on('click', function(e) {
        e.preventDefault();
        $('#js-search_inputList').find('input[type="checkbox"]').prop('checked', false);
        $('.js-btn_checkbox').removeClass('active');
      });
    },
    sortButton: function() {
      if(!$('#js-sort_buttonList')[0]) return;
//      var owner = $('#js-sort_buttonList'),
//      btn = $('.js-sort_button > a');
//      owner.on('click.sortButton', '.js-sort_button > a', function(e) {
//        e.preventDefault();
//        btn.parent().removeClass('active');
//        $(this).parent().addClass('active');
//      });
    }
  };
  CTZN.pagetop = (function() {
    if(!'debounce' in $) return;
    var elm = '',
    scTop = 200,
    settings = function(){
      bindElement();
      if(elm.length > 0){
        setDefault();
        attachUIEvent();
        attachScrollEvent();
      }
    },
    setDefault = function (){
      elm.children('a').attr('href','javascript:;');
      elm.css({
        '-webkit-transition': 'all 500ms cubic-bezier(.13,.63,.35,1.23)',
        '-moz-transition': 'all 500ms cubic-bezier(.13,.63,.35,1.23)',
        '-o-transition': 'all 500ms cubic-bezier(.13,.63,.35,1.23)',
        'transition': 'all 500ms cubic-bezier(.13,.63,.35,1.23)',
        '-webkit-transform': 'translateY(200px)',
        'transform': 'translateY(200px)',
        'display': 'block'
      });
    },
    attachUIEvent = function(){
      elm.on('click.o touchend.o', 'a', function(){
        elm.css({'-webkit-transform': 'translateY(0px)','transform': 'translateY(0px)'});
        $('html, body').stop().animate({
            scrollTop : 0
        }, 500, 'easeOutExpo');
        return;
      })
    },
    attachScrollEvent = function(){
      $(window).on('scroll.o', $.debounce(100, function(){
        if ($(window).scrollTop() > scTop) {
          elm.css({'-webkit-transform': 'translateY(0px)','transform': 'translateY(0px)'});
        } else {
          elm.css({'-webkit-transform': 'translateY(200px)','transform': 'translateY(200px)'});
        }
      }));
    },
    bindElement = function(){
      elm = $('#pagetop');
    };
    return {
      init:function(){
        settings();
      }
    };
  }());

  CTZN.headerSiteSearch = (function() {
    var btn, panel, panelHeight,
    settings = function(){
      assignElement();
      setDefault();
      attachUIEvent();
    },
    setDefault = function (){
      panelHeight = panel.outerHeight(true);
      panel.css({'height': 0, 'overflow': 'hidden'});
    },
    openAndClosePanel = function(b){
      var tgtHeight = b ? 0 : panelHeight;
      panel.stop(false, false).animate({
        height: tgtHeight
      },{
        complete: function(e) {
          btn.toggleClass('expand')
        },
        duration :400,
        easing: 'easeOutExpo'
      });
    },
    attachUIEvent = function(){
      btn.on('click.o touchend.o', function(){
        openAndClosePanel($(this).hasClass('expand'));
        return;
      });
    },
    assignElement = function(){
      btn = $('.js-expandSearch');
      panel = $('.js-searchPanel');
    };
    return {
      init:function(){
        settings();
      }
    };
  }());

  CTZN.drawer = (function() {
    var btn, panel, panelHeight, myScroll,
    settings = function(){
      if($('#iscwrapper').length <= 0) return;
      assignElement();
      setDefault();
      attachUIEvent();
    },
    setDefault = function (){
      if($('body').hasClass('js-headerNoFollow')){
        btn.parent().css({'position': 'absolute'});
      }
    },
    setBodyOverflow = function(b){
      if(b){
        var stid = setTimeout(function(){
          clearTimeout(stid);
          $('body,html').removeAttr('style').off('touchmove');
          panel.removeAttr('style');
        }, 500);
      }else{
        $('body').css({'overflow': 'hidden'}).on('touchmove', function(e){e.preventDefault();});
      }
    },
    openAndClosePanel = function(b){
      var panelRight = b ? -264 : 0, btnRight = b ? 0 :264;
      setBodyOverflow(b);
      panel.children().focus();
      panel.stop(false, false).animate({
        right: panelRight
      },{
        complete: function(e) {
          btn.toggleClass('expand');
        },
        duration: 500,
        easing: 'easeOutExpo'
      });
      btnWrap.stop(false, false).animate({
        right: btnRight
      },{
        duration: 500,
        easing: 'easeOutExpo'
      });
    },
    attachUIEvent = function(){
      btn.on('click.o touchend.o', function(){
        openAndClosePanel($(this).hasClass('expand'));
        return;
      });
      panel.on('click.accordion', '.js-accordionTrigger > a', function(e) {
        var stid = setTimeout(function(){
          myScroll.refresh();
        }, 1000)
      });
    },
    assignElement = function(){
      myScroll = new IScroll('#iscwrapper', {
        scrollbars: true,
        preventDefault: false
      });

      btn = $('.js-drawerBtn > a');
      btnWrap = $('.js-drawerBtn');
      panel = $('.js-drawerPanel');
    };
    return {
      init:function(){
        settings();
      }
    };
  }());

  CTZN.sns = (function(){
    var func = {},
    settings = function(){
      setLineHref();
      attachUIEvent();
    },
    setLineHref = function(){
      var h = 'http://line.me/R/msg/text/?'+encodeURIComponent(document.title) + '%20' + encodeURIComponent(location.href);
      $('.js-sns-ln').find('a[href="line://msg/"]').attr('href', h);
    },
    attachUIEvent = function(){
      $('.js-sns-tw,.js-sns-fb,.js-sns-ln').on('click.sns', function(e){
        if($(this).hasClass('active')){
          $(this).removeClass('active');
          $('body').off('click.sns');
          e.stopPropagation();
        }else{
          $('.js-sns-tw,.js-sns-fb,.js-sns-ln').removeClass('active');
          $(this).addClass('active');
          e.stopPropagation();
          $('body').on('click.sns', function(){
            $('.js-sns-tw,.js-sns-fb,.js-sns-ln').removeClass('active');
            $('body').off('click.sns');
            return;
          });
        }
        return;
      });
    };
    func = {
      init: function(){
        settings();
      }
    }
    return func;
  }());

  $(function() {
    CTZN.util.checkbox();
    CTZN.util.tab();
    CTZN.util.accordion();
    CTZN.search.clearButton();
    CTZN.search.sortButton();
    CTZN.pagetop.init();
    CTZN.headerSiteSearch.init();
    CTZN.drawer.init();
    CTZN.sns.init();
    CTZN.util.hashCtrl();
  });
}(jQuery));