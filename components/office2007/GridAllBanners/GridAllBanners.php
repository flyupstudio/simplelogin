<?

	class GridAllBanners extends Component {
		
		/*
		 * Protected properties
		 */
		
		protected $Template			= 'grid.html';
		protected $Data				= array();
		
		
		/*
		 * Public methods
		 */
		
		public function SetData($data) {
			
			$this->Data = $data;
		}
		
		public function Prepare() {

		}
		
		
	}

?>