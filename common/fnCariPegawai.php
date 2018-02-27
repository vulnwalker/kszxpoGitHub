<?php

class fnCariPegawaiObj  extends DaftarObj2{	
	var $Prefix = 'fnCariPegawai';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_pegawai'; //daftar 
	var $TblName_Hapus = 'ref_pegawai';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'REFERNSI PEGAWAI';
	var $PageIcon = 'images/masterdata_ico.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'Referensi Pegawai';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'fnCariPegawaiForm'; 
	var $kdbrg = '';	
			
	function setTitle(){
		return 'REFERENSI PEGAWAI';
	}
	
	function setMenuView(){
		return "";
	}
	
	function setMenuEdit(){		
		return ""
			;
	}
	
	function setCetak_Header($Mode=''){
		global $Main, $HTTP_COOKIE_VARS;
		
		return
			"<table style='width:100%' border=\"0\">
			<tr>
				<td class=\"judulcetak\">".$this->setCetakTitle()."</td>
			</tr>
			</table>";	
	}	
	
	function set_selector_other2($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;	
	 return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
	}
	
	function set_selector_other($tipe){
	 global $Main;
	 $cek = ''; $err=''; $content=''; $json=TRUE;
	  
	  switch($tipe){
	  	
		case 'getdata':{
				$Id = $_REQUEST['id'];
				$get = mysql_fetch_array( mysql_query("select * from ref_pegawai where Id='$Id'"));
				$cek.="select * from ref_bank where Id='$Id'";
				$content = array('nm_pegawai' => $get['nama'], 'nip_pegawai' => $get['nip']);	
		break;
	    }
		
		case 'windowshow':{
				$fm = $this->windowShow();
				$cek = $fm['cek'];
				$err = $fm['err'];
				$content = $fm['content'];	
		break;
		}
		
		 default:{
				$other = $this->set_selector_other2($tipe);
				$cek = $other['cek'];
				$err = $other['err'];
				$content=$other['content'];
				$json=$other['json'];
		 break;
		 }
		 
	 }//end switch
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content, 'json'=>$json);
   }
   
   	function setPage_OtherScript(){
		$scriptload = 
					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
					</script>";
					
		return 
			 "<script src='js/skpd.js' type='text/javascript'></script>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<script type='text/javascript' src='js/skpd.js' language='JavaScript' ></script>".
			"<link rel='stylesheet' href='css/template_css.css' type='text/css'>".
			"<link href='css/ui-lightness/jquery-ui-1.10.3.custom.css' rel='stylesheet'>".
			"<link rel='stylesheet' href='css/upload_style.css' type='text/css'>".
			"<script src='js/jquery.js' type='text/javascript'></script>".			
			"<script src='js/jquery-ui.js' type='text/javascript'></script>".
			"<script src='js/jquery.min.js' type='text/javascript'></script>
			<script type='text/javascript' src='js/jquery.form.js'></script> ".
			"<script src='js/jquery-ui.custom.js'></script>".
			"<script type='text/javascript' src='js/fnCariPegawai.js' language='JavaScript' ></script>".
			
			$scriptload;
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		
			$FormContent = $this->genDaftarInitial();
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						800,
						500,
						'Pilih Pegawai',
						'',
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='".$this->Prefix."_fmST' name='".$this->Prefix."_fmST' value='$this->form_fmST' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >"
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
		$NomorColSpan = $Mode==1? 2: 1;
		$headerTable =
			"<thead>
				<tr>
				<th class='th01' width='40'>No.</th>	
				<th class='th01' width=150>NIP</th>
				<th class='th01' >NAMA </th>
				<th class='th01' >JABATAN </th>								
				</tr>
			</thead>";
		return $headerTable;
	}
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
		global $Ref;
		$Koloms = array();
		$Koloms[] = array('align=right', $no.'.' );
		$Koloms[] = array('align="left" width="" ',"<a style='cursor:pointer;' onclick=fnCariPegawai.windowSave('".$isi['Id']."')>".$isi['nip']."</a>");
	//	$Koloms[] = array('', $isi['nip']);		
		$Koloms[] = array('', $isi['nama'] );
		$Koloms[] = array('', $isi['jabatan']);				
		return $Koloms;
	}
		
	function genDaftarOpsi(){
	global $Ref, $Main;
	$fmUrusan = cekPOST('fmUrusan');
	$fmBidang = cekPOST('fmBidang');
	$fmSkpd = cekPOST('fmSkpd');
	$fmUnit = cekPOST('fmUnit');
	$fmSubUnit = cekPOST('fmSubUnit');
	
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	 $arrOrder = array(
	  	         array('1','Nip'),
			     array('2','Nama'),
					);
	$arr = array(
			//array('selectAll','Semua'),	
			array('selectNip','Nip'),	
			array('selectNama','Nama'),		
			);
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<table width=\"100%\" class=\"adminform\">	<tr>		
			<table style='width:100%'>
			<tr>
			<td style='width:100px'>URUSAN</td><td style='width:10px'>:</td>
			<td>".
			cmbQuery1("fmUrusan",$fmUrusan,"select c1,nm_skpd from ref_skpd where c1!='0' and c ='00' and d = '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>BIDANG</td><td>:</td>
			<td>".
			cmbQuery1("fmBidang",$fmBidang,"select c,nm_skpd from ref_skpd where c1='$fmUrusan' and c!='00' and d = '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr><tr>
			<td>SKPD</td><td>:</td>
			<td>".
			cmbQuery1("fmSkpd",$fmSkpd,"select d,nm_skpd from ref_skpd where c1='$fmUrusan' and c ='$fmBidang' and d != '00' and e='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td>UNIT</td><td>:</td>
			<td>".
			cmbQuery1("fmUnit",$fmUnit,"select e,nm_skpd from ref_skpd where c1='$fmUrusan' and c ='$fmBidang' and d = '$fmSkpd' and e!='00' and e1='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			<td>SUB UNIT</td><td>:</td>
			<td>".
			cmbQuery1("fmSubUnit",$fmSubUnit,"select e1,nm_skpd from ref_skpd where c1='$fmUrusan' and c ='$fmBidang' and d= '$fmSkpd' and e='$fmUnit' and e1!='000'","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','').
			"</td>
			</tr>
			<tr>
			</table>
			</tr>
			<!--<tr><td>
				<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>			-->
			</table>".
			"<tr><td>".
			"<div id='skpd_pegawai' ></div>".
			$vOrder=			
			genFilterBar(
				array(							
					cmbArray('fmPILCARI',$fmPILCARI,$arr,'-- Cari Data --',''). //generate checkbox				
					"&nbsp&nbsp<input type='text' value='".$fmPILCARIvalue."' name='fmPILCARIvalue' id='fmPILCARIvalue'>&nbsp&nbsp"
					.cmbArray('fmORDER1',$fmORDER1,$arrOrder,'--Urutkan--','').
					"<input $fmDESC1 type='checkbox' id='fmDESC1' name='fmDESC1' value='checked'>&nbspmenurun.
					<input type='hidden'  name='dat_urusan' id='dat_urusan' value='".$Main->URUSAN."' >
					<input type='hidden'  name='master' id='master' value='0' >"
					),			
				$this->Prefix.".refreshList(true)");
			"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>";	
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
	global $Main, $HTTP_COOKIE_VARS;
	
		$cek='';
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
		$fmUrusan = cekPOST('fmUrusan');
	 	$fmBidang = cekPOST('fmBidang');
	    $fmSkpd = cekPOST('fmSkpd');
	    $fmUnit = cekPOST('fmUnit');
	    $fmSubUnit = cekPOST('fmSubUnit');
		
		$a=$Main->Provinsi[0]; 
		$b=$Main->DEF_WILAYAH;
				
		$urusan = $Main->URUSAN;
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		
		$c1 = $_REQUEST['PegawaiPilihSkpdfmURUSAN'];
		$arrKondisi = array();
				
		if(empty($fmUrusan)) {
			$fmBidang = '';
			$fmSkpd='';
			$fmUnit='';
			$fmSubUnit='';
		}
		
		if(empty($fmBidang)) {
			$fmSkpd='';
			$fmUnit='';
			$fmSubUnit='';
		}
		
		if(empty($fmSkpd)) {
			$fmUnit='';
			$fmSubUnit='';
		}
		
		if(empty($fmUnit)) {
			$fmSubUnit='';
		}
		
		if(empty($fmUrusan) && empty($fmBidang) && empty($fmSkpd) && empty($fmUnit) && empty($fmSubUnit))
		{
			$arrKondisi[]= "a= $a and b=$b";
		}
		elseif(!empty($fmUrusan) && empty($fmBidang) && empty($fmSkpd) && empty($fmUnit) && empty($fmSubUnit))
		{
			$arrKondisi[]= "a= $a and b=$b and c1 =$fmUrusan";			
		}
		elseif(!empty($fmUrusan) && !empty($fmBidang) && empty($fmSkpd) && empty($fmUnit) && empty($fmSubUnit))
		{
			$arrKondisi[]= "a= $a and b=$b and c1 =$fmUrusan and c=$fmBidang";
		}
		elseif(!empty($fmUrusan) && !empty($fmBidang) && !empty($fmSkpd) && empty($fmUnit) && empty($fmSubUnit))
		{
			$arrKondisi[]= "a= $a and b=$b and c1 =$fmUrusan and c=$fmBidang and d=$fmSkpd";
		}
		
		elseif(!empty($fmUrusan) && !empty($fmBidang) && !empty($fmSkpd) && !empty($fmUnit) && empty($fmSubUnit))
		{
			$arrKondisi[]= "a= $a and b=$b and c1 =$fmUrusan and c=$fmBidang and d=$fmSkpd and e=$fmUnit";
		}
		
		elseif(!empty($fmUrusan) && !empty($fmBidang) && !empty($fmSkpd) && !empty($fmUnit) && !empty($fmSubUnit))
		{
			$arrKondisi[]= "a= $a and b=$b and  c1 =$fmUrusan and c=$fmBidang and d=$fmSkpd and e=$fmUnit and e1=$fmSubUnit";
		}
		
		$isivalue=explode('.',$fmPILCARIvalue);
		switch($fmPILCARI){			
			case 'selectNip': $arrKondisi[] = " nip like '$fmPILCARIvalue%'"; break;
			case 'selectNama': $arrKondisi[] = " nama like '%$fmPILCARIvalue%'"; break;	
		}			
			
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		if ($urusan==0){
			switch($fmORDER1){
			case '1': $arrOrders[] = " a,b,c,d,e,e1,nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
						}	
		}else{
			switch($fmORDER1){
			case '1': $arrOrders[] = " a,b,c1,c,d,e,e1,nip $Asc1 " ;break;
			case '2': $arrOrders[] = " nama $Asc1 " ;break;
			}	
		}
		
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//limit --------------------------------------
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal, 'cek'=>$cek);
	}
}
$fnCariPegawai = new fnCariPegawaiObj();
?>