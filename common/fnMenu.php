<?php
class MenuObj{
     
	function genMenu(){
		//generate menu from url
		global $Main;
		
		$kondMenu = " and menu_versi='$Main->MENU_VERSI'";
		//get kode dari href param
		$url = $_SERVER['REQUEST_URI'];
		$arrulr = explode('/',$url);
		$so = sizeof($arrulr);
		$href_ = $arrulr[$so-1];
		//$get = mysql_fetch_array(mysql_query( "select * from ref_menu where href='$href_' and aktif=1 $kondMenu order by level desc " ));
		//$get = mysql_fetch_array(mysql_query( "select * from ref_menu where '$href_' like concat(href,'%') and aktif=1 $kondMenu order by level desc,  href desc limit 0,1" ));
		$get = mysql_fetch_array(mysql_query( "select * from ref_menu where '$href_' like concat(href,'%') and aktif=1 $kondMenu order by href desc, level desc limit 0,1" ));
		if($get <> NULL){
			
		
		$kode = $get['kode'];
				
				
				
		//create menu
		$menu = '';//"<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"> ";					
		$arrKode = explode('.',$kode);		
		$level = 1; $parent='';
		foreach($arrKode as &$value ){
			if($level>1 && $value <> ''){
				//ambil menu sesuai level
				$aqry = "select * from ref_menu where kode like '$parent%' and level = $level and aktif = 1 $kondMenu order by urut ";
				$qry = mysql_query(	$aqry	);
				$arrMenu = array();
				while($isi= mysql_fetch_array($qry)){
					$href = $isi['href'];
					$hint = $isi['hint'];
					$title = $isi['title'];
					$styleMenu =  $isi['kode'] == $parent.$value.'.' ?   "style='color:blue;'" : "style='color:red;'";					
					$arrMenu[] = " <a href='$href' title='$hint' $styleMenu>$title</a> ";			
				}				
				$menu .= "<tr><td class=\"menudottedline\" width=\"40%\" height=\"20\" style='text-align:right'><B>". 
					join(" | ", $arrMenu) .
					"&nbsp;&nbsp;&nbsp;</td></tr>";
				
			}
			//set next
			$parent .= $value.'.';
			$level ++;				
		}
		if ($menu <> '' ){
			$menu = 
				 "<table width=\"100%\" class=\"menubar\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"> ".
				 $menu.
				 "</table><tes_$kode></tes_$kode>";	
		}
		
		
		}
   		return $menu;
	}
	/***
	function getTitleLevel($level){
		global $Main;
		
		$kondMenu = " and menu_versi='$Main->MENU_VERSI'";
		//get kode dari href param
		$url = $_SERVER['REQUEST_URI'];
		$arrulr = explode('/',$url);
		$so = sizeof($arrulr);
		$href_ = $arrulr[$so-1];
		
		$get = mysql_fetch_array(mysql_query( "select * from ref_menu where '$href_' like concat(href,'%') and aktif=1 $kondMenu order by href desc, level desc limit 0,1" ));
		if($get <> NULL){
			$kode = $get['kode'];
			$arrkode =explode('.',$kode); 
			$get2 = mysql_fetch_array(mysql_query("select * from ref_menu where kode ='".$arrkode[0].".'" )) ;
			$title = $get2['title'];
			//die($kode.'-'.$title);
		}
		return $title;
	}***/
	function getData(){
	    //ambil data menu  from url
		global $Main;
		$get = NULL;
		
		$kondMenu = " and menu_versi='$Main->MENU_VERSI'";
		//get kode dari href param
		$url = $_SERVER['REQUEST_URI'];
		$arrulr = explode('/',$url);
		$so = sizeof($arrulr);
		$href_ = $arrulr[$so-1];
		
		$get = mysql_fetch_array(mysql_query( "select * from ref_menu where '$href_' like concat(href,'%') and aktif=1 $kondMenu order by href desc, level desc limit 0,1" ));
		if($get <> NULL){
			//$kode = $get['kode'];
			//$arrkode =explode('.',$kode); 
			//$get2 = mysql_fetch_array(mysql_query("select * from ref_menu where kode ='".$arrkode[0].".'" )) ;
			//$page->title = $get['page_title'];
			//$page->icon = $get['page_icon'];
			//die($kode.'-'.$title);
		}
		return $get;
	}
	function tes($s){
		return $s;
	}
     
}
$Menu = new MenuObj();

?>