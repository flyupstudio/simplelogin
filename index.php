<?
	
	$RootPath = './';
	$AuthRequire = false;
	$IsAzone = false;
	
	ini_set('display_errors',0);
	error_reporting(NULL);
	
	header("Content-type: text/html; charset=utf-8");
	$url_parts = explode('/', $_SERVER['REQUEST_URI']);
	$module_name = $url_parts[1];

	switch($module_name) {
	
		default:
			$AuthRequire = true;
			$ClassName = 'FrontPage';
			break;
		
			
	}
	
	require_once $RootPath.'core/initialize.php';
?>
