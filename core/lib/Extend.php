<?php
	/*
	РќР° РІС‹С…РѕРґРµ СЃС‚СЂРѕРєР° СѓСЂР»Р°
	РќР° РІС…РѕРґ РѕР±СЏР·Р°С‚РµР»СЊРЅРѕ	: 	1) id 										(int)
							2) С‚Р°Р±Р»РёС†Р°									(string)		
							3) fronttext, С‚РµРєСЃС‚ РїРµСЂРµРґ СѓСЂР»РѕРј				(string)	'' 
	РЅРµ РѕР±СЏР·Р°С‚РµР»СЊРЅРѕ		:	3) sometext, РёРЅРѕРіРґР° РЅСѓР¶РЅРѕ РЅР°РїСЂРёРјРµСЂ '/view'	(string)	'' 
							4) СЃС‚СЂРѕРёС‚СЊ СѓСЂР» РїРѕ РїРѕР»СЋ id РёР»Рё url 			(boolean)   true
							5) РІ РєРѕРЅС†Рµ РїСЂРёСЃС‚Р°РІРєР° .html 					(boolean)	true
							6) РёСЃРїРѕР»СЊР·СѓРµС‚СЃСЏ РІРЅСѓС‚СЂРё С„-С†РёРё РїСЂРё СЂРµРєСѓСЂСЃРёРё 	(string)	''
	*/
		function _fullurl($id, $table, $fronttext='', $sometext = '', $idview = false, $html = false, $url = '', $parent_field = 'parent_id', $debug = false){
			global $DB;
			$sql = "SELECT `id`, `url`, `".$parent_field."` FROM `".$table."` WHERE id='".$id."'";
			if ($debug) { echo $sql."<br />"; }
			$res = array();
			//$res = $DB->GetRow($sql);
			$res = $DB->CacheGetRow($sql);
			
			if ($idview) {
				$url =  '/'.$res['id'] . $url;
			} else {
				 $url = '/'. (($res['url']) ? $res['url'] : $res['id']) . $url;
			}
			
			if($res['parent_id'] != 0 ){			
				return _fullurl($res['parent_id'], $table, $fronttext, $sometext, $idview, $html, $url);		
			} else {
				if ($sometext) {
					$url = substr_replace($url, $sometext, strpos(substr($url,1), '/') + 1, 0);
				}	
				if ($url) {
					return   $fronttext .  $url  . (($html) ? '.html' : '');
				} else {
					return  '';
				}
				
			}
		}
		/*
		РҐР»РµР±РЅС‹Рµ РєСЂРѕС€РєРё
		РќР° РІС‹С…РѕРґРµ РјР°СЃСЃРёРІ 		['title'] => ['url']
		РќР° РІС…РѕРґ РѕР±СЏР·Р°С‚РµР»СЊРЅРѕ	: 	1) id 										(int)
								2) С‚Р°Р±Р»РёС†Р°									(string)		
		РЅРµ РѕР±СЏР·Р°С‚РµР»СЊРЅРѕ		:	3) РёРјСЏ РєР»Р°СЃСЃР°, РїРµСЂРІС‹Р№ СЌР»РµРјРµРЅС‚ СѓСЂР»Р°			(string)	'' 
								4) СЃС‚СЂРѕРёС‚СЊ СѓСЂР» РїРѕ РїРѕР»СЋ id РёР»Рё url 			(boolean)   true
								5) РІ РєРѕРЅС†Рµ РїСЂРёСЃС‚Р°РІРєР° .html 					(boolean)	true
								6) РёСЃРїРѕР»СЊР·СѓРµС‚СЃСЏ РІРЅСѓС‚СЂРё С„-С†РёРё РїСЂРё СЂРµРєСѓСЂСЃРёРё 	(array)	''
								6) РёСЃРїРѕР»СЊР·СѓРµС‚СЃСЏ РІРЅСѓС‚СЂРё С„-С†РёРё РїСЂРё СЂРµРєСѓСЂСЃРёРё 	(int)	''
		*/
		function _breadcrumbs($id, $table, $fronttext='', $classname = '', $idview = false, $html = true, $crumbs = array(), $i = 0){
			global $DB;
			$sql = "SELECT `id`, `title`, `parent_id` FROM `".$table."` WHERE id='".$id."'";
			$res = array();
			//$res = $DB->GetRow($sql);
			$res = $DB->CacheGetRow($sql);
			$crumbs[$i]['title'] = $res['title'];
			$crumbs[$i]['url']	 =  _fullurl($res['id'], $table, $fronttext, $classname, $idview, $html);	
			$i++;			
			if($res['parent_id'] != 0 ){
				return _breadcrumbs($res['parent_id'], $table, $fronttext, $classname, $idview, $html, $crumbs, $i);		
			} else {
				return array_reverse($crumbs);
			}
		}
		
		function _echo_br($br){
			if($br){
			$res =  '<div class="CurrentPage">
								<ul>';
								$res .=	'<li><a href="/catalog.html">РљР°С‚Р°Р»РѕРі С‚РѕРІР°СЂРѕРІ</a></li>';	
								$res .=	'<li><img style="padding: 0 5px" src="/public/images/two-arrows.png"></li>';
								 for($i = 0, $cn = sizeof($br); $i<$cn; $i++) {
								$res .=	'<li><a title="" href="'.$br[$i]['url'].'">'.$br[$i]['title'].'</a></li>';
									 if($i != $cn - 1){
									$res .=	'<li><img alt="" src="/public/images/two-arrows.png"></li>';
									 }?>
									<?}
						$res .='	</ul>
							</div>';
				return $res;		
			}	
		 }
		
		 function _print_breadcr($br) { ?>
       	<div class="CurantPage">
       	<ul>
			<li><a href="/" title="">Р“Р»Р°РІРЅР°СЏ</a></li>
			<? for($i = 0, $cn = sizeof($br); $i<$cn; $i++) { 
          		$url = ($i == $cn - 1) ? $br[$i]['title'] : '<a href="'.$br[$i]['url'].'">'.$br[$i]['title'].'</a>'; 	
          		$class = ($i == $cn - 1) ? 'class="curent"' : ''; ?>
          		<li><span <?=$class?> ><?=$url?></span></li>
          <?} ?>
				
       	</ul>
       	</div>
       <? }
	
//	РћР±СЂРµР·Р°РµС‚ С‚РµРєСЃС‚ РґРѕ Р·Р°РґР°РЅРЅРѕР№ РґР»РёРЅРЅС‹ Utf8
	function _trim_word($text, $counttext = 10, $maxlen = 0, $sep = ' ') {
    		$words = split($sep, $text);
     		if ( count($words) > $counttext )
        	 $text = join($sep, array_slice($words, 0, $counttext));
        	 if ($maxlen) {
        	 	if (strlen($text) < $maxlen) {
	        	 	for($i = $counttext; $i < $counttext + 100; $i++) {
		        	 	if ( mb_strlen($text,'UTF-8') < $maxlen) {
		    	    	       	 	$text = join($sep, array_slice($words, 0, $i)); 
		        	 	} else {
		    	    	 	return $text;
		    	    	}
	        		}
        	 	}
        	 }
     		return $text.' ...';
 		}
// РІС‹РґРµР»СЏРµС‚ РёР· СЃС‚СЂРѕРєРё С‡РёСЃР»Рѕ 
	function _strtoint($str){
		return 	ereg_replace("[^0-9]", "", $str);
	} 		
 		
//	РїРѕРґРіРѕС‚РѕРІРєР° РїРµСЂРµРјРµРЅРЅС‹С… РґР»СЏ РїРѕСЃР»РµРґСѓСЋС‰РµРіРѕ СЋР·Р°РЅСЊСЏ РІ Р‘Р” 			
	function var_smart ( $value ) {
			if ( get_magic_quotes_gpc ()) {
				      $value = stripslashes ( $value );
	 		    }
		    if ( ! is_numeric ( $value )) {
				      $value =  mysql_real_escape_string ( $value ) ;
			    }
				    return $value ;
		}	
		
//	РїСЂРµРѕР±СЂР°Р·РѕРІР°РЅРёРµ СЃРёРјРІРѕР»РѕРІ РІСЃРµРіРѕ РјР°СЃСЃРёРІР° 	
	function _hsc($data) {
 			if (is_array($data)) {
 			foreach ($data as $index => $val) {
 			 	$data[$index] = htmlspecialchars($val);
 				}
 			}
 			return $data;
 		}	
		
//	Р·Р°РїРёСЃСЊ РІ С„Р°Р№Р», РґР»СЏ РґРµР±Р°РіР°
	function _log($s, $m = '', $file = '', $date = true) {
       $s =($s) ? $s : 'ZERO_STRING!!!';
       $m =($m) ? $m : 'wb+';
		$file = ($file) ? $_SERVER['DOCUMENT_ROOT'].$file : $_SERVER['DOCUMENT_ROOT'].'/_log.txt'; 	

       if (!file_exists($file)) {
       		@file_put_contents($file,'');
       		@chmod($file, 0777);	       
       }
		if(is_array($s)) {
			$s = var_export($s,true);
		}
		
		if ($date) {
			$s =  date("-------------------------- d-m-y H:i:s ------------------------------ \n") . $s;
		}
       if ($f = @ fopen ($file, $m))
	     	{
    			@ flock ($f, LOCK_EX);
		    	@ fputs ($f, $s."\n\n");
    			@ flock ($f, LOCK_UN);
		    	@ fclose ($f);
    		}
    }
		
		function _time($exit=0){
			echo "<pre>";
			echo time();
			echo "</pre>";
			if($exit) exit();
		}
		
	
	/* adodb РїРѕРґСЃС‡РµС‚ РєРѕР»-РІР° Р·Р°РїСЂРѕСЃРѕРІ */	
		function CountExecs($conn, $sql, $inputarray) {
		   global $EXECS;
		   $EXECS++;
		}
		
		function CountCachedExecs($conn, $secs2cache, $sql, $inputarray) {
		   global $CACHED;
		   $CACHED++;
		}
		// РІС‹РІРѕРґ РЅР° СЌРєСЂР°РЅ
		function _get_count_q($title){
			static $x;
			$x += 105;
			global $EXECS,$CACHED; 
			$res = $EXECS + $CACHED;  ?>
			<div style="position: absolute;   top: <?= $x ?>px; left: 100px; background: #FFFFFF; width: 350px; heigth: 100px; "
			<div style="padding: 15px">
				<?= ($title) ? '<p><b>Point: </b>'.$title.'</p>' : '' ?>
   				<p>Р’СЃРµРіРѕ Р·Р°РїСЂРѕСЃРѕРІ Рє Р±Р°Р·Рµ РґР°РЅРЅС‹С…: <b><?=($res)?$res:'0'?></b></p>
	   			<p>Р�Р· РЅРёС… РІР·СЏС‚Рѕ РёР· РєРµС€Р° : <b><?=($CACHED)? $CACHED : '0'?></b></p>
	   			</div>
	   		</div>	
	  <? }
	  /* end */
	  // С„СѓРЅРєС†РёСЏ РїСЂРµРІРѕРґР° С‚РµРєСЃС‚Р° СЃ РєРёСЂРёР»Р»РёС†С‹ РІ С‚СЂР°СЃРєСЂРёРїС‚
		function _translit($str){
			if($str){
		   	 $cirilica = array("Р°", "Р±", "РІ", "Рі", "Рґ", "Рµ", "С‘", "Р·", "Рё", "Р№", "Рє", "Р»", "Рј", "РЅ", "Рѕ", "Рї", "СЂ", "СЃ", "С‚", "Сѓ", "С„", "С…", "СЉ", "С‹", "СЌ", "_", "Рђ", "Р‘", "Р’", "Р“", "Р”", "Р•", "РЃ", "Р—", "Р�", "Р™", "Рљ", "Р›", "Рњ", "Рќ", "Рћ", "Рџ", "Р ", "РЎ", "Рў", "РЈ", "Р¤", "РҐ", "РЄ", "Р«", "Р­", "_", "Р¶",   "С†",  "С‡",  "С€",    "С‰", "СЊ", "СЋ", "СЏ",   "Р–",  "Р¦",  "Р§",  "РЁ",    "Р©","Р¬",  "Р®", "РЇ", " ", ",", ".","!","?");
			 $latinica = array("a", "b", "v", "g", "d", "e", "e", "z", "i", "y", "k", "l", "m", "n", "o", "p", "r", "s", "t", "u", "f", "h",  "", "i", "e", "_", "A", "B", "V", "G", "D", "E", "E", "Z", "I", "Y", "K", "L", "M", "N", "O", "P", "R", "S", "T", "U", "F", "H",  "", "I", "E", "I",  "zh", "ts", "ch", "sh", "shch", "", "yu", "ya", "ZH", "TS", "CH", "SH", "SHCH", "", "YU", "YA", "-", "", "","","");
		     	return str_replace($cirilica, $latinica, $str);
			}else{
				return '';
			} 
		}
	 		
	  // РІРѕР·РІСЂР°С‰Р°РµС‚ СЂР°СЃС€РёСЂРµРЅРёРµ С„Р°Р№Р»Р°
	   function _fgetex($filename) {
	    	 return end(explode(".", $filename));
	   }
	   
	   // РІРѕР·РІСЂР°С‰Р°РµС‚ РїСЂР°РІР° РґРѕСЃС‚СѓРїР° Рє РїР°РїРєРµ РёР»Рё С„Р°Р№Р»Сѓ
	   function _fgetperm($path){
			$fileperms =  substr ( decoct (  fileperms ( $path ) ), 2, 6 );
			if ( strlen ( $fileperms ) == '3' ){ $fileperms = '0' . $fileperms; }
			return $fileperms;	   
	   }
		
	  // Р·Р°РјРµРЅСЏРµС‚ СЂСѓСЃРєРёРµ СѓСЂР»С‹ С‚СЂР°РЅСЃС‚Р»РёС‚РѕРј РІ Р·Р°РґР°РЅРЅРѕР№ РїР°СЂР°РјРµС‚СЂРѕРј С‚Р°Р±Р»РёС†Рµ
	  function _translit_table($table,$f1,$f2){
	  	global $DB;
	  	$sql = "SELECT `id`, `".$f1."`,`".$f2."` FROM `".$table."`";
	  	//_debug($sql,1);
	  	$res = $DB->GetAll($sql);
	  	for ($i = 0, $cn = count($res); $i < $cn; $i++) {
	  		$temp= _translit($res[$i][$f1]); 
	  		$sql = "UPDATE `".$table."` SET `".$f2."` = '".$temp."' WHERE `id` = '".$res[$i]['id']."'" ;
	  		$DB->Execute($sql);	
	  	}
	  }
	 // С‚РµРєСѓС€РёР№ СѓСЂР» + РјРѕР¶РЅРѕ РґРѕР±Р°РІРёС‚СЊ РґРѕРї РїР°СЂР°РјРµС‚СЂ 
	 function _curent_url($add=''){
			$res = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if($add) {
			    $pref = (strpos($res,'?') !== false) ? '&' : '?'; 
			    $res  = $res.$pref.$add;
			}
			return 'http://'.$res;
		}
	 
	function _cur_url($add){
		$res = str_replace($_SERVER['QUERY_STRING'],'',$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$res = str_replace('?','',$res);
		if($add) {
			    $pref = (strpos($res,'?') !== false) ? '&' : '?'; 
			    $res  = $res.$pref.$add;
			}
			return 'http://'.$res;
	}	
		
	// РѕР±СЂРµР·Р°РµС‚ СЃС‚СЂРѕРєСѓ РЅР° Р·Р°РґР°РЅРЅРѕРµ РєРѕР»-РІРѕ СЃРёРјРІРѕР»РѕРІ СЃ РєРѕРЅС†Р°	
	function _cut_str(&$str, $clear = '1'){
		$str = substr($str, 0, strlen($str)-$clear);
		return;	
	}	
	function is_for($ar){ 
		return is_array($ar) && (count($ar) > 0 );
	}
	function _get_mysql_date($ar){
		return  implode('-',array_reverse(explode('.',$ar))).' 00:00:00';
	}
	
	function resize($file, $type, $height, $width){
			
		    $img = false;
		    switch ($type){
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/pjpeg':
					$img = @imagecreatefromjpeg($file);
					break;
				case 'image/x-png':
				case 'image/png':
					$img = @imagecreatefrompng($file);
					break;
				case 'image/gif':
					$img = @imagecreatefromgif($file);
					break;
		    }
		    if(!$img){
				return false;
		    }
		    
		    $curr = @getimagesize($file);
		    
		    $perc_w = $width / $curr[0];
		    $perc_h = $height / $curr[1];
		    
		    if(($width > $curr[0]))/* || ($height > $curr[1]))*/{
				return;
		    }
		    
		    if($perc_h > $perc_w){
				$width = $width;
				$height = round($curr[1] * $perc_w);
		    } else {
				$height = $height;
				$width = round($curr[0] * $perc_h);
		    }
		    
		  
		    $nwimg = @imagecreatetruecolor($width, $height);
		    @imagecopyresampled($nwimg, $img, 0, 0, 0, 0, $width, $height, $curr[0], $curr[1]);
		    
		    switch ($type){
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/pjpeg':
					@imagejpeg($nwimg, $file);
					break;
				case 'image/x-png':
				case 'image/png':
					@imagepng($nwimg, $file);
					break;
				case 'image/gif':
					@imagegif($nwimg, $file);
					break;
		    }
		    
		    @imagedestroy($nwimg);
		    @imagedestroy($img);
			return true;
		}	

		
	function _utf8_sustr($str, $width, $break, $cut = false) {		
		if(mb_strlen($str,'UTF-8')>$width){
			$str = mb_substr($str, 0, $width)."...";
		}
		return $str;	
	}
	function _myutf8_substr($str,$from,$len){
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
		'$1',$str)."...";
	}
	
	function _safevar($var, $sql = false){
	
		// РјРЅРµРјРѕРЅРёР·РёСЂСѓРµРј СЃС‚СЂРѕРєСѓ
		$var = htmlentities($var, ENT_QUOTES, 'UTF-8');

		if(get_magic_quotes_gpc()){
			// СѓР±СЂРёСЂР°РµРј Р»РёС€РЅРµРµ СЌРєСЂР°РЅРёСЂРѕРІР°РЅРёРµ
			$var = stripslashes($var);
		}
		
		if($sql){
			// РµСЃР»Рё РЅСѓР¶РµРЅ MySQL-Р·Р°РїСЂРѕСЃ, С‚Рѕ РґРµР»Р°РµРј СЃРѕРѕС‚РІРµС‚СЃС‚РІСѓСЋС‰СѓСЋ РѕС‡РёСЃС‚РєСѓ
			$var = mysql_real_escape_string ($var);
		}
		
		// СѓР±РёСЂР°РµРј С‚РµРіРё
		$var = strip_tags($var);

		return $var;
	}
?>