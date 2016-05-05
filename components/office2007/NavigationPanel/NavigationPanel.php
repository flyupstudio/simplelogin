<?

	class NavigationPanel extends Component {
		
		/*
		 * Protected properties
		 */
		
		protected $Template			= 'nav-panel.html';
		protected $Data				= array();
		protected $ExpandedId		= -1;
		
		
		/*
		 * Public methods
		 */
		
		public function SetData($data) {
			
			$this->Data = $data;
		}
		
		public function Prepare() {
			
		}
		
		public function SetExpandedItem($id) {
			
			$this->ExpandedId = $id;
		}
	}

?>