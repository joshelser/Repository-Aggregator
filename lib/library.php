<?php

$addr = address();
$rel_addr = relative_address();

// OB_START
ob_start();

/*
**  S I T E   V A R I A B L E S
*/
$SITE_NAME = 'Site Name';

/*
**   S E S S I O N S
* 		you can add lotsa separate session stuff here
*/
include $rel_addr.'/sessions/session.php';

/*
** I N C L U D E   F I L E S
*/
	// Database Connection
	include $rel_addr.'/lib/mysql_connect.php';
	
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
		return '/var/www';
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
			return '<TITLE>'.$title.' - '.$GLOBALS['SITE_NAME'].'</TITLE>';
		}else{
			return '<TITLE>'.$GLOBALS['SITE_NAME'].'</TITLE>';
		}
	}

	function style ($style){
		$reset 	 = '/style/reset.css';
		$style 	 = '/style/style.css';

		return '
			<link type="text/css" rel="stylesheet" href="'.address().$reset.'">
			<link type="text/css" rel="stylesheet" href="'.address().$style.'">
		';
	}

	function navigation ($nav){
		if(empty($nav)){
			return '
				
				';
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
		
		$return ='
		<html>
		<head>

		'.title($title).'

		'.style($style).'
				
		'.$scripts.'
		
		</head>
		';
		
		echo $return;
	}

function body ($header,$subtitle=' ',$content,$navigation){
		$return .= '
		<body>
		
			<div id="header">
				<div onclick="homeFunction()" id="title">'.headCheck($header).'</div>
				<div id="personal">'.$personal.'</div>
			</div>
			
			<div id="nav">'.navigation($navigation).'</div>
	
			<div id="content">
				<div id="side">
				'.$side.'
				</div>
				<h1>'.$subtitle.'</h1>
				'.$content.'
			</div>
			';
		echo $return;
	}

	function foot ($footer = 'All Rights Reserved',$dbc){
		$date = date("m/d/Y");

			$return = '
			<div id="footer">
			'.$footer.'
			</div>
			
			</body>
	
		
			</html>
			';
		
		echo $return;
		
		ob_end_flush();
		mysql_close($dbc);
	}
	
?>
