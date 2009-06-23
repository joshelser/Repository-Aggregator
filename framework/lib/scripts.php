<?php

function scripts( $js = '' ) {
  require_once( 'lib/functions.lib.php' );
  $framework = frameworkDir();

	$return = '';
	if( preg_match( '/index.php$/', this_page() ) ) {
		$return .= <<<EOT
<script src="{$framework}/scripts/jquery/jquery.min.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/jquery/jquery.pagination.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/paginationFrontPage.js" language="javascript" type="text/javascript"></script>
EOT;
	}

	if( preg_match( '/viewCommits\.php$/', this_page() ) ){ 
		$return .= <<<EOT
<script src="{$framework}/scripts/jquery/jquery.min.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/jquery/jquery.pagination.js" language="javascript" type="text/javascript"></script>
<script src="{$framework}/scripts/pagination.js" language="javascript" type="text/javascript"></script>
EOT;
	}

	$return .= '<script src="'.$framework.'/scripts/script.js" language="javascript" type="text/javascript"></script>';

	if( $js != '' ){
		$return .= <<<EOT
<script type="text/javascript" language="javascript">
	{$js}
</script>
EOT;
	}


	return $return;
	
    /*
  include relative_address().'/'.frameworkDir().'/scripts/goHome.js';
  include relative_address().'/'.frameworkDir().'/scripts/script.js';*/
}

?>
