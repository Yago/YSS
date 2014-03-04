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
# Parse content
#
function yssParsedown ($content) {
  $parsedownContent = '';

  $result = Parsedown::instance()->parse($content);
  if(strlen($result) > 15){
    $parsedownContent .= '<div class="yss-content">'.$result.'</div>';
  }

  return $parsedownContent;
}



#
# Cut and parse CSS comments to create the one page styleguide
#
function yssOnePage ($content) {
  $onePageContent = '';

  $snippets = explode('````', $content);
  if(isset($snippets[1])){
    foreach ($snippets as $keyCode => $snippetContent) {
      if(($keyCode%2) != 0){

        // snippet preview
        $onePageContent .= '<div class="yss-include">'.$snippetContent.'</div>';

        //$result = Parsedown::instance()->parse('````'.$snippetContent.'````');
        $onePageContent .= '<pre><code data-language="html">'.$snippetContent.'</code></pre>';

      }else {
        $onePageContent .= yssParsedown($snippetContent);
      }
    }
  }else{
    $onePageContent .= yssParsedown($content);
  }

  return $onePageContent;
}




#
# Cut and parse CSS comments to create the homepage styleguide
#
function yssMultiHome ($content, $currentUrl) {
  $multiHomeContent = '';

  $contentCut = preg_split('/^#[^#].*/m', $content);
  $contentMatch = array();
  $contentCutRecover = preg_match_all('/^#[^#].*/m', $content, $contentMatch);

  foreach ($contentMatch[0] as $key => $value) {
    $name = str_replace('#', '', $value);
    $slug = strtr(strtolower($name), array(' '=>'', '/'=>'', '-'=>''));
    if ($key >= 1) {
      $multiHomeContent .= '<a href="'.$currentUrl.'?page='.$slug.'">'.$name.'</a><br>';
    }else {
      $multiHomeContent = yssParsedown($contentCut[$key]);
    }
  }

  return $multiHomeContent;
}


#
# Cut and parse CSS comments to create the first level page of the styleguide
#
function yssMultiFirstLevel ($content, $currentUrl, $currentPage, $depth) {
  $multiFirstLevelContent = '';

  $contentCut = preg_split('/^#[^#].*/m', $content);
  $contentMatch = array();
  $contentCutRecover = preg_match_all('/^#[^#].*/m', $content, $contentMatch);
  foreach ($contentMatch[0] as $key => $value) {
    $name = str_replace('#', '', $value);
    $slug = strtr(strtolower($name), array(' '=>'', '/'=>'', '-'=>''));
    if ($slug == $currentPage) {
      $multiFirstLevelContent .= '<div class="yss-content"><h1>'.$name.'</h1></div>';
      if ($depth > 1 && preg_match('/^##[^#].*/m', $contentCut[$key+1])) {
        $subContentCut = preg_split('/^##[^#].*/m', $contentCut[$key+1]);
        $subContentMatch = array();
        $subContentCutRecover = preg_match_all('/^##[^#].*/m', $contentCut[$key+1], $subContentMatch);
        foreach ($subContentMatch[0] as $subKey => $subValue) {
          $subName = str_replace('#', '', $subValue);
          $subSlug = strtr(strtolower($subName), array(' '=>'', '/'=>'', '-'=>''));
          if ($subKey >= 1) {
            $multiFirstLevelContent .= '<a href="'.$currentUrl.'?page='.$slug.'&subpage='.$subSlug.'">'.$subName.'</a><br>';
          }else {
            $multiFirstLevelContent .= yssParsedown($subContentCut[$subKey]);
          }
        }
      }else {
        $multiFirstLevelContent .= yssOnePage($contentCut[$key+1]);
      }
    }
  }

  return $multiFirstLevelContent;
}



#
# Cut and parse CSS comments to create the second level page of the styleguide
#
function yssMultiSecondLevel ($content, $currentPage, $currentSubPage) {
  $multiSecondLevelContent = '';

  $contentCut = preg_split('/^#[^#].*/m', $content);
  $contentMatch = array();
  $contentCutRecover = preg_match_all('/^#[^#].*/m', $content, $contentMatch);
  foreach ($contentMatch[0] as $key => $value) {
    $name = str_replace('#', '', $value);
    $slug = strtr(strtolower($name), array(' '=>'', '/'=>'', '-'=>''));
    if ($slug == $currentPage) {
      $subContentCut = preg_split('/^##[^#].*/m', $contentCut[$key+1]);
      $subContentMatch = array();
      $subContentCutRecover = preg_match_all('/^##[^#].*/m', $contentCut[$key+1], $subContentMatch);
      //$multiSecondLevelContent .= $name;
      foreach ($subContentMatch[0] as $subKey => $subValue) {
        $subName = str_replace('#', '', $subValue);
        $subSlug = strtr(strtolower($subName), array(' '=>'', '/'=>'', '-'=>''));
        if ($subKey >= 1 && $subSlug == $currentSubPage) {
          $multiSecondLevelContent .= '<div class="yss-content"><h1>'.$subName.'</h1></div>';
          $multiSecondLevelContent .= yssOnePage($subContentCut[$subKey+1]);
        }
      }
    }
  }

  return $multiSecondLevelContent;
}


#
# Init YSS maker
#
function yssIniter($src, $depth, $multi){

  // Get URL parameters -----------------------------------------------------------------
  $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
  $host     = $_SERVER['HTTP_HOST'];
  $script   = $_SERVER['SCRIPT_NAME'];
  $params   = $_SERVER['QUERY_STRING'];
  $currentUrl  = $protocol . '://' . $host . $script;
  $currentPage = '';
  $currentSubPage = '';

  if(isset($_GET["page"]) && !isset($_GET["subpage"])) {
    $currentPage = $_GET["page"];
  }else if (isset($_GET["page"]) && isset($_GET["subpage"])) {
    $currentPage = $_GET["page"];
    $currentSubPage = $_GET["subpage"];
  }

  // Preformat CSS source ---------------------------------------------------------------
  $pathRaw = explode("/", $src);
  $path = str_replace(end($pathRaw), "", implode("/", array_slice($pathRaw, 0)));
  $pathWithoutCSS = str_replace("css/", "", $path);
  $cssRaw = str_replace('src="../', 'src="'.$pathWithoutCSS, file_get_contents($src));
  $cssComment = getBetween($cssRaw,'/*','*/');

  $yssContent = '';

  foreach ($cssComment as $key => $content) {
    if ($multi) {
      $yssContent .= $content;
    }else {
      $yssContent .= yssOnePage($content);
    }
  }

  if (!$params && $multi) {
    $yssContent = yssMultiHome($yssContent, $currentUrl);
  }else if ($params && $currentPage && !$currentSubPage) {
    $yssContent = yssMultiFirstLevel($yssContent, $currentUrl, $currentPage, $depth);
  }else if ($params && $currentPage && $currentSubPage) {
    $yssContent = yssMultiSecondLevel($yssContent, $currentPage, $currentSubPage);
  }

  echo $yssContent;
}




?>


