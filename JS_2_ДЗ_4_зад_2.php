<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Урок 4 </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <style>
    .green {
      border: 2px solid green;
    }
    .red {
      border: 2px solid red;
    }
  </style>
</head>
<body>
  <form id="form">
    <label> Логин </label> <br>
    <input type="text" name="Username" placeholder="min 6 and max 100 simbols"> <br>
    <label> Пароль </label> <br>
    <input type="password" name="Password" placeholder="min 6 and max 100 simbols"> <br>
    <label> Электронная почта </label> <br>
    <input type="email" name="Email" placeholder="some@some.ru"> <br>
    <label> Пол </label> <br>
    <input type="text" name="Gender" placeholder="M"> <br>
    <label> Номер банковской карты </label> <br>
    <input type="text" name="Credit_Card" placeholder="9872389-2424-234224-234"> <br>
    <label> Дата рождения </label> <br>
    <input type="text" name="Birth" placeholder="yyyy-mm-dd"> <br>
    <label> Краткая биография </label> <br>
    <textarea name = "Bio" rows="5" cols="20"> </textarea> <br>
    <button id = "btn_form"> Отправить </button>
  </form>
  <script>
    'use strict';
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
                (this.name in data.error) ? $(this).addClass('red') : $(this).addClass('green');
              } else $(this).addClass('green');
            })
          },
          error: function(xhr, status, error) {
            console.log(xhr.responseText + '|\n' + status + '|\n' + error);
          }
        })
      })
    })(jQuery);
  </script>
</body>
</html>