<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Урок 2 Задание 1 </title>
</head>
<body>
  <script>
    'use strict'
    function printNamePhones(phones) {
      var list = document.getElementById('list_phones');
      var ul = document.createElement('ul');
      phones.forEach(function(item) {
        var li = document.createElement('li');
        li.innerHTML = item.name;
        ul.appendChild(li);
      });
      list.appendChild(ul);
    };

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'phones.json', true);
    xhr.send();
    xhr.onreadystatechange = function() {
      if (xhr.readyState != 4) return;
      if (xhr.status != 200) {
        alert(xhr.status + ': ' + xhr.statusText);
      } else {
         printNamePhones(JSON.parse(xhr.responseText));
        };
    };
  </script>

  <div id = "list_phones"> </div>

</body>
</html>