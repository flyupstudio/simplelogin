<?
/*//////////////////////////////////////////////////////////////////////////////
        Azone v2.0
		AuthPage.php
        --------
        Started On:     May 05, 2016
        Copyright:      (C) 2008-2016 FlyUpStudio.
        E-mail:         support@flyupstudio.com.ua
        $Id: AuthPage.php,v 2.0 May 05, 2016 13:21:00 Maxim Exp $
//////////////////////////////////////////////////////////////////////////////*/	

	AttachLib('Page');

	abstract class AuthPage extends Page {
		
		/*
		 * Private properties
		 */
		
		private $AuthData			= array();
		
		

		/*
		 * Events
		 */
		
		public function OnLogin() {
			
			AttachLib('csv');
			
			$CSV = new CsvReader(PATH_CORE.'users-list.csv',":");
			
			$users = array();
			
			foreach ($CSV as $user) {
				
				$finded = $user[0] == trim($_REQUEST[$this->AuthData['f_username']]) && 
							$user[1] == $this->CryptPassword($_REQUEST[$this->AuthData['f_password']]);
							
				
				if($finded){
					$this->UserAccount = array($this->AuthData['f_username'] => $user[0],
												$this->AuthData['f_password'] => $user[1]);
					break;
				}
			}

			$_SESSION[$this->AuthData['session']] = $this->UserAccount;
			
			if ($_REQUEST['remember_me']){
				
				setcookie(md5("asd"),base64_encode(serialize($this->UserAccount)),time()+60*60*24*365);
				
			}
			


			if(!$this->_is_auth_user()) {
				$this->SetError($this->AuthData['error']);
			}
			elseif($_REQUEST[$this->AuthData['f_redirect']]) {	
				$this->GoToUrl($this->DecodeUrlParam($_REQUEST[$this->AuthData['f_redirect']]));
			}
		}
		
		
		
		public function OnLogout() {
			global $IsAzone;
			
			unset($this->UserAccount);
			unset($_SESSION[$this->AuthData['session']]);
			unset($_SESSION['Trash']);
			
			
			setcookie(md5("asd"),"",time()-60*60,"/");
			
			if($_REQUEST[$this->AuthData['f_redirect']]) {
				$this->GoToUrl($this->DecodeUrlParam($_REQUEST[$this->AuthData['f_redirect']]));
			}
		}
		

		/*
		 * Private methods
		 */
		
		private function _is_auth_user() {
			global $IsAzone;
			
			if(is_array($this->UserAccount) && count($this->UserAccount) > 0) {
				
				$this->IsAuthUser = true;
			}
			else {
				
				$this->IsAuthUser = false;
				if(!$IsAzone){
					$this->AuthData = $this->GetConfigParam('auth');
					
				}else{
					$this->AuthData = $this->GetConfigParam('azone_auth');
				}
				$this->TemplatesBaseDir = '';
			}
			
			
			return $this->IsAuthUser;
		}
		
		private function _load_auth_data() {
										
			
			$this->AuthData = $this->GetConfigParam('auth');
			
		}
		
		
		/*
		 * Protected methods
		 */
		
		protected function _process_events($event) {
			global $IsAzone;
			
			if($event == 'Login' || $event == 'Logout' || $event == 'AjaxLogin') {
				
				$this->_execute_method('On'.$event);
				$this->_execute_method('OnAfter'.$event);
				$this->_clear_event();
			}
			
			if(!$this->_is_auth_user()) {
			
				$this->ProcessEvents = false;
				if($IsAzone)
					$this->SetTemplate($this->AuthData['template']);
				else
					$this->SetTemplate($this->AuthData['template']);
			}
			
			Page::_process_events($event);
		}
		
		protected function _load_config() {
			
			Page::_load_config();
			$this->_load_auth_data();
		}
	}

?>