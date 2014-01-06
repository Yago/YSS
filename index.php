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
    <title>YSS : Yago Style Sheet</title>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="css/yss.css">

    <style>
      <?php include 'src/yss/style-nester.php'; ?>
    </style>

  </head>
  <body>

    <header id="yss-header" class="yss-header">
      <a href="#" id="yss-show-nav" class="yss-show-nav">
        <span></span>
        <span></span>
        <span></span>
      </a>
      <img id="yss-logo" src="img/yss.svg" onerror="this.onerror=null; this.src='img/yss.png'" alt="YSS" />
    </header>

    <div id="yss-container" class="yss-container">
      <?php 
        foreach ($cssSources as $cssSource) {
          printStyleguide($cssSource);
        }
      ?>
    </div>

    <div id="yss-navigation-container" class="yss-navigation-container">
      <div class="yss-navigation-wrapper">
        <nav id="yss-navigation" class="yss-navigation">
          <ul>
            
          </ul>
        </nav>
      </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="vendor/component/jquery/jquery.min.js"><\/script>')</script>    
    <script src="vendor/ccampbell/rainbow/js/rainbow.min.js"></script>
    <script src="vendor/ccampbell/rainbow/js/language/html.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
