<?
	
	class SystemVariables extends ContentPage {
		
		/*
		 * Protected properties
		 */
		
		protected $TemplatesBaseDir			= 'sys-vars/';
		protected $PageNavigator			= null;
		protected $Grid						= null;
		protected $News						= array();
		protected $News_sz					= 0;
		protected $NewsInfo					= array();
		
	
		
		/*
		 * Public methods
		 */

		public function OnCreate(){
			$this->TableName = 'sys_vars';
			$this->HiddenFields = array('var_name');
			$this->TranslationTableName = '';
			$this->LeftJoin = array();
		}		
		
		public function OnDefault() {
			$this->SetTemplate('main.html');
		}

		
		//----------------- Ajax responses[BEGIN] -----------------------

		public function OnGetModuleStructure(){
			
			$per_page = intval($this->_get_system_variable('admin_items_per_page'));
			
			$structure = array(
				'component'		=> 'grid',				//Тип компонента: grid, dataview
				'title'			=> 'Системные переменные',				//Заголовок компонента
				'url'			=> '/azone/system-variables/',	//URL компонента
				'tbar'			=> array(
					
				),
				'editable'		=> false,				//Нередактируемый
				'searchable'	=> true,				//Добавляется поле поиска в тулбар 
				'withoutNew'	=> true,				//Без добавление новых эл-тов 
				'sortColumn'	=> false,				//Без колонки сортировки
				'autoLoad'		=> true,				//Автозагрузка
				'perPage'		=> $per_page,			//Количество элементов на странице, если не задан то отобразятся все записи
				'params'		=> array(				//Базовые параметры Store(попадают в baseParams)
					'Event'	=> 'GetRecords',			
					'start'	=> 0,
					'limit'	=> $per_page
				),
				
				'structure'		=> array(				//Структура данных передаваемых данных для создания Ext.data.Record
					array(
						'name'	=> 'id',
						'type'	=> 'int'
					),
					array(
						'name'	=> 'title'
					),
					array(
						'name'	=> 'var_value',
					)
				),
				
				
				'colModel'		=> array(				//Структура колонок для ColumnModel 
					array(
						'header'	=> 'ID',
						'width'		=> 30,
						'fixed'		=> true,
						'sortable'	=> true,
						'hidden'	=> true,
						'dataIndex'	=> 'id',
						'id'		=> 'id'
					),
					array(
						'header'	=> 'Название переменной',
						'width'		=> 80,
						'sortable'	=> true,
						'dataIndex'	=> 'title',
						'id'		=> 'title'
					),
					array(
						'header'	=> 'Значение',
						'width'		=> 80,
						'sortable'	=> true,
						'dataIndex'	=> 'var_value',
						'id'		=> 'var_value'
					)
				),
				'withNumberer'	=> true				//Колонка нумерации
				
			);
			
			/*//columns configuration
			$structure['serv_columns'] = array(
				array(
					'type'		=> 'published',
					'sort_order'=> -1,
					'config'	=> array(
						'width'	=> 14
					)
				),
				array(
					'type'		=> 'languages',			//Колонка переводов
					'sort_order'=> -1,
					'languages'	=> array_merge($this->Languages, array()),	//Обязательно передавать языки!!!
					'config'	=> array(
						'width'	=> 18
					)
				)
			);*/
			
			if($this->Perm['edit']) {
				$structure['serv_columns'][] = array(
					'type' => 'control',
					'sort_order' => -1,
					'icons' =>  array(
						'edit'
						//'delete'
					)
				);
			}			
			
			echo $this->json_safe_encode($structure);
			exit;
		}

		public function OnGetEditForm(){
			
			$res = $this->_get_form_structure(
				$this->TableName, 
				array(
					'title'	=> 'Редактирование',
					'url'	=> '/azone/system-variables/',
					'width'	=> 550, 
					'height'=> 170
				)
			);
			
			echo $this->json_safe_encode($res);
			exit;
		}
		
		//----------------- Ajax responses[END] -------------------------
		

	}
?>