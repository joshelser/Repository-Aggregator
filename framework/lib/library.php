<?php

$addr = address();
$rel_addr = relative_address() .'/'. Config::get( 'frameworkDirectory' );

// OB_START
ob_start();

/*
**  S I T E   V A R I A B L E S
*/
$SITE_NAME = Config::get( 'siteName'); //'Repository Aggregator';

/*
**   S E S S I O N S
* 		you can add lotsa separate session stuff here
*/
//include $rel_addr.'/sessions/session.php';

/*
** I N C L U D E   F I L E S
*/
// Database Connection
//include $rel_addr.'/framework/lib/mysql_connect.php';

/* User authentication file */
require_once( $rel_addr.'/lib/authentication.php' );

// Header File
include $rel_addr.'/lib/header.php';

// Scripts File
include $rel_addr.'/lib/scripts.php';

// Navigation File
include $rel_addr.'/lib/navigation.php';

// Footer File
include $rel_addr.'/lib/footer.php';


/*
**   M Y S Q L 
*/

function db_connect ($db_url, $db, $user, $pw){
  if($dbc = @mysql_connect($db_url,$user,$pw)){
    if (!@mysql_select_db ($db)){
      return die('<p>Could not select the database because: <B>' . mysql_error() . '');
    }else{
      return $dbc;
    }
  }else{
    return die('<P>Could not connect to the MYSQL because: <B>' . mysql_error() . '');
  }
}

/*
**   P H P
*/
function address (){
  return 'http://'.$_SERVER['SERVER_NAME'].'';
}

function relative_address(){
  // Or whatever your server points to
  return '/var/www/localhost/htdocs/aggregator';
}

// For cheap CSS hacks
// i.e. to change the css file if its IE
function is_ie (){
  //Not Internet Explorer
  if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE') === FALSE) {
    return false;
    //Is Internet Explorer
  }else{
    return true;
  }
}

//Retrieves page's name i.e. index.php
function this_page(){
  return $_SERVER['PHP_SELF'];
}

// Goto if object is clicked
function click_get($var_name, $var){
  return 'OnClick="parent.location=\''.this_page().'?'.$var_name.'='.$var.'\'"';
}

// Refresh if item is selected
function click_refresh($page = 'default'){
  if($page == 'default'){
    return 'OnClick="parent.location=\''.this_page().'\'"';
  }else {
    return 'OnClick="parent.location=\''.$page.'\'"';
  }
}

// Submit form on click
function click_submit(){
  return 'OnClick="this.form.submit()"';
}

// Refresh a page
function refresh ($page = 'none', $dbpage = 'none',$seconds = 0){
  $address = address();
  switch(TRUE){
  case ($page != 'none' && $dbpage != 'none'):
    return header('refresh: '.$seconds.'; url='.$address.$page.'?page='.$dbpage.'');
    break;
  case ($page != 'none'):
    return header('refresh: '.$seconds.'; url='.$address.$page.'');
    break;
  case($dbpage != 'none'):
    return header('refresh: '.$seconds.'; url='.$address.this_page().'?page='.$dbpage.'');
    break;
  case($page == 'none'):
    return header('refresh: '.$seconds.'; url='.$address.this_page().'');
    break;
  }
}

function title ($title){
  if(!empty($title)){
    return '<title>'.$title.' - '.$GLOBALS['SITE_NAME'].'</title>';
  }else{
    return '<title>'.$GLOBALS['SITE_NAME'].'</title>';
  }
}

function style ($style){
  $fnAddress = 'address';
  
  $reset = '/style/reset.css';
  $style = '/style/style.css';
	  
  return <<<EOT
    <link type="text/css" rel="stylesheet" href="{$fnAddress()}$reset" />
    <link type="text/css" rel="stylesheet" href="{$fnAddress()}$style" />
EOT;
}

function navigation ($nav){
  if(empty($nav)){
    return '';
  }else{
    return $nav;
  }
}

function headCheck ($header){
  if(empty($header)){
    return ''.$GLOBALS['SITE_NAME'].'';
  }else{
    return $header;
  }
}
	
/*
**    P A G E 
**      C R E A T I O N
*/
function head ($title, $style, $scripts){
  /* Functions for heredoc */
  $fnTitle = 'title';
  $fnStyle = 'style';
  $fnScripts = 'script';

  $return = <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    {$fnTitle($title)}
{$fnStyle($style)}
  </head>
EOT;

  echo $return;
}

function body( $header,$subtitle=' ', $content, $navigation ){
  /* Functions for heredoc */
  $fnNavigation = 'navigation';
  
  /* HTML output */
  $return = <<<EOT
\n
  <body>
    <div id="header">
      <div id="personal">$personal</div>
    </div>
			
    <div id="nav">
      {$fnNavigation($navigation)}
    </div>
	
    <div id="content">
      <div id="side">
        $side
      </div>

      <h1>$subtitle</h1>
        $content
    </div>
EOT;
  echo $return;
}

function foot( $footer = 'All Rights Reserved' ){
  $return = <<<EOT
\n
    <div id="footer">
$footer
    </div>
			
  </body>
</html>
EOT;
		
  echo $return;
  
  ob_end_flush();
}

?>
