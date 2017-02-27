<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> Урок 2 Задание 3 </title>
  <style>
    .td {                         /*Класс для ячеек основной доски*/
      height: 50px; 
      width: 50px;
      text-align: center;
      border: 1px solid black;
      font-size: 40px;
    }

    .white {                      /*Класс для белых ячеек*/
      background: #ccc;
    }

    .black {                      /*Класс для черных ячеек*/
      background: #222;
    }

    .colorWhite {                 /*Класс для черных фигур*/
      color: white;
      font-weight: bold;
    }

    .colorBlack {                 /*Класс для черных фигур*/
      color: black;
      font-weight: bold;
    }

    .upDownRow {                       /*Класс для верхнего и нижнего поля*/
      height: 20px;
      text-align: center;
      background: lightyellow;
    }

    .firstLastTd {                     /*Класс для левого и правого полей*/
      width: 20px;
      text-align: center;
      background: lightyellow;
    }

    .table {                      /*Класс для таблицы*/
      border: 2px solid black;
      border-collapse:	collapse;
      margin: 50px auto 10px auto;	
    }

    .activeTd {                        /*Класс активности для выделения ячейки*/
      outline: 2px solid blue;        
    }

    .printCoord {                 /*Класс для раздела координат ячеек*/
      font-size: 30px;
      color: blue;
      width: 50px;
      height: 50px;
      margin: 10px auto 10px auto;
    }
    .deleteWhite {                /*Класс для области удаленных белых фигур*/
      background-color: #111;
      width: 800px;
      height: 60px;
      margin: 10px auto 10px auto;
      border: 2px solid blue;
      font-size: 40px;
      color: white;
    }

    .deleteBlack {                /*Класс для области удаленных черных фигур*/
      background-color: #eee;
      width: 800px;
      height: 60px;
      margin: 10px auto 10px auto;
      border: 2px solid blue;
      font-size: 40px;
      color: black;
    }

    .divDelFig {                  /*Класс непосредственно для удаленных фигур*/
      width: 50px;
      height: 50px;
      float: left;
    }
  </style>
</head>
<body>
  <div id="divChess"></div>
  <div class="printCoord"></div>

  <script>
    'use strict';
    /**
     * Базовый класс - рисует шахматную доску размером m*n
     */
    function Board (n,m,idDiv) {
      var table, tr, td;
      var self = this;
      Board.upDownRow = 'upDownRow';
      Board.firstLastTd = 'firstLastTd';
      Board.td = 'td';
      Board.black = 'black';
      Board.white = 'white';
      Board.colorBlack = 'colorBlack';
      Board.colorWhite = 'colorWhite';
      Board.table = 'table';
      Board.activeTd = 'activeTd'

      function upDownRow(m) {                   // Рисуем верхнюю и нижнюю строчки доски 
        tr = document.createElement('tr');      
        for (var j = 0; j < m+2; j++) {         
          td = document.createElement('td');    
          td.innerHTML = self.char[j];               
          td.className = Board.upDownRow;           
          tr.appendChild(td);                   
        }                                       
        table.appendChild(tr);                  
      }
      function firstLastTd(n, i) {              // Рисуем левое и правое поле доски с цифровым обозначением
        td = document.createElement('td');      
        td.innerHTML = n-i;                     
        td.className = Board.firstLastTd;           
        tr.appendChild(td);                     
      }
      /**
       *  Вывод шахматной доски
       */
      this.printChess = function () {      
        table = document.createElement('table');                                          
        upDownRow(m);                                                                     
        for (var i = 0; i < n; i++) {                                                     
          tr = document.createElement('tr');                                              
          firstLastTd(n, i);                                                              
          for (var j = 0; j < m; j++) {                                                    
            td = document.createElement('td');                                            
            td.className = Board.td;
            td.id = self.char[j+1] + (n-i);
            td.classList.add((i+j)%2 ? Board.black : Board.white);
            tr.appendChild(td);                                                           
          }                                                                               
          firstLastTd(n, i);                                                              
          table.appendChild(tr);                                                          
        }                                                                                 
        upDownRow(m);                                                                     
        document.getElementById(idDiv).appendChild(table);                                  
        table.className = Board.table;
      }
    }
      /**
       *  Создаем метод вывода фигур
       */
      Board.prototype.printFigures = function (path) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', path, true);
        xhr.send();
        xhr.onreadystatechange = function() {
          if (xhr.readyState != 4) return;
          if (xhr.status != 200) {
            alert(xhr.status + ': ' + xhr.statusText);
          } else {
              try {
                var data = JSON.parse(xhr.responseText);
                data.forEach(function(item) {
                  var elem = document.getElementById(item.id);
                  elem.innerHTML = item.imageFigure;
                  elem.classList.add(item.color == 'Black' ? Board.colorBlack : Board.colorWhite);
                });
              } catch (e) { console.log('Не корректный формат файла!')}  
            };
        }; 
      };
      /**
       *  Создаем метод удаления фигуры
       */
      Board.prototype.deleteFigures = function (id) {
        var td = document.getElementById(id.toUpperCase());
        td.innerHTML = '';
        td.classList.remove(Board.colorBlack);
        td.classList.remove(Board.colorWhite);
      }
      /**
       *  Создаем метод установки активной ячейки
       */
      Board.prototype.setActiveCell = function (coord) {
        var tds;
        tds = document.getElementsByClassName(Board.activeTd);
        if (tds[0]) tds[0].classList.remove(Board.activeTd);
        document.getElementById(coord.toUpperCase()).classList.add(Board.activeTd);
      }
      /**
       *  Создаем метод вывода координат активной ячейки
       */
      Board.prototype.getActiveCell = function (classDiv) {
        var tds;
        tds = document.getElementsByClassName(Board.activeTd);
        if (tds[0]) {
          var divs = document.getElementsByClassName(classDiv);
          divs[0].innerHTML = tds[0].id
        };
      }
      /**
       *  Создаем метод подписки на события
       */
      Board.prototype.on = function (event, func) {
        var table = document.getElementsByClassName(Board.table);
        table[0].addEventListener(event, func);
      }
    /**
     * Класс конструктор
     */
    function ChessBoard(idDiv) {
      var n=8; 
      var m=8;
      /**
       * Создаем свойства объекта
       */
      this.char = ['', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', ''];
      /**
       * Наследование шахматной доски
       */
      Board.call(this, n, m, idDiv);
    }
    /**
     * Связываем свойства объекта с прототипом
     */
    ChessBoard.prototype = Object.create(Board.prototype);
    ChessBoard.prototype.constructor = ChessBoard;

    var chess = new ChessBoard('divChess');
    chess.printChess();
    chess.printFigures('chessFigures.json');
    chess.setActiveCell('c3');
    chess.getActiveCell('printCoord');

    function activeTd (event) {                              // Обработчик события - делает ячейку активной
      chess.setActiveCell(event.target.id);
    }
    function print() {                                  // Обработчик события - выводит координаты активной ячейки
      chess.getActiveCell('printCoord');
    }
    function delFig (event) {                              // Обработчик события - удаляет фигуру
      chess.deleteFigures(event.target.id);
    }
    chess.on('click', activeTd);
    chess.on('click', print);
    chess.on('click', delFig);
    

  </script>
</body>
</html>