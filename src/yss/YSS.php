<?php

#
# Return string between 2 flag
#
function getBetween($content,$start,$end){
  $into = array();
  $startingArray = explode($start, $content);
  if (isset($startingArray[1])){
    foreach ($startingArray as $key => $value) {
      $endingArray = explode($end, $startingArray[$key]);
      array_push($into, $endingArray[0]);
    }
  }
  return $into;
}

#
# Cut and parse CSS comments to create the styleguide
#
function printStyleguide($src){
  $pathRaw = explode("/", $src);
  $path = str_replace(end($pathRaw), "", implode("/", array_slice($pathRaw, 0)));
  $pathWithoutCSS = str_replace("css/", "", $path);
  $cssRaw = str_replace('src="../', 'src="'.$pathWithoutCSS, file_get_contents($src));
  $cssComment = getBetween($cssRaw,'/*','*/');

  foreach ($cssComment as $key => $content) {
    $content = str_replace("\n  #", "\n#", $content);
    $code = explode('````', $content);

    if(isset($code[1])){
      foreach ($code as $keyCode => $codeContent) {
        if($keyCode&1){
          // snippet preview
          echo '<div class="yss-include">'.$codeContent.'</div>';

          //$result = Parsedown::instance()->parse('````'.$codeContent.'````');
          echo '<pre><code data-language="html">'.$codeContent.'</code></pre>';
        }else {
          $result = Parsedown::instance()->parse($codeContent);
          if(strlen($result) > 10){
            echo '<div class="yss-content">'.$result.'</div>';
          }
        }
      }
    }else{
      $result = Parsedown::instance()->parse($content);
      if(strlen($result) > 15){
        echo '<div class="yss-content">'.$result.'</div>';
      }
    }
  }
}

?>


