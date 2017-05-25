
var ProductDetailCtrl = ProductDetailCtrl || {};
;(function($, undefined) {
  ProductDetailCtrl = (function() {
    var startThumbIndex = 0,
    currentIndex = 0,
    cls = 'active',
    settings = function(){
      if(!$.fn.imagezoomsl) return;
      activateZoom();
      defaultSetting();
      setCurrent(startThumbIndex);
      attachUIEvent();
    },
    defaultSetting = function(){
      $('.js-thumbs a.rollover_01').each(function(i){
        $(this).attr('data-index', i).parent().removeClass(cls);
      });
      $('.product_image img').css({'display':'none'});
    },
    activateZoom = function(){
      $('.js-enlarge').imagezoomsl({
        descarea: '.js-zoom-area',
        zoomrange: [3, 3],
        magnifiereffectanimate: 'fadeIn',
        magnifierborder: '1px solid #E0E0E0',
        disablewheel: true
      });
    },
    attachUIEvent = function(){
      $('.js-thumbs a.rollover_01').on('click.o', function(e){
        if(!$(this).parent().hasClass(cls)){
          var n = Number($(this).attr('data-index'), 10);
          removeAllCurrentStatus(function(){
            setCurrent(n);
          });
          setThumbCurrent(n);
        }
        return;
      });
      $('body').on('mousemove.zm',function(e){
        if($(e.target).closest('.product_imageRight').length > 0){
          $('.product_zoomBox').hide();
        } else{
          $('.product_zoomBox').show();
        }
      })
    },
    removeAllCurrentStatus = function(callback){
      $('.js-thumbs').find('.' + cls).removeClass(cls);
      $('.product_image img').eq(currentIndex).fadeOut(70, function(){
        callback();
      })
    },
    setThumbCurrent = function(n){
      if(String(n).match(/^-?[0-9]+$/)){
        $('.js-thumbs a').eq(n).parent().addClass(cls);
      }
    }
    setCurrent = function(n){
      if(String(n).match(/^-?[0-9]+$/)){
        $('.js-thumbs a').eq(n).parent().addClass(cls);
        currentIndex = n;
        $('.product_image img').eq(n).fadeIn(300, function(){
        })
      }
    };
    return {
      init: function(){
        settings();
      },
      getCurrent: function(){
        return currentIndex;
      }
    }
  }());
  $(function() {
    ProductDetailCtrl.init();
    $('.js-openModal').magnificPopup({
      type: 'iframe'
    });
    $('.featureList_item').each(function(){
      if($(this).find('p').length <= 0){
        $(this).contents().wrap('<p/>')
      }
    });
    $('.featureList_item').tile(5);
  });
}(jQuery));



