<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Урок 4 </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <style>
   
  </style>
</head>
<body>
  <form id="form">
    <label> Логин </label> <br>
    <input type="text" name="username" placeholder="min 6 and max 100 simbols"> <br>
    <label> Пароль </label> <br>
    <input type="password" name="password" placeholder="min 6 and max 100 simbols"> <br>
    <label> Электронная почта </label> <br>
    <input type="email" name="email" placeholder="some@some.ru"> <br>
    <label> Пол </label> <br>
    <input type="text" name="gender" placeholder="M"> <br>
    <label> Номер банковской карты </label> <br>
    <input type="text" name="credit_card" placeholder="9872389-2424-234224-234"> <br>
    <label> Дата рождения </label> <br>
    <input type="text" name="birth" placeholder="yyyy-mm-dd"> <br>
    <label> Краткая биография </label> <br>
    <textarea name = "bio" rows="5" cols="20"> </textarea> <br>
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
        });
        $.ajax ({
          url: 'validator.php',
          type: 'POST',
          data: dataout,
          dataType: 'json',
          success: function(data) {
            console.log(data.result ? 'Form is validate' : data.error);
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