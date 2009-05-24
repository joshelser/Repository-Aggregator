<?php

function scripts() {
  require_once( 'lib/functions.lib.php' );
  $framework = frameworkDir();

  return <<<EOT
<script src="{$framework}/scripts/script.js" language="javascript" type="text/javascript"></script>
EOT;
    /*
  include relative_address().'/'.frameworkDir().'/scripts/goHome.js';
  include relative_address().'/'.frameworkDir().'/scripts/script.js';*/
}

?>
