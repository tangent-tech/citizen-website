
;(function($, undefined) {
  $(function() {
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
    $('.featureList .featureList_item').tile(2);
    $(window).on('orientationchange.dtl resize.dtl', function(){
      $('.featureList .featureList_item').tile(2);
    });
  });
}(jQuery));



var ProductDetailCtrlSP = ProductDetailCtrlSP || {};
;(function($, undefined) {
  ProductDetailCtrlSP = (function() {
    var startThumbIndex = 0,
    currentIndex = 0,
    cls = 'active',
    slider = undefined;
    fn = {},
    settings = function(){
      defaultSetting();
      setupBxs();
      setCurrent(startThumbIndex);
      attachUIEvent();
    },
    defaultSetting = function(){
      $('.js-thumbs a.productSlider_anc').each(function(i){
        $(this).attr('data-index', i).parent().removeClass(cls);
      });
      $('.product_image img').css({'display':'none'});
    },
    attachUIEvent = function(){
      $('.js-thumbs a.productSlider_anc').on('click.o', function(e){
        if(!$(this).parent().hasClass(cls)){
          var n = Number($(this).attr('data-index'), 10);
          removeAllCurrentStatus(function(){
            setCurrent(n)
          });
          setThumbCurrent(n);
        }
        return;
      });
    },
    removeAllCurrentStatus = function(callback){
      $('.js-thumbs').find('.' + cls).removeClass(cls);
      if(typeof callback === 'function') callback();
    },
    setThumbCurrent = function(n){
      if(String(n).match(/^-?[0-9]+$/)){
        $('.js-thumbs a.productSlider_anc').eq(n).parent().addClass(cls);
      }
    },
    setupBxs = function(){
      slider = $('#js-productSlider').bxSlider({
        onSlideBefore: function(elm, o, n){
          removeAllCurrentStatus(function(){
            setCurrent(n)
          });
        }
      });
    },
    setCurrent = function(n, b){
      if(String(n).match(/^-?[0-9]+$/)){
        $('.js-thumbs a.productSlider_anc').eq(n).parent().addClass(cls);
        if(typeof b === 'undefined') slider.goToSlide(n);
        currentIndex = n;
      }
    };
    fn = {
      init: function(){
        settings();
      },
      getCurrent: function(){
        return currentIndex;
      }
    };
    return fn;
  }());
  $(function() {
   ProductDetailCtrlSP.init();
  });
}(jQuery));



