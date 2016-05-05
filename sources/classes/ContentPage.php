<?
/*//////////////////////////////////////////////////////////////////////////////

        ContentPage.php
        --------
       
        $Id: ContentPage.php,v 1.1 2016/05/05 Exps $

//////////////////////////////////////////////////////////////////////////////*/

	abstract class ContentPage extends AbstractPage {
		
		/*
		 * Protected properties
		 */
		protected  $TimeZones = array(
			'-12:00','-11:00',
			'-10:00','-09:00',
			'-08:00','-07:00',
			'-06:00','-05:00',
			'-04:30','-04:00','-03:30',
			'-03:00','-02:00',
			'-01:00','00:00',
			'+01:00','+02:00',
			'+03:00','+03:30',
			'+04:00','+04:30',
			'+05:00','+05:30',
			'+05:45','+06:00',
			'+06:30','+07:00',
			'+08:00',
			'+09:00','+09:30',
			'+10:00','+10:30','+11:00',
			'+12:00','+13:00',
		);
		
		protected $NavPanel				= null;
		protected $NavPanelExp			= -1;
		protected $StartMenu			= null;
		protected $Modules				= array();
		protected $Modules_sz			= 0;
		protected $Modules_tree			= array();
		protected $Modules_tree_sz		= 0;
		protected $ModuleInfo			= array();
		protected $Perm					= array();
		protected $Errors				= array();
		protected $DisplayError			= false;
		public $LinkList 				= array();
		public $Price	 				= array();
		protected $PageContent			= '';
		protected $HeaderContent		= '';
		protected $FooterContent		= '';
		protected $TableName			= '';
		protected $TranslationTableName	= '';
		
		protected $Select				= 't.*';
		
		protected $SortField			= 'sort_order';
		protected $PublishField			= 'published';
		protected $DefaultField			= 'default';
		
		protected $SaveActions			= array();
		
		protected $WithSort				= false;
		
		protected $Records				= array();
		protected $Records_sz			= 0;

		public $DefaultLang				= 'rus';
		public $ToggleArr				= array(0 => 1, 1 => 0);
		public $DefaultLangId			= 0;
		protected $Languages			= array();
		protected $News					= array();
		
		/*
		 * Public methods
		 */
		final public function OnAfterLogin() {
			
			global $DB;
			
			$sql = 'UPDATE az_users 
					SET last_visit_ts=UNIX_TIMESTAMP(), 
						last_visit_ip=\''.$_SERVER['REMOTE_ADDR'].'\' 
					WHERE id=\''.$this->UserAccount['id'].'\'';
			$DB->Execute($sql);
		}
		
		

		public function OnDisplay() {
			
			ob_start();
			if($this->Header) {
				require_once PATH_HTML_TEMPLATES.$this->Header;
			}
			
			if($this->directPathTemplate){
				require_once $this->directPathTemplate;
			}else{
				require_once PATH_HTML_TEMPLATES.$this->TemplatesBaseDir.$this->Template;
			}
		
			if($this->Footer){
				require_once PATH_HTML_TEMPLATES.$this->Footer;
			}
			
			$this->PageContent = ob_get_contents();
			
		
			
			ob_end_clean();

			echo $this->PageContent;
			
		}

		
		
	}

?>