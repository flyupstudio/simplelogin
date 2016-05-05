<?

	abstract class Component {
		
		/*
		 * Protected properties
		 */
		
		protected $Location			= '';
		protected $Name				= '';
		protected $Theme			= '';
		protected $Template			= '';
		protected $Src				= '';
		
		
		/*
		 * Public methods
		 */
		
		final public function __construct($theme) {
			
			$this->Theme = $theme;
			$this->_set_component_info();
			$this->Prepare();
		}
		
		final public function Display() {
			
			include $this->Location.'html/'.$this->Template;
		}
		
		public function GetSrc() {
			
			return $this->Src;
		}
		
		abstract public function Prepare();
		
		
		/*
		 * Private methods
		 */
		
		private function _set_component_info() {
			
			$this->Name = get_class($this);
			$this->Location = PATH_COMPONENTS.$this->Theme.'/'.$this->Name.'/';
			
			global $config;
			$this->Src = $config['site_url'].COMPONENTS_DIR_NAME.'/'.$this->Theme.'/'.$this->Name.'/';
		}
	}

?>