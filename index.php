<?php

/* 
@Author - JadeWizard
@Blog - Jade-Wizard.ru
@Name - WikiToHtml
@Version - 0.1
@Git - https://github.com/jade58/wth
*/

ini_set('display_errors', 1); //Отображение ошибок
error_reporting(E_ALL);  //Отображение ошибок

require_once 'functions.php'; //Подключаем файл с функциями

$url = $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']; //URL

if ((!isset($_COOKIE['token'])) and isset($_GET['code'])) {
$token = get_token($_GET['code'],$url); //Запиешм результат работы функции GET_TOKEN

setcookie('token', $token, time() + 3600);
setcookie('user_id', $user_id, time() + 3600);

header("Location: http://".$url.""); //Что бы кукисы обновились

} else if (isset($_COOKIE['token'])) {

  $token = $_COOKIE['token']; 
  $user_id = $_COOKIE['user_id'];

}

if (isset($_GET['logout'])) {
logout (); //Выходим
}

if ((isset($_GET['url'])) and isset($_COOKIE['token'])) {

    str_exp($_GET['url']); // Разделяем URL

}

?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="s_content">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Wiki To Html</a>
          </div>

          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

            </ul>

            <ul class="nav navbar-nav navbar-right">
              <?php
              if (!isset($_COOKIE['token'])) {
                echo '<li><a href="https://oauth.vk.com/authorize?client_id=4950563&scope=128&redirect_uri=http://'.$url.'&response_type=code">Авторизация</a></li>';
              } else {
                echo '<li><a href="#">Привет, '.get_name($user_id).'</a></li>';
                echo '<li><a href="'.$_SERVER['SCRIPT_NAME'].'?logout=1">Выход</a></li>';
              }
              ?>
            </div>
          </div>
        </nav>

        <div class="row">

          <div class="col-md-3">      
           <div class="panel panel-default">
            <div class="panel-heading">Параметры</div>
            <div class="panel-body">
              <form method="get" action="index.php">

               <div class="form-group">
                 <label class="control-label" for="focusedInput">URL страницы</label>
                 <input class="form-control" id="focusedInput" name="url" type="text">
               
               <br>

               <label>
                 <input type="radio" name="select" value="1">
                   HTML
               </label>
               <label>
                 <input type="radio" name="select" value="2">
                   WIKI
               </label>

               </div>
               

               <input class="btn btn-default" type="submit" value="Получить код">

             </form>
           </div>
         </div>

         <div class="panel panel-default">
          <div class="panel-heading">Контакты</div>
          <div class="panel-body">

          </div>
        </div>
      </div>


   <div class="col-md-9"> <div class="well">

        <div class="form-group">


          <?php
            
            if (isset($_COOKIE['token'])) {

              if (isset($_GET['url'])) {
                   
                  echo '<textarea class="form-control" rows="20" id="textArea">';

                  $select = $_GET['select'];

                     echo get_html($token,$select); //Вызываем функцию и получаем код HTML

                  echo '</textarea>';

              } else {
                echo "<blockquote>Введите URL</blockquote>";
              }

            } else {
              echo "<blockquote>Авторизируйтесь!</blockquote>";
            }

          ?>

        </div>

      </div></div>
    </div>

  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <scri