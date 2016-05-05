<?

	class FrontPage extends ContentPage {
		
		
		/*
		 * Public methods
		 */
		public function OnDefault() {			
			array_unshift($this->JS, $this->RootUrl.'/public/js/jquery.js');	
			array_unshift($this->JS,'https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js');			          
			array_push($this->JS, $this->RootUrl.'/public/js/main.js');			
		}
		public function OnCreate() {
			
			$this->AddCSS($this->RootUrl.'public/css/front-page.css');
			$this->SetTemplate('front-page.html');
		}
	}

?>