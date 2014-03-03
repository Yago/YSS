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
# Cut and parse CSS comments to create the one page styleguide
#
function yssOnePage($src){
  $pathRaw = explode("/", $src);
  $path = str_replace(end($pathRaw), "", implode("/", array_slice($pathRaw, 0)));
  $pathWithoutCSS = str_replace("css/", "", $path);
  $cssRaw = str_replace('src="../', 'src="'.$pathWithoutCSS, file_get_contents($src));
  $cssComment = getBetween($cssRaw,'/*','*/');

  $yssContent = '';

  foreach ($cssComment as $key => $content) {
    $codes = explode('````', $content);

    if(isset($codes[1])){
      foreach ($codes as $keyCode => $codeContent) {
        if(($keyCode%2) != 0){
          // snippet preview
          $yssContent .= '<div class="yss-include">'.$codeContent.'</div>';

          //$result = Parsedown::instance()->parse('````'.$codeContent.'````');
          $yssContent .= '<pre><code data-language="html">'.$codeContent.'</code></pre>';
        }else {
          $result = Parsedown::instance()->parse($codeContent);
          if(strlen($result) > 10){
            $yssContent .= '<div class="yss-content">'.$result.'</div>';
          }
        }
      }
    }else{
      $result = Parsedown::instance()->parse($content);
      if(strlen($result) > 15){
        $yssContent .= '<div class="yss-content">'.$result.'</div>';
      }
    }
  }

  echo $yssContent;
}

#
# Cut and parse CSS comments to create the multi-pages styleguide
#

function yssMultiPage($src, $depth){

  // Revert depth order
  $depthArr = array();
  for ($i=1; $i <= $depth; $i++) { array_push($depthArr, $i); }

  $pathRaw = explode("/", $src);
  $path = str_replace(end($pathRaw), "", implode("/", array_slice($pathRaw, 0)));
  $pathWithoutCSS = str_replace("css/", "", $path);
  $cssRaw = str_replace('src="../', 'src="'.$pathWithoutCSS, file_get_contents($src));
  $cssComment = getBetween($cssRaw,'/*','*/');

  $yssContent = '';
  $markdownContent = '';

  foreach ($cssComment as $key => $content) {
    $markdownContent .= $content;
  }

  foreach ($depthArr as $key => $value) {
    $hashtag = str_repeat('#', $value);
    $markdownCut = preg_split('/^#[^#].*/m', $markdownContent);
    $match = array();
    $markdownUnCut = preg_match_all('/^#[^#].*/m', $markdownContent, $match);
    foreach ($markdownCut as $key => $value) {
      $index = $key - 1;
      if ($index >= 0) {
        echo '<h1>'.$match[0][$index].'</h1>';
        echo '<div style="border:1px solid red;margin: 30px 0;">'.$value.'</div>';
      }else {
        echo '<div style="border:1px solid red;margin: 30px 0;">'.$value.'</div>';
      }
    }
  }











}

?>


