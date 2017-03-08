'use strict';
$(document).ready(function() {
  (function($) {
    $('li').click(function (event) {
      $('li.active_li').addClass('disactive_li').removeClass('active_li');
      $('#'+this.id).addClass('active_li').removeClass('disactive_li');
      $('.active_text').addClass('disactive_text').removeClass('active_text');
      $('.tabs ul ~ div').eq(this.id).addClass('active_text').removeClass('disactive_text');
    });
  })(jQuery);
})