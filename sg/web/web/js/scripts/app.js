// if (!console) console = {log: function(){}};
var CTZN = CTZN || {};

;(function($, undefined) {
  CTZN.util = {
    currentGnavi: function() {
      var owner = $('#js-gnavi'),
        path = location.pathname,
        pathArray = path.split('/').splice(1),
        link,
        linkArray;

      owner.find('.gnavi_item').each(function() {
        link = $(this).children('a').attr('href');
        linkArray = link.split('/').splice(1);
        if(pathArray[0] === linkArray[0]) {
          $(this).addClass('current');
        }
      });
    },
    /**
     * タブ
     * 大枠をjs-tabWrapで囲み、
     * 内包する形でトリガーとコンテンツを記述
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
        panel = $('.js-tabTarget');

      owner.on('click.tab', '.js-tabTrigger > a', function(e) {
        e.preventDefault();
        if(!$(this).parent().hasClass('active')) {
          btn.parent().removeClass('active');
          $(this).parent().addClass('active');
          panel.removeClass('active');
          $($(this).attr('href')).addClass('active');
          /*/support/guide/manual.html */
          if($('.manual_index').length > 0){
            $('.js-tabTarget.active').find('.manual_dlList_number,.manual_dlList_buttonList').tile(4);
            $('.js-tabTarget.active').find('.manual_dlList_item').tile(2)
          }
        } else {
          return;
        }
      });
      if($('.manual_index').length > 0){
        $('.js-tabTarget.active').find('.manual_dlList_number,.manual_dlList_buttonList').tile(4);
        $('.js-tabTarget.active').find('.manual_dlList_item').tile(2)
      }
    },
    /**
     * アコーディオン
     * 大枠をjs-accordionWrapで囲み、
     * 内包する形でトリガーとコンテンツを記述
     * <div class="js-accordionWrap">
     *   <div class="js-accordionTrigger">トリガー</div>
     *   <div class="js-accordionTarget">コンテンツ</div>
     * </div>
     */
    accordion: function() {
      if(!$('.js-accordionWrap')[0]) return;

      var owner = $('.js-accordionWrap'),
        btn = $('.js-accordionTrigger > a'),
        panel = $('.js-accordionTarget');

      owner.on('click.accordion', '.js-accordionTrigger > a', function(e) {
        e.preventDefault();
        if(!$(this).closest(owner).hasClass('active')) {
          $(this).parent().next(btn).slideDown('swing');
          $(this).closest(owner).addClass('active');
        } else {
          $(this).parent().next(btn).slideUp('swing', function() {
            $(this).closest(owner).removeClass('active');
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
   * グローバルナビ内のメガドロップダウンの処理
   */
  CTZN.util.megadrop = (function(){
    if(!('debounce' in $)) return;
    var dispTop = 89,
    scTop = 200,
    overlay, targetHeight = 0, gnavBtn, panel,
    func = {},
    timer = undefined,
    settings = function(){
      appendBg();
      mesureringHeight();
      bindElement();
      setUpSubNav();
      func.subNav.init();
      attchUIEvent();
      attachScrollEvent();
    },
    appendBg = function(){
      $('header[role="banner"]').append('<div id="js-overlay" />');
      overlay = $('#js-overlay');
    },
    mesureringHeight = function(){
      targetHeight = $('#js-megadropTarget').height() + 20 + 89;
    },
    bindElement = function(){
      gnavBtn = $('.gnavi_item');
      panel = $('#js-megadropTarget');
    },
    setUpSubNav = function(){
      func.subNav = (function() {
        // depend on jQuery-menu-aim.js
        if(!('menuAim' in $.fn)) return;
        var menu = $('#js-megadrop'), row, submenuId, submenu, subfunc,
        activeCls = 'active',
        settings = function(){
          activateSubmenu();
          deactivateSubmenu();
          menu.menuAim({
            activate: activateSubmenu,
            deactivate: deactivateSubmenu
          });
        },
        activateSubmenu = function(r) {
          row = $(r);
          submenuId = row.data('submenuId');
          submenu = $('#' + submenuId);
          row.addClass(activeCls);
          submenu.addClass(activeCls);
        },
        deactivateSubmenu = function(r) {
          row = $(r);
          submenuId = row.data('submenuId');
          submenu = $('#' + submenuId);
          row.removeClass(activeCls);
          submenu.removeClass(activeCls);
        };
        subfunc = {
          init:function(){
            settings();
          }
        };
        return subfunc;
      }());
    },
    attachScrollEvent = function(){
      $(window).on('scroll.o', $.debounce(10, function(){
        if ($(window).scrollTop() >= dispTop) {
          $('body').addClass('headerNarrow');
        }
        if ($(window).scrollTop() > scTop) {
          $('body').addClass('setpos');
        } else {
          $('body').removeClass('headerNarrow').removeClass('setpos');
        }
      }));
    },
    attchUIEvent = function(){
      $('.header').on('mousemove.mgd', function(e) {
        var tgt = $(e.target).closest('.js-megadropTrigger');
        if(tgt.length > 0 && !tgt.hasClass('active')) {
          if(typeof timer === 'undefined'){
            timer = setTimeout(function(){
              clearTimeout(timer);
              timer = undefined;
              tgt.addClass('active');
              overlay.stop(false, false).animate({
                'height': targetHeight + 'px'
              },{
                duration: 400,
                easing: 'easeOutExpo'
              });
              panel.stop(false, false).slideDown(400, 'easeOutExpo', function() {
                tgt.addClass('active');
              });
            }, 322);
          }
        } else if(tgt.hasClass('active')) {
          return;
        } else {
          clearTimeout(timer);
          timer = undefined;
          if(!$(':animated')[0]) {
            overlay.animate({
              'height': 0
            },{
              duration: 230,
              easing: 'easeOutExpo'
            });
            gnavBtn.removeClass('active');
            panel.slideUp(180, 'easeOutExpo', function() {
              panel.removeClass('active');
            });
          }
        }
        if($('body').hasClass('headerNarrow')){
          $('.header').addClass('active');
        }
        $('body').on('mousemove.mgd', function(e) {
          if($(e.target).closest('.header').length <= 0 && !$(':animated')[0]) {
            clearTimeout(timer);
            timer = undefined;
            overlay.animate({
              'height': 0
            }, {
              duration: 230,
              easing: 'easeOutExpo'
            });
            gnavBtn.removeClass('active');
            panel.slideUp(180, 'easeOutExpo', function() {
              panel.removeClass('active');
              $('body').off('mousemove.mgd');
            });
            if($('body').hasClass('headerNarrow')){
              $('.header').removeClass('active');
            }
          }
        });
      });
    };
    func = {
      init: function(){
        settings();
      }
    };
    return func;
  }());
  CTZN.search = {
    clearButton: function() {
      if(!$('#js-search_clearButton')[0]) return;

      var btn = $('#js-search_clearButton > a');
      btn.on('click.clearButton', function(e) {
        e.preventDefault();
        $('#js-search_inputList').find('input[type="checkbox"]').prop('checked', false);
      });
    },
    sortButton: function() {
//      if(!$('#js-sort_buttonList')[0]) return;
//      var owner = $('#js-sort_buttonList'),
//      btn = $('.js-sort_button > a');
//      owner.on('click.sortButton', '.js-sort_button > a', function(e) {
//        e.preventDefault();
//        btn.parent().removeClass('active');
//        $(this).parent().addClass('active');
//      });
    }
  };
  CTZN.tileBox = (function(){
    var func,
    settings = function(){
      $('.js-tileHeader :header').tile().css({
        'display':'table',
        'width':'100%'
      }).children().css({
        'display':'table-cell',
        'vertical-align':'middle'
      });
      $('.js-tileHeader .js-tileParagraph').tile();
    };
    func = {
      init: function(){
        settings();
      }
    };
    return func;
  }());
  CTZN.pagetop = (function(){
    if(!('debounce' in $)) return;
    var elm = '',
    scTop = 200,
    settings = function(){
      assignElement();
      if(elm.length > 0){
        setDefault();
        attachUIEvent();
        attachScrollEvent();
      }
    },
    setDefault = function (){
      elm.children('a').attr('href', 'javascript:;');
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
      });
    },
    attachScrollEvent = function(){
      $(window).on('scroll.pgt', $.debounce(10, function(){
        $('.header').find('input,select').blur();
        if ($(window).scrollTop() > scTop) {
          elm.css({'-webkit-transform': 'translateY(0px)','transform': 'translateY(0px)'});
        } else {
          elm.css({'-webkit-transform': 'translateY(200px)','transform': 'translateY(200px)'});
        }
      }));
    },
    assignElement = function(){
      elm = $('#pagetop');
    };
    return {
      init:function(){
        settings();
      }
    };
  }());
  CTZN.clock = (function(){
    var func = {},
    path = '/webadmin/extension/ctz_sysdate2.jsp?' + Math.random(),
    timeCode = '',
    year = '',
    month = '',
    day = '',
    hh = '',
    mm = '',
    ss = '',
    yearElm = undefined,
    monthElm = undefined,
    dayElm = undefined,
    timeElm = undefined,
    secHandElm = undefined,
    minHandElm = undefined,
    hurHandElm = undefined,
    dateObj = undefined,
    dateDiff = undefined,
    local = undefined,
    ssid = undefined,
    beforeTime = 0,
    afterTime = 0,
    settings = function(){
      if (!Date.now) {
        Date.now = function now() {
          return new Date().getTime();
        };
      }
      assignElement();
      if(yearElm.length > 0 && monthElm.length > 0 && dayElm.length > 0 && timeElm.length > 0 && secHandElm.length > 0 && minHandElm.length>0 && hurHandElm.length >0){
        getServerTime();
      }
    },
    zeroPadding = function (number, digit) {
      return ('00' + number).slice(digit * -1);
    },
    assignElement = function(){
      yearElm = $('.js-year');
      monthElm = $('.js-month');
      dayElm = $('.js-day');
      timeElm = $('.js-time');
      secHandElm = $('.js-secHand');
      minHandElm = $('.js-minHand');
      hurHandElm = $('.js-hurHand');
    },
    convertTimeCode = function(d){
      timeCode = d;
      year = parseInt(timeCode.slice(0, 4), 10);
      month = parseInt(timeCode.slice(4, 6), 10) - 1;
      day = parseInt(timeCode.slice(6, 8), 10);
      hh = parseInt(timeCode.slice(8, 10), 10);
      mm = parseInt(timeCode.slice(10, 12), 10);
      ss = parseInt(timeCode.slice(12, 14), 10);
      sss = parseInt(timeCode.slice(14, 17), 10);
      dateObj = new Date(year, month, day, hh, mm, ss, sss);
      local = new Date();
      afterTime = Date.now();
      dateDiff = dateObj - local + (afterTime - beforeTime) + 133;
      startTime();
    },
    setDateObj = function(s){
      var date = new Date(Date.now() + dateDiff);
      year = date.getFullYear();
      month = zeroPadding(date.getMonth() + 1, 2);
      day = zeroPadding(date.getDate(), 2);
      hh = zeroPadding(date.getHours(), 2);
      mm = zeroPadding(date.getMinutes(), 2);
      ss = zeroPadding(date.getSeconds(), 2);
      displayTime();
    },
    startTime = function(){
      ssid = setInterval(function(){
        setDateObj();
      }, 133);
    },
    displayTime = function(){
      yearElm.text(year);
      monthElm.text(month);
      dayElm.text(day);
      timeElm.text(hh + ':' + mm + ':' + ss);
      var hDeg = (~~hh % 12) * (360 / 12);
      var mDeg = ~~mm * (360 / 60);
      var sDeg = ss * (360 / 60);
      hDeg += (mm / 60) * (360 / 12);
      mDeg += (ss / 60) * (360 / 60);
      secHandElm.css({
        'transform':'rotate(' + sDeg + 'deg)'
      });
      minHandElm.css({
        'transform':'rotate(' + mDeg + 'deg)'
      });
      hurHandElm.css({
        'transform':'rotate(' + hDeg + 'deg)'
      });
    },
    getServerTime = function(){
      beforeTime = Date.now();
      $.ajax({
        type: 'get',
        url: path
      }).then(
        function(data){
          convertTimeCode(data);
        },
        function(data){
          dateDiff = 0;
          startTime();
        }
      );
    };
    func = {
      init: function(){
        settings();
      },
      setPath: function(p){
        path = p;
      },
      getPath: function(){
        return path;
      }
    }
    return func;
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
      $('.js-sns-tw,.js-sns-fb,.js-sns-ln').on('mouseover', function(){
        $(this).addClass('active');
      }).on('mouseout', function(){
        $(this).removeClass('active');
      });
    };
    func = {
      init: function(){
        settings();
      }
    }
    return func;
  }());
  window.openSubWindow = function(strUrl,winName,winWidth,winHeight) {
    var features = 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=' + winWidth + ',height=' + winHeight;
    winName = window.open(strUrl,winName,features);
    winName.focus();
    return false;
  }
  $(function() {
    CTZN.util.currentGnavi();
    CTZN.util.megadrop.init();
    CTZN.util.tab();
    CTZN.util.accordion();
    CTZN.search.clearButton();
    CTZN.search.sortButton();
    CTZN.pagetop.init();
    CTZN.tileBox.init();
    CTZN.clock.init();
    CTZN.sns.init();
    CTZN.util.hashCtrl();
  });
}(jQuery));



