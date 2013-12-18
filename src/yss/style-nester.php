<?php
  $scss = new scssc();
  $scss->setFormatter("scss_formatter_compressed");
  foreach ($cssSources as $key => $cssSource) {
    echo $scss->compile('
      .yss-include {
        '.file_get_contents($cssSources[$key]).'
      }
    ');
  }
?>