<?php

class cr_jurnalObj  extends DaftarObj2{	
	var $Prefix = 'cr_jurnal';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'ref_jurnal'; //daftar
	var $TblName_Hapus = 'ref_jurnal';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('ka','kb','kc','kd','ke','kf');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'Referensi Data';
	var $PageIcon = 'images/masterData_01.gif';
	var $pagePerHal ='';
	var $cetak_xls=TRUE ;
	var $fileNameExcel='usulansk.xls';
	var $Cetak_Judul = 'JURNAL';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cr_jurnalForm'; 	
			
	function setTitle(){
		return 'Daftar Akun';
	}
	function setMenuEdit(){
		return "";
			
	}
	function setMenuView(){
		return "";
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
	
	case 'hapus':{	
		$fm= $this->Hapus($pil);
		$err= $fm['err']; 
		$cek = $fm['cek'];
		$content = $fm['content'];
		break;
		}
	  
	case 'windowshow':{
		$fm = $this->windowShow();
		$cek = $fm['cek'];
		$err = $fm['err'];
		$content = $fm['content'];	
		break;
		}

	   case 'getdata':{
	  // 1.1.0.00.00
	  // =1 1 1 2 0 0
		$Id = $_REQUEST['id'];
		$ka = substr($Id, 0,1);
		$kb = substr($Id, 2,1);
		$kc = substr($Id, 4,1);
		$kd = substr($Id, 6,2);
		$ke = substr($Id, 9,2);
		$kf = substr($Id, 13,1);
	
		$get = mysql_fetch_array( mysql_query("select *, concat(ka,'.',kb,'.',kc,'.',kd,'.',ke,'.',kf) as kodejurnal  from ref_jurnal where ka='$ka' AND kb='$kb' AND kc='$kc' AND kd='$kd' AND ke='$ke' and kf='$kf'"));
	
		$content = array('Id_jurnal' => $Id, 'namajurnal_' => $get['nm_account']);				
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
	
	function Hapus($ids){ //validasi hapus tbl_sppd
		 $err=''; $cek='';
		 $cbid = $_REQUEST[$this->Prefix.'_cb'];
		$this->form_idplh = $cbid[0];
		
		if ($err ==''){
			
		for($i = 0; $i<count($ids); $i++){
		$idplh1 = explode(" ",$ids[$i]);
		$data_c1= $idplh1[0];
	 	$data_c= $idplh1[1];
		$data_d= $idplh1[2];
		$data_e= $idplh1[3];
		$data_e1= $idplh1[4];
		$data_f= $idplh1[5];
		
		
		if ($data_c1 != '0'){
			$sk1="select ka,kb,kc,kd,ke,kf from ref_jurnal where ka='$data_c1' and kb!='0'";
		}
		
		if ($data_c != '0'){
			$sk1="select ka,kb,kc,kd,ke,kf from ref_jurnal where ka='$data_c1' and kb='$data_c' and kc!='0'";
		}
		
		if ($data_d != '0'){
			$sk1="select ka,kb,kc,kd,ke,kf from ref_jurnal where ka='$data_c1'  and kb='$data_c' and kc='$data_d' and kd!='00'";
		}
		if ($data_e != '00'){
			$sk1="select ka,kb,kc,kd,ke,kf from ref_jurnal where ka='$data_c1'  and kb='$data_c' and kc='$data_d' and kd='$data_e' and ke!='00'";
		}
		
		if ($data_e1 != '00'){
			$sk1="select ka,kb,kc,kd,ke,kf from ref_jurnal where ka='$data_c1'  and kb='$data_c' and kc='$data_d' and kd='$data_e' and ke='$data_e' and kf!='0000'";
		}
	//	$err='tes';
		if ($data_f=='0000'){
			$qrycek=mysql_query($sk1);$cek.=$sk1;
			if(mysql_num_rows($qrycek)>0)$err='data tidak bisa di hapus';
		}
		
		
		if($err=='' ){
					$qy = "DELETE FROM ref_jurnal WHERE ka='$data_c1' and kb='$data_c' and kc='$data_d'  and  kd='$data_e' and ke='$data_e1' and kf='$data_f' and  concat (ka,' ',kb,' ',kc,' ',kd,' ',ke,' ',kf) ='".$ids[$i]."' ";$cek.=$qy;
					$qry = mysql_query($qy);
					
			}else{
				break;
			}			
		}
		}
		return array('err'=>$err,'cek'=>$cek);
	}	  
	
	function setPage_OtherScript(){
		$scriptload = 

					"<script>
						$(document).ready(function(){ 
							".$this->Prefix.".loading();
						});
						
					</script>";
					
		return 
			 "<script type='text/javascript' src='js/jurnal_keuangan/jurnal_keuangan_ins.js' language='JavaScript' ></script>".		
			 "<script type='text/javascript' src='js/saldo_awal_keuangan/cr_jurnal.js' language='JavaScript' ></script>".		
			$scriptload;
	}
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';		
		$form_name = $this->FormName;
		$drId=cekPOST('Id');
		$tipe_jurnal=cekPOST('tipe_jurnal');
			$FormContent = $this->genDaftarInitial($fmSKPD, $fmUNIT, $fmSUBUNIT,$tahun_anggaran);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						800,
						500,
						'Pilih Akun',
						'',
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='drId' name='drId' value='$drId' >".
						"<input type='hidden' id='".$this->Prefix."_idplh' name='".$this->Prefix."_idplh' value='$this->form_idplh' >".
						"<input type='hidden' id='tipe_jurnal' name='tipe_jurnal' value='$tipe_jurnal' >".
						"<input type='hidden' id='sesi' name='sesi' value='$sesi' >",
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function genDaftarInitial($nm_account='', $height=''){
		$filterAkun = $_REQUEST['filterAkun'];
		$vOpsi = $this->genDaftarOpsi();
		return			
			"<div id='{$this->Prefix}_cont_title' style='position:relative'></div>". 
			"<div id='{$this->Prefix}_cont_opsi' style='position:relative'>". 		
			"<input type='hidden' id='".$this->Prefix."nm_account' name='".$this->Prefix."nm_account' value='$nm_account'>".
			"<input type='hidden' id='filterAkun' name='filterAkun' value='".$filterAkun."'>".
			"</div>".					
			"<div id=garis style='height:1;border-bottom:1px solid #E5E5E5;'></div>".
			"<div id=contain style='overflow:auto;height:$height;'>".
			"<div id='{$this->Prefix}_cont_daftar' style='position:relative' >".					
			"</div>
			</div>".
			"<div id='{$this->Prefix}_cont_hal' style='position:relative'>".				
				"<input type='hidden' id='".$this->Prefix."_hal' name='".$this->Prefix."_hal' value='1'>".
			"</div>";
	}
		
	//daftar =================================	
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $fmBIDANG = $_REQUEST['fmBIDANG'];
	 $fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
	 $fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
	 $fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];				 
	 $headerTable =
	 "<thead>
	 <tr>
  	   <th class='th01' width='50' >No.</th>	
   	   <th class='th01' align='center' width='100'>Kode Akun</th>
	   <th class='th01' align='center' width='800'>Nama Akun</th>	   	   	   
	   </tr>
	   </thead>";
	
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 global $Main;
		$isi = array_map('utf8_encode', $isi);
//$newke1 = sprintf("%02s", $newke);
	$newkdd = sprintf("%02s",$isi['kd']);
	$newkee = sprintf("%02s",$isi['ke']);
//	 $kode_jurnal=$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.$newkdd.'.'.$isi['ke'];
	 $kode_jurnal=$isi['ka'].'.'.$isi['kb'].'.'.$isi['kc'].'.'.$newkdd.'.'.$newkee;
	 $Koloms = array();
	 $Koloms[] = array('align="center" width=""', $no.'.' );
	 $Koloms[] = array('align="left" width="" ',"<a style='cursor:pointer;' onclick=cr_jurnal.windowSave('".$kode_jurnal."')>".$kode_jurnal."</a>");
	// $Koloms[] = array('align="center" width="" ',$kode_jurnal);
 	 $Koloms[] = array('align="left" width=""',$isi['nm_account']);	 	 	 	 
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main,  $HTTP_COOKIE_VARS;
	 
	 $cek = '';

	$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmAKUN = cekPOST('fmAKUN');
	//$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];	
	$filterAkun = cekPOST('filterAkun');
	$drId = $_REQUEST['drId'];			
//	$drId=cekPOST('drId');
	
	
	 $arr = array(
			//array('selectAll','Semua'),
			array('selectfg','Kode Barang'),
			array('selectbarang','Nama Barang'),	
			);
		
		
	//data order ------------------------------
	 $arrOrder = array(
	  	         array('1','Kode Barang'),
			     array('2','Nama Barang'),	
	 );	
	 
	 $arrayRekening1 = array(
								array('1', '1.ASET'),
								array('2', '2.KEWAJIBAN'),
								array('3', '3.EKUITAS'),
								);
	$arrayRekening2 = array(
								array('4', '4.PENDAPATAN LRA'),
								array('5', '5.BELANJA'),
								array('6', '6.TRANFER'),
								array('7', '7.PEMBIAYAN'),
								);
								
	$arrayRekening3 = array(
								array('8', '8.PENDAPATAN - LO'),
								array('9', '9.BEBAN'),
								);							
	$filterRekening = $_REQUEST['filterRekening'];	
	$tp_jurnal=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where Id='$drId'"));
	if($tp_jurnal['tipe_jurnal']=='1'){
		$listBidang = cmbArray('fmBIDANG',$fmBIDANG,$arrayRekening1,'Pilih',"onchange = $this->Prefix.refreshList(true);");
		
	}elseif($tp_jurnal['tipe_jurnal']=='2'){
		$listBidang = cmbArray('fmBIDANG',$fmBIDANG,$arrayRekening2,'Pilih',"onchange = $this->Prefix.refreshList(true);");
		
	}elseif($tp_jurnal['tipe_jurnal']=='3'){
		$listBidang = cmbArray('fmBIDANG',$fmBIDANG,$arrayRekening3,'Pilih',"onchange = $this->Prefix.refreshList(true);");
		
	}else{
		$listBidang = 'salah';
	}
	
	if($arrakun['0'] == '') 
	$listBidang;
	
	if($arrakun['1'] == '') $listKelompok = cmbQuery1("fmKELOMPOK",$fmKELOMPOK,"select kb,nm_account from ref_jurnal where ka='$fmBIDANG' and kb<>'0' and kc='0' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','');
	
	if($arrakun['2'] == '') $listSubKelompok = cmbQuery1("fmSUBKELOMPOK",$fmSUBKELOMPOK,"select kc,nm_account from ref_jurnal where ka='$fmBIDANG' and kb ='$fmKELOMPOK' and kc<>'0' and kd='0' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','');
	
	if($arrakun['3'] == '') $listSubSubKelompok = cmbQuery1("fmSUBSUBKELOMPOK",$fmSUBSUBKELOMPOK,"select kd,nm_account from ref_jurnal where ka='$fmBIDANG' and kb ='$fmKELOMPOK' and kc = '$fmSUBKELOMPOK' and kd<>'0' and ke='0' ","onChange=\"$this->Prefix.refreshList(true)\"",'Pilih','');
	
	
	if($Main->SHOW_CEK== FALSE) $cek = '';
				
	$TampilOpt = 
			//"<tr><td>".	
			"<div style='display:none;'> $cek </div>".
			"<div class='FilterBar'>".
						
			"<table style='width:100%'>
			<tr>
			<td style='width:150px'>BIDANG</td><td style='width:10px'>:</td>
			<td>".
			$listBidang.
			"</td>
			</tr><tr>
			<td>KELOMPOK</td><td>:</td>
			<td>".
			$listKelompok.
			"</td>
			</tr><tr>
			<td>SUB KELOMPOK</td><td>:</td>
			<td>".
			$listSubKelompok.
			"</td>
			</tr><tr>
			<td>SUB SUB KELOMPOK</td><td>:</td>
			<td>".
			$listSubSubKelompok.
			"</td>
			</tr>
			
			</table>".
			"</div>".
			"<div class='FilterBar'>".
			"<table style='width:100%'>
			<tr><td>
				Kode Akun : <input type='text' id='fmKODE' name='fmKODE' value='".$fmKODE."' maxlength='' size=10px>&nbsp
				Nama Akun : <input type='text' id='fmAKUN' name='fmAKUN' value='".$fmAKUN."' size=30px>&nbsp".
				"<input type='hidden' id='filterAkun' name='filterAkun' value='".$filterAkun."'>".
				"<input type='button' id='btTampil' value='Tampilkan' onclick='".$this->Prefix.".refreshList(true)'>
			</td></tr>
			</table>".
			"</div>".
			"<input type='hidden' id='fmORDER18' name='fmORDER18' value='".$fmORDER18."'>".
			"<input type='hidden' id='fmORDER19' name='fmORDER19' value='".$fmORDER19."'>"
			;		
		return array('TampilOpt'=>$TampilOpt);
	}	
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//$thn_akun = $HTTP_COOKIE_VARS['coThnAnggaran'];
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];			
		$fmBIDANG = $_REQUEST['fmBIDANG'];
		$fmKELOMPOK = $_REQUEST['fmKELOMPOK'];
		$fmSUBKELOMPOK = $_REQUEST['fmSUBKELOMPOK'];
		$fmSUBSUBKELOMPOK = $_REQUEST['fmSUBSUBKELOMPOK'];	
		//$fmThnAnggaran=  $_COOKIE['coThnAnggaran'];	
		$filterAkun = cekPOST('filterAkun');
		$drId = $_REQUEST['drId'];	
		
		$arrKondisi[]= " kb != '0'";
		$arrKondisi[]= " kc != '0'";
		$arrKondisi[]= " kd != '0'";
		$arrKondisi[]= " ke != '0'";
	//	$arrKondisi[]= " kf != '0'";
		
		if(empty($fmBIDANG)) {
			$fmKELOMPOK = '';
			$fmSUBKELOMPOK='';
			$fmSUBSUBKELOMPOK='';
		}
		if(empty($fmKELOMPOK)) {
			$fmSUBKELOMPOK='';
			$fmSUBSUBKELOMPOK='';
		}
		if(empty($fmSUBKELOMPOK)) {		
			$fmSUBSUBKELOMPOK='';
		}
		$tp_jurnal=mysql_fetch_array(mysql_query("select * from t_saldo_keu_det where Id='$drId'"));
		if($tp_jurnal['tipe_jurnal']=='1'){
		if(empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka in(1,2,3) and kb!=0 and kc!=0 and kd!=0";	
		}
		
		}elseif($tp_jurnal['tipe_jurnal']=='2'){
		if(empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka in(4,5,6,7) and kb!=0 and kc!=0 and kd!=0";	
		}
		
		}elseif($tp_jurnal['tipe_jurnal']=='3'){
		if(empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka in(8,9) and kb!=0 and kc!=0 and kd!=0";	
		}
		
		}
		
		if(!empty($fmBIDANG) && empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka =$fmBIDANG";	
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka =$fmBIDANG and kb=$fmKELOMPOK";			
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka =$fmBIDANG and kb=$fmKELOMPOK and kc=$fmSUBKELOMPOK";			
		}
		elseif(!empty($fmBIDANG) && !empty($fmKELOMPOK) && !empty($fmSUBKELOMPOK) && !empty($fmSUBSUBKELOMPOK))
		{
			$arrKondisi[]= "ka =$fmBIDANG and kb=$fmKELOMPOK and kc=$fmSUBKELOMPOK and kd=$fmSUBSUBKELOMPOK";			
		}
		if(!empty($_POST['fmKODE'])){
			$pecahkodebarang = explode(".",$_POST['fmKODE']);
			if($pecahkodebarang[0] != '')$arrKondisi[]= " ka LIKE '%".$pecahkodebarang[0]."%'";
			if($pecahkodebarang[1] != '')$arrKondisi[]= " kb LIKE '%".$pecahkodebarang[1]."%'";
			if($pecahkodebarang[2] != '')$arrKondisi[]= " kc LIKE '%".$pecahkodebarang[2]."%'";
			if($pecahkodebarang[3] != ''){
				if (substr($pecahkodebarang[3],0,1)=='0')$pecahkodebarang[3]= substr($pecahkodebarang[3],1);
				$arrKondisi[]= " kd LIKE '%".$pecahkodebarang[3]."%'";	
				}
			if($pecahkodebarang[4] != ''){	
				if (substr($pecahkodebarang[4],0,1)=='0')$pecahkodebarang[4]= substr($pecahkodebarang[4],1);
				$arrKondisi[]= " ke LIKE '%".$pecahkodebarang[4]."%'";	
				}	
		}			
		if(!empty($_POST['fmAKUN'])) $arrKondisi[] = " nm_account like '%".$_POST['fmAKUN']."%'";
				
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		switch($fmORDER1){
			case '2': $arrOrders[] = " nama_barang $Asc1 " ;break;
		}

		$Order= join(',',$arrOrders);	
			
		$pagePerHal = $this->pagePerHal =='' ? $Main->PagePerHal: $this->pagePerHal; 
		$HalDefault=cekPOST($this->Prefix.'_hal',1);					
		//$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = " limit ".(($HalDefault	*1) - 1) * $pagePerHal.",".$pagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $pagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;	
	
		return array('Kondisi'=>$Kondisi, 'Order'=>$Order ,'Limit'=>$Limit, 'NoAwal'=>$NoAwal);	
	}
	
}
$cr_jurnal = new cr_jurnalObj();
?>