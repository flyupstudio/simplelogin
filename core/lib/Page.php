<?

	abstract class Page {
		
		/*
		 * Protected properties
		 */
		protected $Title				= '';
		protected $MetaKeywords			= '';
		protected $MetaDescription		= '';
		protected $CSS					= array();
		protected $JS					= array();
		protected $TemplatesBaseDir		= '';
		protected $ClassName			= '';
		protected $RedirectUrl			= '';
		protected $QueryString			= '';
		protected $RequestUri			= '';
		protected $ProcessEvents		= true;
		protected $UserAccount			= '';
		protected $IsAuthUser			= false;
		protected $Error				= '';
		protected $RootUrl				= '';
		public    $LogError 			= 'a';
		
		/*
		 * Private properties
		 */
		private $SiteConfig				= array();
		protected $Header					= 'header.php';
		protected $Footer					= 'footer.php';
		protected $Template				= '';
		private $Event					= '';
		private $ClearCustomEvent		= false;
		
		
		/*
		 * Public methods
		 */
		
		final public function __construct() {
			
			$this->_load_config();
			$this->_process_events($this->Event);
		}
		
		public function ValidEmail($email) {
			
			return eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", $email);
		}
		
		public function SendAjaxHeaders() {
			
			header('Content-Type: text/html; charset='.$this->GetConfigParam('charset'));
		}
		
		public function GoToUrl($location) {
			//echo $location;
			
			header('Location: '.$location);
			exit;
		}
		
		public function GoTo404() {
			//header('Status: 404 Not Found');
			header("HTTP/1.0 404 Not Found");
			$this->TemplatesBaseDir = '';
			// $this->SetHeader('');
			$this->SetHeader('header.php');
			// $this->SetFooter('');
			$this->SetFooter('footer.php');
			$this->SetTitle("{[404]}");
			$this->Breadcrumbs[] = array('url' => '', 'title' => 'ОШИБКА 404');
			$this->SetTemplate("404.html");
		}
		
		public function GetConfigParam($name){ 
			
			return $this->SiteConfig[$name];
		}
		
		public function SetHeader($filename) {
			
			$this->Header = $filename;
		}
		
		public function SetFooter($filename) {
			
			$this->Footer = $filename;
		}
		
		public function SetTemplate($filename) {
			
			$this->Template = $filename;
		}
		
		public function AddTitle($title) {
			
			if($title)
				$this->Title = $title.( $this->Title ? ' - '.$this->Title : '');
		}
		
		public function SetTitle($title) {
			
			$this->Title = $title;
		}

		public function GetTitle() {
			
			return $this->Title;
		}
		
		public function SetMetaKeywords($meta_keywords) {
			
			$this->MetaKeywords = $meta_keywords;
		}
		
		public function GetMetaKeywords() {
			
			return $this->MetaKeywords;
		}
		
		public function SetMetaDescription($meta_description) {
			
			$this->MetaDescription = $meta_description;
		}
		
		public function GetMetaDescription() {
			
			return $this->MetaKeywords;
		}
		
		public function CryptPassword($password) {
			
			return md5($password);
		}
		
		public function SetError($error) {
			
			$this->Error = $error;
		}
		
		public function GetError() {
			
			return $this->Error;
		}
		
		public function AttachComponent($component_name, &$obj) {
			
			$theme = $this->GetConfigParam('theme');
			$path = PATH_COMPONENTS.$theme.'/'.$component_name.'/';
			
			require_once PATH_LIB.'Component.php';
			require_once $path.$component_name.'.php';
			
			$code = '$obj = new '.$component_name.'(\''.$theme.'\');';
			eval($code);
			
			$src = $obj->GetSrc();
			
			/*
			 * Add Component's CSS
			 */
			$css = $src.'css/'.$component_name.'.css';
			if(!in_array($css, $this->CSS)) {
				
				$this->AddCSS($css);
			}
			
			/*
			 * Add Component's JavaScript
			 */
			$js = $src.'js/'.$component_name.'.js';
			if(!in_array($js, $this->JS)) {
				
				$this->AddJS($js);
			}
		}
		
		public function AddCSS($filename) {
			
			array_push($this->CSS, $filename);
		}
		
		public function AddJS($filename) {
			
			array_push($this->JS, $filename);
		}
		
		public function EncodeUrlParam($param) {
			
			return base64_encode(serialize($param));
		}
		
		public function DecodeUrlParam($param) {
			
			return unserialize(base64_decode($param));
		}
		
		public function GenRandomString($length = 32) {
			
			$res = '';
			
			for($i = 0; $i < $length; $i++) {
				
				if(rand(0, 1)) {
					
					//0 - 9
					$res .= chr(rand(48, 57));
				}
				else {
					//a - z
					$res .= chr(rand(97, 122));
				}
			}
			
			return $res;
		}
		
		public function json_safe_encode($var){
	    	return json_encode($this->json_fix_cyr($var));
		}
	
		protected function json_fix_cyr($var){
		    if (is_array($var)) {
		        $new = array();
		        foreach ($var as $k => $v) {
		            $new[$this->json_fix_cyr($k)] = $this->json_fix_cyr($v);
		        }
		        $var = $new;
		    } elseif (is_object($var)) {
		        $vars = get_class_vars(get_class($var));
		        foreach ($vars as $m => $v) {
		            $var->$m = $this->json_fix_cyr($v);
		        }
		    } elseif (is_string($var)) {
		        $var = iconv(DEFAULT_CHARSET, 'utf-8', $var);
		    }
		    return $var;
		}
		/*
		 * Events
		 */
		
		public function OnDisplay() {
			
			if($this->Header) {
				require_once PATH_HTML_TEMPLATES.$this->Header;
			}
			
			require_once PATH_HTML_TEMPLATES.$this->TemplatesBaseDir.$this->Template;
			
			if($this->Footer){
				
				require_once PATH_HTML_TEMPLATES.$this->Footer;
			}
		}
		
		
		/*
		 * Protected methods
		 */
		
		protected function _load_config() {
			
			global $config, $IsAzone;
			$this->SiteConfig = $config;
			
			$this->ClassName = get_class($this);
			$this->RedirectUrl = $_SERVER['REDIRECT_URL'];
			$this->QueryString = $_SERVER['QUERY_STRING'];
			$this->RequestUri = $_SERVER['REQUEST_URI'];
			
			
				
			$auth_data = $this->GetConfigParam('auth');
			$this->RootUrl = $this->GetConfigParam('site_url');
			if($_SESSION[$auth_data['session']]){
				$this->UserAccount = $_SESSION[$auth_data['session']];
				
			}elseif($_COOKIE[md5("asd")]){
				$array = base64_decode($_COOKIE[md5("asd")]);
				$array = unserialize($array);
				
				$_SESSION['user_account'] = $array;
				$this->UserAccount = $_SESSION['user_account'];
			}
				
			
			$this->Event = $_REQUEST['Event'];
			if($_SESSION['Event']){
				$this->Event = $_SESSION['Event'];
				unset($_SESSION['Event']);
			}
		}
		
		protected function _process_events($event = '') {
			
			$this->_execute_method('OnBeforeCreate');
			
			if($this->ProcessEvents) {
				$this->_execute_method('OnCreate');
				
				$method = 'On'.$event;
				if(!$this->ClearCustomEvent && $event && method_exists($this, 'On'.$event)) {
					
					$this->_execute_method($method);
				}
				else {
					
					$this->_execute_method('OnDefault');
				}
				
				$this->_execute_method('OnBeforeDisplay');
			}
			
			$this->_execute_method('OnDisplay');
		}
		
		protected function _execute_method($method) {
			
			if(method_exists($this, $method)) {
				
				call_user_func(array($this, $method));
			}
		}
		
		protected function _clear_event() {
				
			$this->ClearCustomEvent = true;
		}
	}

?>