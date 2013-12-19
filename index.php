<?php
  include 'config.php';
  include 'vendor/erusev/parsedown/Parsedown.php';
  include 'vendor/leafo/scssphp/scss.inc.php';
  include 'src/yss/YSS.php';
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="css/yss.css">

    <style>
      <?php include 'src/yss/style-nester.php'; ?>
    </style>

  </head>
  <body>

    <div id="yss-navigation-container" class="yss-navigation-container">
      <nav id="yss-navigation" class="yss-navigation">
        <ul>
          
        </ul>
      </nav>
    </div>

    <div id="yss-container" class="yss-container">
      <?php 
        foreach ($cssSources as $cssSource) {
          printStyleguide($cssSource);
        }
      ?>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="vendor/component/jquery/jquery.min.js"><\/script>')</script>
    
    <script src="js/vendor/rainbow.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
