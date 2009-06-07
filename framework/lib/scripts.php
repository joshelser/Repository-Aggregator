<?php

function scripts( $js = '' ) {
  require_once( 'lib/functions.lib.php' );
  $framework = frameworkDir();
	if( $js != '' ){
		return <<<EOT
<script src="{$framework}/scripts/script.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/jquery/jquery.min.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/jquery/jquery.pagination.js" language="javascript" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
	{$js}
</script>
EOT;
	}

  return <<<EOT
<script src="{$framework}/scripts/script.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/jquery/jquery.min.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/jquery/jquery.pagination.js" language="javascript" type="text/javascript"></script>
EOT;

	
    /*
  include relative_address().'/'.frameworkDir().'/scripts/goHome.js';
  include relative_address().'/'.frameworkDir().'/scripts/script.js';*/
}

?>
