<?

	/*
	 * Start session
	 */
	
	session_start();

	function _r($str) {
		return trim(str_replace(array("\r", "%", "\n", "\t",),
					array("","%25","%0A","%09"), $str));
	}

	function _t($str){
		//$time = explode(" ",$str);
		//return strtotime($time[0].' '.$time[1]);
		return ($str);
	}
	
	function _s($str) {
		$res = '';
		$res = $str ? $str : '';
		return $res;
	}
	function _debug($array, $exit=0, $name){
		echo "<pre>";
		if($name) echo $name." = ";
		print_r($array);
		echo "</pre>";
		if($exit) exit();
	}
	
	if($ClassName != 'ImageUploader'){
		session_set_cookie_params(60*60*24);
		session_start();
	}
	
    function capitalize_first($str) {
		return $str;       
		/*$line = iconv("UTF-8", "Windows-1251", $str); // convert to windows-1251
        $line = ucfirst($line);
        $line = iconv("Windows-1251", "UTF-8", $line); // convert back to utf-8*/
       
        return $line;
    }

	
	
	//_debug($_SESSION,0);
	
	/*
	 * Define constants
	 */
	define('PATH_CORE', $RootPath.'core/');
	define('PATH_FILEMANAGES', $RootPath.'core/lib/ckfinder/ckfinder.php');
	define('PATH_LIB', $RootPath.'core/lib/');
	define('COMPONENTS_DIR_NAME', 'components');
	define('PATH_COMPONENTS', $RootPath.COMPONENTS_DIR_NAME.'/');
	define('PATH_CLASSES', $RootPath.'sources/classes/');
	define('PATH_HTML_TEMPLATES', 'sources/html_templates/');
	define('PATH_AZONE_CLASSES',  $RootPath.'azone/sources/classes/');
	define('PATH_AZONE_HTML_TEMPLATES', 'azone/sources/html_templates/');
	define('PATH_SNIPPETS', 'sources/html_templates/snippets/');
	define('PATH_MAIL_TEMPLATES', 'sources/mail_templates/');
	define('PATH_PUBLIC_FILES', 'public/files/');
	define('PATH_PUBLIC_FILES_IMAGES', PATH_PUBLIC_FILES.'images/');
	
	
	/*
	 * Include site configuration
	 */
	 
	if($IsAzone){
		require_once PATH_CORE.'../wp-config.php';
	}
	require_once PATH_CORE.'configuration.php';
	
	define('DEFAULT_CHARSET', $config['charset']);
	
	/*
	 * Global functions
	 */
	function AttachLib($name) {		
		require_once PATH_LIB.$name.'.php';
	}
	
	function AttachClass($name,$azone = false){
		global $RootPath;
		require_once $RootPath.($azone ? PATH_AZONE_CLASSES : PATH_CLASSES).$name.'.php';		 
	}
	
	/*
	 * Init ADODB
	 */
   	include PATH_LIB.'adodb/adodb.inc.php';
	$DB = NewADOConnection($config['DB']['type']);
	if($config['DB']['user']){
		$DB->Connect($config['DB']['host'].':'.$config['DB']['port'], $config['DB']['user'], $config['DB']['password'], $config['DB']['database']);
		$DB->SetFetchMode(ADODB_FETCH_ASSOC) ;
	}
	
	/* Databases functions */
	function GetAll($sql, $debug = 0){	
		global $DB;
		if($debug) echo $sql;
		
		return $DB->GetAll($sql);	
	}
	function GetAssoc($sql){	
		global $DB;
		
		return $DB->GetAssoc($sql);	
	}
	
	function GetRow($sql){	
		global $DB;
		
		return $DB->GetRow($sql);	
	}
	function GetOne($sql, $debug = 0){	
		global $DB;
		if($debug) echo $sql;
		
		return $DB->GetOne($sql);	
	}
	
	
	function GetCol($sql){	
		global $DB;
		
		return $DB->GetCol($sql);	
	}
	
	function Execute($sql, $debug = 0){	
		global $DB;
		if($debug) echo $sql;
		set_log($sql, 'db');
		return $DB->Execute($sql);	
	}
	
	function s($string){
		/*if (is_numeric($string) || $string === null || is_bool($string)) {
		  return $string;
		}
		if (get_magic_quotes_gpc()) {
		  $string = stripslashes($string);
		}*/
		return mysql_real_escape_string($string);
	}
	
	function i($param){
		return intval($param);
	}
	
	function f($param){
		return floatval($param);
	}
	
	function array_i($param){
		if (!is_array($param)) return array();
		else{
			foreach($param as &$value){
				$value = intval($value);
			}
			unset($value);
		}	
		return $param;
	}
	
	function d($param){
		return date('d.m.Y',$param);
	}
	function _utf8_wordwrap($str, $width, $break, $cut = false) {
		$str = explode(' ',$str);
		foreach($str as &$s){
			if(mb_strlen($s,'UTF-8')>$width){
				if (!$cut) {
					$regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.',}\b#U';
				} else {
					$regexp = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){'.$width.'}#';
				}
				if (function_exists('mb_strlen')) {
					$str_len = mb_strlen($s,'UTF-8');
				} else {
					$str_len = preg_match_all('/[\x00-\x7F\xC0-\xFD]/', $s, $var_empty);
				}
				$while_what = ceil($str_len / $width);
				$i = 1;
				$return = '';
				while ($i < $while_what) {
					preg_match($regexp, $s,$matches);
					$string = $matches[0];
					$return .= $string.$break;
					$s = substr($s, strlen($string));
					$i++;
				}
				$s = $return.$s;
			}
		}
		unset($s);
		return implode(' ',$str);
		
	}
	
	function money($param){
		return number_format($param,2,'.',' ');
	}
	
	function declOfNum($number, $titles){
		$cases = array (2, 0, 1, 1, 1, 2);
		return $titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
	}
	function m($param){
		return mysql_real_escape_string($param);
	}
	function _generate_SELECT($options = array('name' => '', 'multiple' => '', 'group' => '', 'id' => '', 'class' => '', 'style' => '', 'first_val' => '', 'first_title' => '- Выбрать -', 'elements' => array(), 'selected' => '', 'val' => array('val' => 'id', 'title' => 'title'), 'event' => 'onclick', 'e_func' => '')){
		$select = '	<select '.$options['multiple'].' '.$options['event'].'="'.$options['e_func'].'" name="'.$options['name'].'" id="'.$options['id'].'" class="'.$options['class'].'" style="'.$options['style'].'">';
		if($options['first_val'] !== false){ 
			$select .=	'<option value="'.$options['first_val'].'" >'.$options['first_title'].'</option>';
		}
		if($options['elements'] && is_array($options['elements'])){
			$i = 0;
			foreach ( $options['elements'] as $e ){
				
				if($options['val']){
					$element_value = $e[$options['val']['val']];
					$element_title = $e[$options['val']['title']];				
				}else{
					$element_value = $e;
					$element_title = $e;
				}
				
				if(is_array($options['selected'])){
					$selected = in_array($element_value, $options['selected']) ? 'selected' : '';
				}else{
					$selected = ($element_value == $options['selected']) || ($element_value === $options['selected']) ? 'selected' : '';
				}
				
				if($options['group']){
					if($e['level'] == 0 && $options['elements'][$i+1]['level'] != 0){
						$select.= '<optgroup label="'. $element_title .'"></optgroup>';
					}elseif($options['elements'][$i]['level'] < $options['elements'][$i+1]['level']){
						$select.= '<optgroup label="'. $element_title .'"></optgroup>';
				  	}else{
						$select.= '<option value="'. $element_value .'"'. $selected .'>'. $element_title .'</option>';
				  	}
				}else{								 			
					$select .= '<option '.$selected.' value="'.$element_value.'" >'.$element_title.'</option>';
				}
				$i++;	
			}
		}
		$select .= '</select>';
		
		return $select;
	}	

	
	function _show_IMG( $params = array('img' => '', 'alt' => '', 'src' => '', 'a' => '', 'Tparams' => '' ) ){
		if( $params['img'] ){
			echo ( $params['a'] ? '<a href="'.$params['a'].'" >' : '' ).'<img src="'.( $params['Tparams'] ? '/phpThumb/phpThumb.php?'.$params['Tparams'].'&src=' : '' ).$params['src'].$params['img'].'" alt="'.$params['alt'].'">'.( $params['a'] ? '</a>' : '' );
		}
	}
	
	
	/* Language setup */
	
	if($_GET['language']){	
		$_SESSION['DefaultLanguage'] = $_GET['language'];
		setcookie ("Language",$_GET['language'],time()+60*60*24*30,"/");	
		$url = $_SERVER['REDIRECT_URL']? $_SERVER['REDIRECT_URL']:"/";
		header('Location:'.$url);
		
		//exit();
		
	}
	
	
	/*
	 * Create class instance
	 */
	if(!$AuthRequire) {
		
		$ParentClass = 'Page';
	}
	else {
		$ParentClass = 'AuthPage';
	}

	AttachLib($ParentClass);
	AttachLib('Extend');
	$code = 'abstract class AbstractPage extends '.$ParentClass.' {}; ';
	eval($code);
	
	require_once ($IsAzone ? PATH_AZONE_CLASSES:PATH_CLASSES).'ContentPage.php';
	require_once ($IsAzone ? PATH_AZONE_CLASSES:PATH_CLASSES).$ClassName.'.php';
	
	$code = 'new '.$ClassName.'();';
	
	eval($code);

?>