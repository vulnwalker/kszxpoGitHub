<?php

class kodetanahObj extends DaftarObj2{
	var $Prefix = 'kodetanah'; //jsname
	var $SHOW_CEK = FALSE;
	var $withform = TRUE;
	//daftar -------------------
	//var $elCurrPage="HalDefault";
	var $TblName = 'view_kib_a2'; //daftar
	var $TblName_Hapus = 'view_kib_a2';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('id'); //daftar/hapus
	var $FieldSum = array();
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 9, 8,8);//berdasar mode
	var $FieldSum_Cp2 = array( 5, 5,5);	
	var $checkbox_rowspan = 1;
	var $totalCol = 17; //total kolom daftar
	var $fieldSum_lokasi = array( 9,10);  //lokasi sumary di kolom ke	
	var $withSumAll = TRUE;
	var $withSumHal = TRUE;
	var $WITH_HAL = TRUE;
	var $totalhalstr = '<b>Total per Halaman';
	var $totalAllStr = '<b>Total';
	//var $KeyFields_Hapus = array('Id');
	//cetak --------------------
	var $cetak_xls=FALSE ;
	var $fileNameExcel='kodetanah.xls';
	var $Cetak_Judul = 'KIB A';
	//var $Cetak_Header;
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;//="<link type='text/css' href='css/template_css.css' rel='stylesheet'>";
	//page ----------------------
	//var $Prefix='page'; //js object pake ini
	var $ToolbarAtas_edit ='';
	var $PageTitle = 'KIB A';
	var $PageIcon = 'images/penatausahaan_ico.gif';
	var $pagePerHal= '25';
	var $FormName = 'kodetanahForm';	
	var $ico_width = 20;
	var $ico_height = 30;
	
	function setTitle(){
		global $Main;
		return 'KIB A';	

	}
	function setCetakTitle(){
		return "KIB A";
	}
	
	function setMenuEdit(){	
		return "";
	}
	
	function setMenuView(){		
		return 	"";
		
	}
	
	function setPage_HeaderOther(){	
			return "";
	}
	
	function FilterSKPD($prefix='', $tblwidth='100%', $kol1_width=100,$mode='',$c1='',$c='',$d='',$e='',$e1='') {
    //global $DisAbled;
    global $Main, $fmURUSAN, $fmWIL, $fmSKPD, $fmUNIT, $fmSUBUNIT,$fmSEKSI, $fmTAHUNANGGARAN, $fmKEPEMILIKAN, $Main, $HTTP_COOKIE_VARS, $Pg, $SPg;
    //$disSKPD = ""; $disUNIT = ""; $disSUBUNIT = "";
    //echo "<br>Group=".login_getGroup();
	$disURUSAN =  $DisAbled;
    $disSKPD = $DisAbled;
    $disUNIT = $DisAbled;
    $disSUBUNIT = $DisAbled;
    $disSEKSI = $DisAbled;
	$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );

    $KondisiURUSAN = "";
	$KondisiSKPD = "";
    $KondisiUNIT = "";
    $KondisiSUBUNIT = "";
    $KondisiSEKSI = "";

    $PilihURUSAN = "<option value='00'>--- Semua URUSAN ---</option>";
	$PilihSKPD = "<option value='00'>--- Semua BIDANG ---</option>";
    $PilihUNIT = "<option value='00'>--- Semua SKPD ---</option>";
    $PilihSUBUNIT = "<option value='00'>--- Semua UNIT ---</option>";
    $PilihSEKSI = "<option value='$kdSubUnit0'>--- Semua SUB UNIT ---</option>";

    $fmURUSAN = $_REQUEST[$prefix.'fmURUSAN'];
	$fmSKPD = $_REQUEST[$prefix.'fmSKPD'];
	$fmUNIT = $_REQUEST[$prefix.'fmUNIT'];
	$fmSUBUNIT = $_REQUEST[$prefix.'fmSUBUNIT'];
	$fmSEKSI = $_REQUEST[$prefix.'fmSEKSI'];

	if ($HTTP_COOKIE_VARS["coURUSAN"] !== "0") {
        $fmURUSAN = $HTTP_COOKIE_VARS["coURUSAN"];
        $HTTP_COOKIE_VARS["cofmURUSAN"] = $fmURUSAN;
        $KondisiURUSAN = " and c1='$fmURUSAN'";
        $PilihURUSAN = "";
    }
	else{
		// $KondisiSKPD = " and d='00' ";
		if (isset($c1)) {
			$fmURUSAN = $c1;
	    }else{
	    	$fmURUSAN = $HTTP_COOKIE_VARS['cofmURUSAN'];
		}
		if(!($fmURUSAN == '00' || $fmURUSAN=='')){
			//$KondisiSKPD = " and c='$fmSKPD'";//$PilihSKPD = "";
		}

	}
	if ($HTTP_COOKIE_VARS["coSKPD"] !== "00") {
        $fmSKPD = $HTTP_COOKIE_VARS["coSKPD"];
        $HTTP_COOKIE_VARS["cofmSKPD"] = $fmSKPD;
        $KondisiSKPD = " and c='$fmSKPD'";
        $PilihSKPD = "";
    }
	else{
		// $KondisiSKPD = " and d='00' ";
		if (isset($c)) {
			$fmSKPD = $c;
	    }else{
	    	$fmSKPD = $HTTP_COOKIE_VARS['cofmSKPD'];
		}
		if(!($fmSKPD == '00' || $fmSKPD=='')){
			//$KondisiSKPD = " and c='$fmSKPD'";//$PilihSKPD = "";
		}

	}
	if ($HTTP_COOKIE_VARS["coUNIT"] !== "00") {
        $fmUNIT = $HTTP_COOKIE_VARS["coUNIT"];
        $HTTP_COOKIE_VARS["cofmUNIT"] = $fmUNIT;
        $KondisiUNIT = " and d='$fmUNIT'";
        $PilihUNIT = "";
    }
	else{
		if (isset($d)) {
			$fmUNIT = $d;
	    }else{
	    	$fmUNIT = $HTTP_COOKIE_VARS['cofmUNIT'];
		}
		if(!($fmUNIT == '00' || $fmUNIT=='')){
			//$KondisiUNIT = " and d='$fmUNIT'";//$PilihUNIT = "";
		}

	}

	if ($HTTP_COOKIE_VARS["coSUBUNIT"] !== "00") {
        $fmSUBUNIT = $HTTP_COOKIE_VARS["coSUBUNIT"];
        $HTTP_COOKIE_VARS["cofmSUBUNIT"] = $fmSUBUNIT;
        $KondisiSUBUNIT = " and e='$fmSUBUNIT'";
        $PilihSUBUNIT = "";
    }
	else{

		if (isset($e)) {
			$fmSUBUNIT = $e;
	    }else{
	    	$fmSUBUNIT = $HTTP_COOKIE_VARS['cofmSUBUNIT'];
		}
		if(!($fmSUBUNIT == '00' || $fmSUBUNIT=='')){
			//$KondisiSUBUNIT = " and e='$fmSUBUNIT'";//$PilihSUBUNIT = "";
		}

	}

	if (($HTTP_COOKIE_VARS["coSEKSI"] !== "00") && ($HTTP_COOKIE_VARS["coSEKSI"] !== "000")) {
        $fmSEKSI = $HTTP_COOKIE_VARS["coSEKSI"];
        $HTTP_COOKIE_VARS["cofmSEKSI"] = $fmSEKSI;
        $KondisiSEKSI = " and e1='$fmSEKSI'";
        $PilihSEKSI = "";
    }
	else{

		if (isset($e1)) {
			$fmSEKSI = $e1;
	    }else{
	    	$fmSEKSI = $HTTP_COOKIE_VARS['cofmSEKSI'];
		}
		if(!($fmSEKSI == '00' || $fmSEKSI=='' || $fmSEKSI=='000')){
			//$KondisiSUBUNIT = " and e='$fmSUBUNIT'";//$PilihSUBUNIT = "";
		}

	}

	//urusan -------------------
	if($Main->URUSAN==1){
	    //$aqry = "select * from ref_skpd where d='00'  order by c";
	    $aqry = "select * from ref_skpd where 1=1 $KondisiURUSAN and c1<>'0' and c='00' order by c1";
	    $Qry = mysql_query($aqry);
	    $Ops = "";
	    while ($isi = mysql_fetch_array($Qry)) {
	        $sel = $fmURUSAN == $isi['c1'] ? "selected" : "";
	        $Ops .= "<option $sel value='{$isi['c1']}'>{$isi['c1']}. {$isi['nm_skpd']}</option>\n";
			if ($fmURUSAN == $isi['c1']) $nmURUSAN=$isi['nm_skpd'];
	    }
		$ListURUSAN =
			//$cekskpd . 'pref='.$prefix.
			"<div id='".$prefix."CbxUrusan'>
				<select $disURUSAN name='".$prefix."fmURUSAN' id='".$prefix."fmURUSAN'
					onChange=\"".$prefix.".pilihUrusan()\"
				> $PilihURUSAN $Ops</select><div style='display:none'>$aqry</div></div>";

   }

   	//skpd -------------------
    //$aqry = "select * from ref_skpd where d='00'  order by c";
	if($Main->URUSAN==1){
		$aqry = "select * from ref_skpd where   c1='$fmURUSAN'  and c<>'00' and d='00' order by c";
	}else{
		$aqry = "select * from ref_skpd where 1=1 $KondisiSKPD and c<>'00' and d='00' order by c";
	}
    $Qry = mysql_query($aqry);
    $Ops = "";
    while ($isi = mysql_fetch_array($Qry)) {
        $sel = $fmSKPD == $isi['c'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['c']}'>{$isi['c']}. {$isi['nm_skpd']}</option>\n";
		if ($fmSKPD == $isi['c']) $nmskpd=$isi['nm_skpd'];
    }
	$ListSKPD =
		//$cekskpd . 'pref='.$prefix.
		"<div id='".$prefix."CbxBidang'>
			<select $disSKPD name='".$prefix."fmSKPD' id='".$prefix."fmSKPD'
				onChange=\"".$prefix.".pilihBidang()\"
			> $PilihSKPD $Ops</select><div style='display:none'>$aqry</div></div>";

	//unit ------------------------
	if($Main->URUSAN){
		$aqry ="select * from ref_skpd where c1='$fmURUSAN' and  c='$fmSKPD' and d <> '00' and e = '00' $KondisiUNIT order by d";
	}else{
		$aqry ="select * from ref_skpd where c='$fmSKPD' and d <> '00' and e = '00' $KondisiUNIT order by d";
	}
	$Qry = mysql_query($aqry);
    $Ops = "";
    while ($isi = mysql_fetch_array($Qry)) {
        $sel = $fmUNIT == $isi['d'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['d']}'>{$isi['d']}. {$isi['nm_skpd']}</option>\n";
		if ($fmUNIT == $isi['d']) $nmunit=$isi['nm_skpd'];

    }
    $ListUNIT =
		"<div id='".$prefix."CbxUnit'>
			<select $disUNIT name='".$prefix."fmUNIT' id='".$prefix."fmUNIT'
				onChange=\"".$prefix.".pilihUnit()\">
				$PilihUNIT $Ops
			</select><div style='display:none'>$aqry</div></div>";

	//sub unit -------------------------
	$kdSubUnit0 = genNumber(0, $Main->SUBUNIT_DIGIT );
	if($Main->URUSAN){
		$aqry = "select * from ref_skpd where c1='$fmURUSAN' and  c='$fmSKPD' and d = '$fmUNIT' and e <> '00' and e1='$kdSubUnit0' $KondisiSUBUNIT order by e";
	}else{
		$aqry = "select * from ref_skpd where c='$fmSKPD' and d = '$fmUNIT' and e <> '00' and e1='$kdSubUnit0' $KondisiSUBUNIT order by e";
	}
	$Qry = mysql_query($aqry);
    $Ops = "";
    while ($isi = mysql_fetch_array($Qry)) {
        $sel = $fmSUBUNIT == $isi['e'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['e']}'>{$isi['e']}. {$isi['nm_skpd']}</option>\n";
		if ($fmSUBUNIT == $isi['e']) $nmsubunit=$isi['nm_skpd'];

    }
	$aqry='';
    $ListSUBUNIT = "<div id='".$prefix."CbxSubUnit'><select $disSUBUNIT name='".$prefix."fmSUBUNIT'
		id='".$prefix."fmSUBUNIT'
			onChange=\"".$prefix.".pilihSubUnit()\"
		>	$PilihSUBUNIT $Ops</select></div>";

	//seksi -------------------------
	if($Main->URUSAN){
	    $Qry = mysql_query("select * from ref_skpd where  c1='$fmURUSAN' and c='$fmSKPD' and d = '$fmUNIT' and e = '$fmSUBUNIT' and e1 <> '$kdSubUnit0' $KondisiSEKSI order by e1");
	}else{
	    $Qry = mysql_query("select * from ref_skpd where c='$fmSKPD' and d = '$fmUNIT' and e = '$fmSUBUNIT' and e1 <> '$kdSubUnit0' $KondisiSEKSI order by e1");
	}
    $Ops = "";
    while ($isi = mysql_fetch_array($Qry)) {
        $sel = $fmSEKSI == $isi['e1'] ? "selected" : "";
        $Ops .= "<option $sel value='{$isi['e1']}'>{$isi['e1']}. {$isi['nm_skpd']}</option>\n";
		if ($fmSEKSI == $isi['e1']) $nmseksi=$isi['nm_skpd'];

    }
    $ListSEKSI = "<div id='".$prefix."CbxSeksi'><select $disSEKSI name='".$prefix."fmSEKSI'
		id='".$prefix."fmSEKSI'
			onChange=\"".$prefix.".pilihSeksi()\"
		>	$PilihSEKSI $Ops</select></div>";


	if($Main->URUSAN){
		if ($mode=='1'){
			$vURUSAN = "<tr valign=\"top\"> <td width='$kol1_width'>URUSAN</td> <td width='10'>:</td> <td>
				<input type=text > name='".$prefix."nmURUSAN' id='".$prefix."nmSKPD' value='$nmURUSAN' >
				<input type=hidden > name='".$prefix."fmURUSAN' id='".$prefix."fmURUSAN' value='$fmURUSAN' >
				</td> </tr>";
		}
		else{
			$vURUSAN = "<tr valign=\"top\"> <td width='$kol1_width'>URUSAN</td> <td width='10'>:</td> <td>$ListURUSAN</td> </tr> ";
		}

	}

	if($mode=='1'){
    $Hsl = "
		<!--<script src='js/skpd.js' type='text/javascript'></script>-->
		<div style='float: left; width: 90%; height: auto; padding: 4px;'>
			<table width=\"100%\"   >
				$vURUSAN
				<tr valign=\"top\"> <td width='$kol1_width'>BIDANG</td> <td width='10'>:</td> <td>
				<input type=text > name='".$prefix."nmSKPD' id='".$prefix."nmSKPD' value='$nmskpd' >
				<input type=hidden > name='".$prefix."fmSKPD' id='".$prefix."fmSKPD' value='$fmSKPD' >
				</td> </tr>
				<tr valign=\"top\"> <td>SKPD</td> <td>:</td> <td>
				<input type=text > name='".$prefix."nmUNIT' id='".$prefix."nmUNIT' value='$nmunit' >
				<input type=hidden > name='".$prefix."fmUNIT' id='".$prefix."fmUNIT' value='$fmUNIT' >

				</td> </tr>
				<tr valign=\"top\"> <td>UNIT</td> <td>:</td> <td>
				<input type=text > name='".$prefix."nmSUBUNIT' id='".$prefix."nmSUBUNIT' value='$nmsubunit' >
				<input type=hidden > name='".$prefix."fmSUBUNIT' id='".$prefix."fmSUBUNIT' value='$fmSUBUNIT' >

				</td> </tr>
				<tr valign=\"top\"> <td>SUB UNIT</td> <td>:</td> <td>
				<input type=text > name='".$prefix."nmSEKSI' id='".$prefix."nmSEKSI' value='$nmseksi' >
				<input type=hidden > name='".$prefix."fmSEKSI' id='".$prefix."fmSEKSI' value='$fmSEKSI' >

				</td> </tr>
			</table>
		</div>
	";

	}
	else {



    $Hsl = "
		<!--<script src='js/skpd.js' type='text/javascript'></script>-->
		<div style='float: left; width: 90%; height: auto; padding: 4px;'>
			<table width=\"100%\"   >
				$vURUSAN
				<tr valign=\"top\"> <td width='$kol1_width'>BIDANG</td> <td width='10'>:</td> <td>$ListSKPD</td> </tr>
				<tr valign=\"top\"> <td>SKPD</td> <td>:</td> <td>$ListUNIT</td> </tr>
				<tr valign=\"top\"> <td>UNIT</td> <td>:</td> <td>$ListSUBUNIT</td> </tr>
				<tr valign=\"top\"> <td>SUB UNIT</td> <td>:</td> <td>$ListSEKSI</td> </tr>
			</table>
		</div>
	";
	}

    return $Hsl;
}
	
	function genDaftarInitial($c1,$c,$d,$e,$e1){
		$vOpsi = $this->genDaftarOpsi();
		return
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>
			<input type='hidden' value=".$c1." name='c1'> 
			<input type='hidden' value=".sprintf("%02s",$c)." name='c'> 
			<input type='hidden' value=".sprintf("%02s",$d)." name='d'> 
			<input type='hidden' value=".sprintf("%02s",$e)." name='e'> 
			<input type='hidden' value=".sprintf("%03s",$e1)." name='e1'>". 
				$vOpsi['TampilOpt'].
			"</div>".					
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".	
				//$this->genDaftar($Opsi['Kondisi'],$Opsi['Order'], $Opsi['Limit'], $Opsi['NoAwal']).									
			"</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='$this->elCurrPage' name='$this->elCurrPage' value='1'>".
			"</div>";
	}
	
	function genDaftarOpsi(){
		global $Main;
		//tampil -------------------------------
		$c1 = $_REQUEST['c1'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$e1 = $_REQUEST['e1'];
		$TampilOpt =
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<td width=\"100%\" valign=\"top\">			
				" . $this->FilterSKPD($this->Prefix.'Skpd','','','',$c1,$c,$d,$e,$e1) . 
			"</td>			
			</tr></table>
				<table width=\"100%\" class=\"adminform\" style=\"margin: 4 0 0 0;\">
					<tbody>
					<tr valign=\"top\">
						<td> 
							<div style=\"float:left\">". 
								"<input type=\"button\" onclick=\"".$this->Prefix.".lodingdaftar()\" value=\"Tampilkan\">&nbsp;&nbsp;
								
							</div>
						</td>
					</tr>
					</tbody>
				</table>";
		return array('TampilOpt'=>$TampilOpt);
	}
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		
		$Kondisi=''; $Order = ''; $Limit=''; $NoAwal = 0; $cek ='';
		
		/*$fmURUSAN = isset($HTTP_COOKIE_VARS['coURUSAN'])? $HTTP_COOKIE_VARS['cofmURUSAN']: cekPOST('c1');
		$fmSKPD = isset($HTTP_COOKIE_VARS['cofmSKPD'])? $HTTP_COOKIE_VARS['cofmSKPD']: cekPOST('c');
		$fmUNIT = isset($HTTP_COOKIE_VARS['cofmUNIT'])? $HTTP_COOKIE_VARS['cofmUNIT']: cekPOST('d');
		$fmSUBUNIT = isset($HTTP_COOKIE_VARS['cofmSUBUNIT'])? $HTTP_COOKIE_VARS['cofmSUBUNIT']: cekPOST('e');		
		$fmSEKSI = isset($HTTP_COOKIE_VARS['cofmSEKSI'])? $HTTP_COOKIE_VARS['cofmSEKSI']: cekPOST('e1');*/
		/*$fmURUSAN = $_REQUEST['kodetanahSkpdfmURUSAN']==00 ? '':cekPOST('c1');
		$fmSKPD = $_REQUEST['kodetanahSkpdfmSKPD']==00 ? '':cekPOST('c');
		$fmUNIT = $_REQUEST['kodetanahSkpdfmUNIT']==00 ? '':cekPOST('d');
		$fmSUBUNIT = $_REQUEST['kodetanahSkpdfmSUBUNIT']==00 ? '':cekPOST('e');
		$fmSEKSI = $_REQUEST['kodetanahSkpdfmSEKSI']==00 ? '':cekPOST('e1');*/
		/*if($_REQUEST['kodetanahSkpdfmSKPD']==00){
			$fmSKPD = cekPOST('c');
		}*/
		if($_REQUEST['kodetanahSkpdfmURUSAN']==00){
			$fmURUSAN = $_REQUEST['kodetanahSkpdfmURUSAN'];
		}elseif($_REQUEST['kodetanahSkpdfmURUSAN']!=$_REQUEST['c1']){
			$fmURUSAN = $_REQUEST['kodetanahSkpdfmURUSAN'];
		}else{
			$fmURUSAN = $_REQUEST['c1'];
		}
		if($_REQUEST['kodetanahSkpdfmSKPD']==00){
			$fmSKPD = $_REQUEST['kodetanahSkpdfmSKPD'];
		}elseif($_REQUEST['kodetanahSkpdfmSKPD']!=$_REQUEST['c']){
			$fmSKPD = $_REQUEST['kodetanahSkpdfmSKPD'];
		}else{
			$fmSKPD = $_REQUEST['c'];
		}
		if($_REQUEST['kodetanahSkpdfmUNIT']==00){
			$fmUNIT = $_REQUEST['kodetanahSkpdfmUNIT'];
		}elseif($_REQUEST['kodetanahSkpdfmUNIT']!=$_REQUEST['d']){
			$fmUNIT = $_REQUEST['kodetanahSkpdfmUNIT'];
		}else{
			$fmUNIT = $_REQUEST['d'];
		}		
		if($_REQUEST['kodetanahSkpdfmSUBUNIT']==00){
			$fmSUBUNIT = $_REQUEST['kodetanahSkpdfmSUBUNIT'];
		}elseif($_REQUEST['kodetanahSkpdfmSUBUNIT']!=$_REQUEST['e']){
			$fmSUBUNIT = $_REQUEST['kodetanahSkpdfmSUBUNIT'];
		}else{
			$fmSUBUNIT = $_REQUEST['e'];
		}		
		if($_REQUEST['kodetanahSkpdfmSEKSI']==000){
			$fmSEKSI = $_REQUEST['kodetanahSkpdfmSEKSI'];
		}elseif($_REQUEST['kodetanahSkpdfmSEKSI']!=$_REQUEST['e1']){
			$fmSEKSI = $_REQUEST['kodetanahSkpdfmSEKSI'];
		}else{
			$fmSEKSI = $_REQUEST['e1'];
		}
		/*$fmURUSAN = cekPOST('c1');
		$fmSKPD = cekPOST('c');
		$fmUNIT = cekPOST('d');
		$fmSUBUNIT = cekPOST('e');		
		$fmSEKSI = cekPOST('e1');*/		
		
		//Kondisi -------------------------		
		$arrKondisi= array();		
		$arrKondisi[] = getKondisiSKPD2(
			$Main->DEF_KEPEMILIKAN, 
			$Main->Provinsi[0], 
			$Main->DEF_WILAYAH, 			 
			$fmSKPD, 
			$fmUNIT, 
			$fmSUBUNIT,
			$fmSEKSI,
			$fmURUSAN
		);
		
		//status kondisi
		$Kondisi = join(' and ',$arrKondisi); $cek .=$Kondisi;
		if($Kondisi !='') $Kondisi = ' Where '.$Kondisi;
		
		//order ---------------------------
		$OrderArr= array();	
		/*$fmDESC1 = $_POST['fmDESC1'];
		$AscDsc1 = $fmDESC1 == 1? 'desc' : '';
		
		switch($fmORDER1){
			case '1': $OrderArr[] =  " thn_perolehan $AscDsc1 "; break;
			case '2': $OrderArr[] =  " kondisi $AscDsc1 "; break;
			case '3': $OrderArr[] =  " year(tgl_buku) $AscDsc1 "; break;			
		}
		*/
		
		//limit --------------------------------------
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal;
		$Limit = $Mode == 3 ? '': $Limit;
		//$Limit = '';
		//$Limit = ' limit 0,1 '; //tes akuntansi
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;
		
		$Order = join(', ',$OrderArr); 
		if($Order !='') $Order = ' Order by '.$Order;
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order, 'Limit'=>$Limit,'NoAwal'=>$NoAwal,'cek'=>$cek);
	
	}
	
	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
							
						});
						
						
					</script>";
		return "<script src='js/skpd.js' type='text/javascript'></script>				
				<script type='text/javascript' src='js/kodetanah/".strtolower($this->Prefix).".js' language='JavaScript' ></script>".
				$scriptload;
	}
	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$cetak = $Mode==2 || $Mode==3 ;
		
		$headerTable =
				"<tr>
				<th class='th01' width='20'>No.</th>
  	  			$Checkbox 		
   	   			<th class='th01' >Kode/Nama Barang</th>
   	   			<th class='th01' >Alamat</th>
   	   			<th class='th01' >Kota</th>
				</tr>";
				//$tambahgaris";
		return $headerTable;
	}
	
	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Main,$HTTP_COOKIE_VARS;		
		$KondisiKIB = "	where a1= '{$isi['a1']}' and a = '{$isi['a']}' and 	c = '{$isi['c']}' and d = '{$isi['d']}' and e = '{$isi['e']}' and e1 = '{$isi['e1']}' and 
					$KondF and 
					tahun = '{$isi['thn_perolehan']}' and noreg = '{$isi['noreg']}'  ";
		$ISI5 	= !empty($ISI5)?$ISI5:"-"; 
		$ISI6 	= !empty($ISI6)?$ISI6:"-";
		
		$kdBarang = $Main->KD_BARANG_P108?$isi['f1'].'.'.$isi['f2'].'.'.$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j']:$isi['f'].'.'.$isi['g'].'.'.$isi['h'].'.'.$isi['i'].'.'.$isi['j'];
		$qry_brg=mysql_query("SELECT
								  `bb`.`nm_barang`
								FROM
								  `penilaian` `aa` LEFT JOIN
								  `ref_barang` `bb` ON `aa`.`f1` = `bb`.`f1` AND `aa`.`f2` = `bb`.`f2`  AND `aa`.`f` = `bb`.`f` AND `aa`.`g` = `bb`.`g` AND
								  `aa`.`h` = `bb`.`h` AND `aa`.`i` = `bb`.`i` AND `aa`.`j` = `bb`.`j`    
								WHERE aa.id='".$isi['id']."'");
		$res = mysql_fetch_array($qry_brg);
		
		$nm_kota="";
		$nm_kec ="";
		$get = mysql_fetch_array(mysql_query(
				"select * from ref_kotakec where kd_kota='".$isi['alamat_b']."'  and kd_kec='0'"
			));
			if($get['nm_wilayah']<>'') $nm_kota = $get['nm_wilayah'];
		$nm_kota = $nm_kota!=""?$nm_kota: $isi['kota'];

		$get = mysql_fetch_array(mysql_query(
		"select * from ref_kotakec where kd_kota='".$isi['alamat_b']."'  and kd_kec='".$isi['alamat_c']."'"
			));
			if($get['nm_wilayah']<>'') $nm_kec = $get['nm_wilayah'];
		$nm_kec = $nm_kec!="" ? $nm_kec: $isi['alamat_kec'];

		$alm = '';
		$alm .= ifempty($isi['alamat'],'-');
		$alm .= ($isi['rt'] && $isi['rw']) == ''? '' : '<br>RT/RW. '.$isi['rt'].'/'.$isi['rw'];
		$alm .= $isi['kampung'] == ''? '' : '<br>Kp/Komp. '.$isi['kampung'];
		$alm .= $isi['alamat_kel'] != ''? '<br>Kel/Desa. '.$isi['alamat_kel'] : '';
		$alm .= $nm_kec != ''? '<br>Kec. '.$nm_kec : '';
		//$alm .= $isi['alamat_kota'] != ''? '<br>'.$nm_kota : '';
				
			$Koloms[] = array('align="center" width="20"', $no.'.' );
 			if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);
	 		$Koloms[] = array('align="left" "',$kdBarang.'/'.$isi['nm_barang']);
	 		$Koloms[] = array('align="left" "',$alm);
			$Koloms[] = array('align="left" "',$nm_kota);				

		return $Koloms;
	}
	
	function set_selector_other($tipe){
		global $Main;
		$cek = ''; $err=''; $content=''; $json=TRUE;
		switch($tipe){	
			case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
				break;
			}
			case 'getdata':{
				$err='';
				$id = $_REQUEST['id'];
				$isi = mysql_fetch_array( mysql_query("select * from $this->TblName where id='$id'"));
				
				$aqry = "select kd_kec,nm_wilayah from ref_kotakec where kd_kec!='0' and kd_kota=".$isi['alamat_b']." order by nm_wilayah"; $cek .= $aqry;
				//$err='cek='.$aqry;
				$el_kode = $isi['f'].$isi['g'].$isi['h'].$isi['i'].$isi['j'].$isi['noreg'];//$isi['idall'];
				$el_alamat = $isi['alamat'];
				$el_kampung = $isi['kampung'];
				$el_rt= $isi['rt'];
				$el_rw = $isi['rw'];
				$el_alamatb = $isi['alamat_b'];
				$isi['alamat_c'] = $isi['alamat_c'];
				$gen_alamatc = cmbQuery('alamat_c',$isi['alamat_c'],$aqry); //$isi['alamat_c'];
				$el_kota = $isi['kota'];
				$el_kec = $isi['alamat_kec'];
				$el_kel = $isi['alamat_kel'];
				$el_koorgps = $isi['koordinat_gps'];
				$el_koorbidang = $isi['koord_bidang'];
				$el_luas = $isi['luas'];
				$content = array('el_kode'=>$el_kode,
								'el_alamat'=>$el_alamat,
								'el_kampung'=>$el_kampung,
								'el_rt'=>$el_rt,
								'el_rw'=>$el_rw,
								'el_alamatb'=>$el_alamatb,
								'el_alamatc'=>$gen_alamatc,
								'el_kota'=>$el_kota,
								'el_kec'=>$el_kec,
								'el_kel'=>$el_kel,
								'el_koorgps'=>$el_koorgps,
								'el_koorbidang'=>$el_koorbidang,
								'el_luas'=>$el_luas,
								);	
				break;
		   }
			
		}
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}	
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = 'kodetanahForm';
		
		$kib = $_REQUEST['kib'];
		$c1 = $_REQUEST['c1'];
		$c = $_REQUEST['c'];
		$d = $_REQUEST['d'];
		$e = $_REQUEST['e'];
		$e1 = $_REQUEST['e1'];
		
		if($err==''){
			$FormContent = $this->genDaftarInitial($c1,$c,$d,$e,$e1);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						1000,
						500,
						'CARI KODE TANAH',
						'',
						"<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave($kib)' >&nbsp;".
						"<input type='button' value='Close' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height,
						'',$params
					).
					"</form>");
			//);
			$content = $form;//$content = 'content';	
		}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}		
}
$kodetanah = new kodetanahObj();

?>