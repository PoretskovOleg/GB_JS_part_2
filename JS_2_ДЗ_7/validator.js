'use strict';
$(document).ready(function() {
  (function($) {
    $('#btn_form').click(function(event) {
      event.preventDefault();
      var dataout = {};
      $('#form').find('input, textarea').each(function () {
        dataout[this.name] = $(this).val();
        $(this).removeClass('red').removeClass('green');
      });
      $.ajax ({
        url: 'validator.php',
        type: 'POST',
        data: dataout,
        dataType: 'json',
        success: function(data) {
          console.log(data.result ? 'Form is validate' : data.error);
          $('#form').find('input, textarea').each(function () {
            if (!data.result) { 
              (this.name.replace('_',' ') in data.error) ? $(this).addClass('red') : $(this).addClass('green');
            } else $(this).addClass('green');
          })
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText + '|\n' + status + '|\n' + error);
        }
      })
    })
  })(jQuery);
});