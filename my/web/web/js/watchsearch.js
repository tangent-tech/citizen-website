
var WatchSearch = WatchSearch || {};
;(function($, undefined) {
  WatchSearch = (function() {
    var currentIndex = 0,
    tagTemplate = '<li class="termsTable_selectCategory_item"><a href="javascript:;" class="js-tag" data-index="<%= option-index %>" data-parent-index="<%= option-parent-index %>"><span><%= option-param %></span></a></li>',
    tagRect = {t: 8, l: 8, w: 86, h: 60},
    settings = function(){
      if(!$.fn.magnificPopup) return;
      defaultSetting();
      attachUIEvent();
    },
    defaultSetting = function(){
      $('#js-modalPopup').children('div').each(function(i){
        $(this).attr('data-index', i).css({'display':'none'});
      });
      $('.js-openModal').each(function(i){
        $(this).attr('data-index', i);
      });
    },
    putChipsByChecks = function(){
      $('.js-openModal').each(function(i){
        $('.js-optionWrap').children('li').eq(i).find('.js-params').children().remove();
        $('#js-modalPopup').children('div[data-index]').eq(i).find('input').each(function(j){
          if($(this).prop('checked')){
            var q = $(this).next('label').attr('data-tag-name').replace(/\\n/gim,'<br>');
            var c = tagTemplate.replace(/\<\%\=\soption\-param\s\%\>/, q).replace(/\<\%\=\soption\-index\s\%\>/ , j).replace(/\<\%\=\soption\-parent\-index\s\%\>/ , i);
            $('.js-optionWrap').children('li').eq(i).find('.js-params').append(c);
          }
        });
      });
      resetHeight();
    },
    displaySelectedAlert = function(b){
      $('.termsTable_noSelect').css({'display': !b ? 'table' : 'none'});
    },
    displayCurrent = function(n){
      $('#js-modalPopup').children('div').css({'display':'none'});
      $('#js-modalPopup').children('div[data-index=' + n + ']').css({'display':'block'});
    },
    checkSyncByTag = function(n, m){
      $('#js-modalPopup').children('div[data-index=' + m + ']').find('input').eq(n).prop('checked', false);
    },
    resetHeight = function(){
      var maxHeight = -1;
      $('.js-params').each(function(i){
        $(this).find('.termsTable_selectCategory_item').each(function(j){
          maxHeight = maxHeight <= j ? j:maxHeight;
          $(this).css({'top': tagRect.t + (tagRect.h + tagRect.t) * j})
        });
      });
      if(maxHeight >= 0){
        $('.termsTable_selectCategory').css({'display':'block', 'height': tagRect.t + (tagRect.h + tagRect.t) * (maxHeight + 1)});
      }else{
        $('.termsTable_selectCategory').css({'display':'none', 'height': 0});
      }
      displaySelectedAlert($('#js-modalPopup').find('input:checked').length > 0);
    },
    attachUIEvent = function(){
      $('.js-openModal').on('click.o', function(){
        displayCurrent($(this).attr('data-index'));
      });
      $('.js-openModal').magnificPopup({
        type: 'inline',
        midClick: true,
        callbacks: {
          open: function() {
          },
          close: function() {
            putChipsByChecks();
          }
        }
      });
      $('#js-modalPopup').on('click.o', '.js-closeModal', function(){
        $.magnificPopup.close();
        return;
      })
      $('.js-optionWrap').on('click.o', '.js-tag', function(){
        if(!$(this).parent().hasClass('undock')){
          $(this).parent().addClass('undock');
          checkSyncByTag($(this).attr('data-index'), $(this).attr('data-parent-index'));
          var self = $(this).parent();
          var stid = setTimeout(function(){
            self.remove();
            resetHeight(true);
          }, 150)
        }
        return;
      })
    };
    return {
      init: function(){
        settings();
      }
    }
  }());
  $(function() {
    WatchSearch.init();
  });
}(jQuery));



