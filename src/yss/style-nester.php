<?php

  #
  # Nest base style into the include class to target the styles.
  #

  $scss = new scssc();
  $scss->setFormatter("scss_formatter_compressed");
  foreach ($cssSources as $key => $cssSource) {
    $pathRaw = explode("/", $cssSource);
    $path = str_replace(end($pathRaw), "", implode("/", array_slice($pathRaw, 0)));
    $pathWithoutCSS = str_replace("css/", "", $path);

    $styleContent = $scss->compile('
      .yss-include {
        '.file_get_contents($cssSources[$key]).'
      }
    ');

    $styleContent = str_replace("url('../", "url('".$pathWithoutCSS , $styleContent);
    $styleContent = str_replace("body", "", $styleContent);
    echo $styleContent;

  }
?>