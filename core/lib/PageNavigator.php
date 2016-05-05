<?
	class PageNavigator {
		
		protected $ItemsCnt			= 0;
		protected $ItemsPP			= 0;
		protected $URL				= '';
		protected $URL_1			= '';
		protected $CurrPage			= 0;
		protected $Pages			= array();
		public $Pages_sz			= 0;
		public $Template			= 'page-navigator.html';
		protected $Constants		= array();
		
		public $PrevHref			= '';
		public $NextHref			= '';
		protected $FirstHref		= '';
		protected $LastHref			= '';
		public $PrevNext			= false;
		public $FirstLast			= false;
		
		
		function __construct($total_items, $items_per_page, $max_pages_sz, $url, $page, $page_format = 'page-%s.html', $req_arr ='',$prevnext = false, $firstlast = false, $ajax = false ) {
			
			$this->ItemsCnt = $total_items;
			$this->ItemsPP = $items_per_page;
			$this->URL = $url.$page_format;
			$this->URL_1 = $url;
			$this->CurrPage = $page;
			$this->ReqArr = $req_arr && $req_arr != '&' ? $req_arr:'';
			$this->Ajax = $ajax;
			$this->Pages_sz = $max_pages_sz;
			$pages_sz = ceil($this->ItemsCnt / $this->ItemsPP);
			if($this->Pages_sz > $pages_sz) {
				$this->Pages_sz = $pages_sz;
			}
			
			$this->_calculate();
			
			if($firstlast){
				
				$this->FirstLast = true;
				$this->_load_first_last($pages_sz);
			}
			
			if($prevnext){
				$this->PrevNext = true;
			}
			$this->_load_prev_next();

		}
		
		protected function _load_prev_next() {
			
			if($this->CurrPage > 1) {
				if($this->Ajax){
					$this->PrevHref = $this->CurrPage - 1;	
				}else{
					if ($this->CurrPage>2)
					$this->PrevHref = sprintf($this->URL, $this->CurrPage - 1).$this->ReqArr;
					else {
					$this->PrevHref = $this->URL_1;
					}				
				}	
			}
			
			if($this->CurrPage < ceil($this->ItemsCnt / $this->ItemsPP)) {
				if($this->Ajax){
					$this->NextHref = $this->CurrPage + 1;
				}else{
					$this->NextHref = sprintf($this->URL, $this->CurrPage + 1).$this->ReqArr;
				}	
			}
		}
		
		protected function _load_first_last($pages) {
			
			if($this->CurrPage > 1) {
				if($this->Ajax){
					$this->FirstHref = 1;				
				}else{
					$this->FirstHref = sprintf($this->URL, 1).$this->ReqArr;				
				}
			}
			
			if($this->CurrPage < $pages) {
				if($this->Ajax){
					$this->LastHref = $pages;				
				}else{
					$this->LastHref = sprintf($this->URL, $pages).$this->ReqArr;				
				}
			}
		}
		
		
		protected function _calculate() {
			
			$total_pages = ceil($this->ItemsCnt / $this->ItemsPP);
			$half_sz = ceil(($this->Pages_sz) / 2);
			
			if($this->CurrPage < $half_sz) {
				$page_pos = $this->CurrPage;
			}
			elseif($this->CurrPage > $total_pages - $half_sz) {
				$page_pos = $this->Pages_sz - ($total_pages - $this->CurrPage);
			}
			else {
				$page_pos = $half_sz;
			}
			
			$sz_before = $page_pos - 1;
			$sz_after = $this->Pages_sz - $page_pos;
			
			
			for($i = 0; $i < $sz_before; $i++) {
				$num = $this->CurrPage - $sz_before + $i;
				
				if($i == 0 && $num != 1)
				{
					$page['title'] = ' < ';
				}
				else
				{
					$page['title'] = $num;
				}
				if($this->Ajax){
					$page['href'] = $num;
				}else{
					$page['href'] = sprintf($this->URL, $num).$this->ReqArr;
				}	
				array_push($this->Pages, $page);
			}
			
			array_push($this->Pages, array('title'=>$this->CurrPage));
			
			for($i = 0; $i < $sz_after; $i++) {
				$num = $this->CurrPage + $i + 1;
				
				if($i == $sz_after - 1 && $num != $total_pages)
				{
					$page['title'] = ' > ';
				}
				else
				{
					$page['title'] = $num;
				}
				
				if($this->Ajax){
					$page['href'] = $num;
				}else{
					$page['href'] = sprintf($this->URL, $num).$this->ReqArr;
				}
			
				array_push($this->Pages, $page);
			}
			
			$this->Pages_sz = count($this->Pages);
		}
		
		public function LoadConstants($arr) {
			
			$this->Constants = $arr;
		}
		
		
		public function Run() {
			global $url_parts;
				
			if($this->Pages_sz > 1) {
				if($url_parts[1] == 'view' && count($url_parts) >= 3){
					include PATH_SNIPPETS.'comment-page-navigator.html';
				}else{
					if($this->Ajax)
						include PATH_SNIPPETS.'ajax-page-navigator.html';
					else
						include PATH_SNIPPETS.$this->Template;
				}	
			}
		}
		
	}
?>