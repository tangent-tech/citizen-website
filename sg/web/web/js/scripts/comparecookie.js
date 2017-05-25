
var CompareCookieCtrl = CompareCookieCtrl || {};
;(function($){
  if(!$.cookie) return;
  CompareCookieCtrl = (function() {
    var fn = {},
    cookieName = '__ctz_cmp',
    options = {
      expires: 7,
      path: '/'
    },
    disCls = 'disabled',
    maxAmount  = 10,
    balloonCls = '.product_balloon,.lineup_balloon',
    deleteElmFromArray = function (val, arr) {
      var newArr = [], i = 0, l = arr.length;
      for (i = 0; i < l; i++) {
        if (arr[i] !== val) {
          newArr.push(arr[i]);
        }
      }
      return newArr;
    },
    writeCookie = function(val){
      $.cookie(cookieName, val, options);
    },
    readCookie = function(){
      return $.cookie(cookieName);
    },
    setDisabled = function(elm){
      elm.addClass(disCls);
    },
    removeCookie = function(){
      $.removeCookie(cookieName, options);
    },
    pushCookie = function(val){
      var arr = fn.getCookieByArray(), c;
      if(!val) return;
      if(typeof arr !== 'undefined'){
        if($.inArray(val, arr) < 0){
          arr.push(val);
          writeCookie(encodeURIComponent(arr.join(',')));
        }
      } else {
        c = [val].join(',');
        writeCookie(encodeURIComponent(c));
      }
    },
    checkDefaultCookieStatus = function(){
      $('.js-addCompare').each(function(i){
        var p = $(this).closest('.js-itemBox').find('input[name="iid"][type="hidden"]');
        if(p.length === 1){
          var q = p.val(), arr = fn.getCookieByArray();
          if(typeof arr !== 'undefined'){
            if($.inArray(q, arr) >= 0){
              setDisabled($(this));
            }
          }
        }
      });
    },
    getRemaining = function(){
      return maxAmount - fn.getCookieByArray().length;
    },
    showBalloonAddSuccessFailure = function(b, elm){
      if(b){
        elm.parent().prev(balloonCls).find('.js-remain').html(getRemaining());
        elm.parent().prev(balloonCls).find('.limitText').hide();
        elm.parent().prev(balloonCls).find('.numberText').show();
      }else{
        elm.parent().prev(balloonCls).find('.limitText').show();
        elm.parent().prev(balloonCls).find('.numberText').hide();
      }
      elm.parent().prev(balloonCls).stop().show();
      elm.parent().prev(balloonCls).delay(3000).fadeOut(500);
    },
    setUIEvent = function(){
      /* for product detail */
      $('.product_imageRight').on('click.cc', '.js-addCompare', function(){
        if(!$(this).hasClass(disCls)){
          var p = $(this).closest('.js-itemBox').find('input[name="iid"][type="hidden"]');
          if(p.length === 1 && (typeof fn.getCookieByArray() === 'undefined' || fn.getCookieByArray().length <= maxAmount - 1)){
            pushCookie(p.val());
            $(this).addClass(disCls);
            showBalloonAddSuccessFailure(true, $(this));
          }else if(p.length === 1 && fn.getCookieByArray().length > maxAmount  - 1){
            showBalloonAddSuccessFailure(false, $(this));
          }
        }
        return;
      });
      /* for product detail */
      $('.product_imageRight').on('click.cc', '.js-removeCompare', function(){
        var p = $(this).closest('.js-itemBox').find('input[name="iid"][type="hidden"]');
        if(p.length === 1){
          fn.removeValueFromCookie(p.val());
          $(this).closest('.js-itemBox').find('.js-addCompare').removeClass(disCls);
          $(this).closest(balloonCls).stop().fadeOut(500);
        }
        return;
      });
      /* for watchsearch */
      $('.js-displayItem').on('click.cc', '.js-addCompare', function(e){
        if(!$(this).hasClass(disCls)){
          var p = $(this).closest('.js-itemBox').find('input[name="iid"][type="hidden"]');
          if(p.length === 1 &&  (typeof fn.getCookieByArray() === 'undefined' || fn.getCookieByArray().length <= maxAmount - 1)){
            pushCookie(p.val());
            $(this).addClass(disCls);
            showBalloonAddSuccessFailure(true, $(this));
          }else if(p.length === 1 && fn.getCookieByArray().length > maxAmount  - 1){
            showBalloonAddSuccessFailure(false, $(this));
          }
          e.stopPropagation();
          e.preventDefault();
          return;
        } else {
          return true;
        }
      });
      /* for watchsearch */
      $('.js-displayItem').on('click.cc', '.js-removeCompare', function(){
        var p = $(this).closest('.js-itemBox').find('input[name="iid"][type="hidden"]');
        if(p.length === 1){
          fn.removeValueFromCookie(p.val());
          $(this).closest('.js-itemBox').find('.js-addCompare').removeClass(disCls);
          $(this).closest(balloonCls).stop().fadeOut(500);
        }
        return;
      });

    };
    fn = {
      removeValueFromCookie: function(val){
        var arr = fn.getCookieByArray();
        if(!val) return;
        if(typeof arr !== 'undefined' && arr.length > 1){
          if($.inArray(val, arr) >= 0){
            arr = deleteElmFromArray(val, arr);
            writeCookie(encodeURIComponent(arr.join(',')));
            return val;
          } else {
            return undefined;
          }
        } else if(typeof arr !== 'undefined' && arr.length == 1){
          if($.inArray(val, arr) >= 0){
            removeCookie();
            return val;
          } else {
            return undefined;
          }
        }
      },
      getCookieByArray: function(){
        var r = readCookie();
        return typeof r === 'undefined' ? [] : decodeURIComponent(r).split(',');
      },
      setCookieByArray: function(arr){
        if(Object.prototype.toString.call(arr) === '[object Array]'){
          if(arr.length > 0){
            fn.setCookie(arr.join(','));
          }else{
            removeCookie();
          }
        }
      },
      removeElement: function(val){
        if(typeof val === 'string'){
          fn.removeValueFromCookie(val);
        }
      },
      removeAllElement: function(){
        removeCookie();
      },
      startAddCompare: function(){
        setUIEvent();
        checkDefaultCookieStatus();
      },
      checkDefault: function(){
        checkDefaultCookieStatus();
      },
      getCookie: function(){
        return decodeURIComponent(readCookie());
      },
      setCookie: function(val){
        if(typeof val === 'string'){
          writeCookie(encodeURIComponent(val));
        }
      },
      getMaxAmount: function(){
        return maxAmount;
      },
      setMaxAmount: function(n){
        if(String(n).match(/^-?[0-9]+$/) && n !== 0){
          maxAmount = n;
          return maxAmount;
        } else {
          return undefined;
        }
      }
    };
    return fn;
  }());
  $(function() {
    CompareCookieCtrl.startAddCompare();
  });
}(jQuery));



