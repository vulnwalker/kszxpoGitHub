<?php
	include "pages/pencarian/DataPengaturan.php";
	$DataOption = $DataPengaturan->DataOption();
	
class cariIdSPPObj  extends DaftarObj2{	
	var $Prefix = 'cariIdSPP';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 't_spp'; //bonus
	var $TblName_Hapus = '';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'PENGADAAN DAN PENERIMAAN';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'cariRekening';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariIdSPPForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	function setTitle(){
		return 'DAFTAR PROGRAM';
	}
	
	function setMenuEdit(){
		return "";
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
		case 'windowshow'				: $fm = $this->windowShow();break;
		case 'getid'					: $fm = $this->Get_Id();break;	   
		default:{
			$other = $this->set_selector_other2($tipe);
			$cek = $other['cek'];
			$err = $other['err'];
			$content=$other['content'];
			$json=$other['json'];
		break;
		}		 
	 }//end switch
	 if($json && isset($fm)){
		$cek = $fm['cek'];
		$err = $fm['err'];
		$content = $fm['content'];	
	 }
		
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
			fn_TagScript("js/pencarian/DataPenganturan.js").
			fn_TagScript("js/pencarian/".strtolower($this->Prefix).".js").
			$scriptload;
	}
	
	
	
	function setPage_HeaderOther(){
		return "";	
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 
	 $ket_sp= cekPOST2("dari_hal")=="sp2d"?"SPM":"SPP";
	 
	 $headerTable =
	  "<thead>
	   <tr>
	   		<th class='th01' width='5' rowspan='2'>NO</th>
			<th class='th02' colspan='2'>$ket_sp</th>
			<th class='th02' colspan='2'>SPD</th>
		   <!-- <th class='th01' rowspan='2'>ID PENERIMAAN</th> -->
		   <th class='th01' rowspan='2'>URAIAN</th>
	   </tr>
	   <tr>
	  	   ".
	  	   /*$Checkbox*/"		
		   <th class='th01' width='200px'>NOMOR</th>
		   <th class='th01' width='80px'>TANGGAL</th>
		   <th class='th01'>NOMOR</th>
		   <th class='th01' width='80px'>TANGGAL</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref;
	 
	 $tgl_sp= cekPOST2("dari_hal")=="sp2d"?$isi['tgl_spm']:$isi['tgl_spp'];
	 $nomor_sp= cekPOST2("dari_hal")=="sp2d"?$isi['nomor_spm']:$isi['nomor_spp'];
	 $uraian=cekPOST2("dari_hal")=="sp2d"?$isi['uraian_spm']:$isi['uraian'];
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	 $Koloms[] = array('align="left"',"<a href='javascript:".$this->Prefix.".pilPen(`".$isi['Id']."`)' >".$nomor_sp."</a>");
	 $Koloms[] = array('align="center"  ',FormatTanggalnya($tgl_sp));
	 $Koloms[] = array('align="left"',$isi['no_spd']);
	 $Koloms[] = array('align="center"',FormatTanggalnya($isi['tgl_spd']));
	 //$Koloms[] = array('align="left"',$isi['id_penerimaan']);
	 $Koloms[] = array('align="left"',$uraian);
	 return $Koloms;
	}
	
	function genDaftarOpsi(){
	 global $Ref, $Main;
	 
	 $arr = array(
			//array('selectAll','Semua'),	
			array('selectSatuan','Satuan'),		
			);
		
	 //data order ------------------------------
	 $arrOrder = array(
			     	array('1','Satuan'),
					);
	
	$fmPILCARI = $_REQUEST['fmPILCARI'];	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$fmBIDANG = cekPOST('fmBIDANG');
	$fmKELOMPOK = cekPOST('fmKELOMPOK');
	$fmSUBKELOMPOK = cekPOST('fmSUBKELOMPOK');
	$fmSUBSUBKELOMPOK = cekPOST('fmSUBSUBKELOMPOK');
	$fmKODE = cekPOST('fmKODE');
	$fmBARANG = cekPOST('fmBARANG');
	
	
	$TampilOpt ="";
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = $_REQUEST['fmPILCARI'];	
		$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];
		//cari tgl,bln,thn
		$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];			
		$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
		$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
				
		$c1 = cekPOST2('c1_cari');
		$c = cekPOST2('c_cari');
		$d = cekPOST2('d_cari');
		$e = cekPOST2('e_cari');
		$e1 = cekPOST2('e1_cari');
		$dari_hal = cekPOST2('dari_hal');
		$jns_spp = cekPOST2('jns_spp');
		
		
		$arrKondisi[] = " c1 = '$c1'";
		$arrKondisi[] = " c = '$c'";
		$arrKondisi[] = " d = '$d'";
		$arrKondisi[] = " e = '$e'";
		$arrKondisi[] = " e1 = '$e1'";
		$arrKondisi[] = " jns_spp = '$jns_spp'";
		if($dari_hal == "sp2d"){
			$arrKondisi[] = " status = '3'";//Verivikasi SPP
		}else{
			$arrKondisi[] = " status = '2'";//Verivikasi SPP
		}
		
		
		/*if($dari_hal == 'SPP'){
			$arrKondisi[] = " tp_pencairan_dana = '1'";
			$arrKondisi[] = " IdTsp IS NULL";
		}*/
		
		if(!empty($_POST['fmKODE'])) $arrKondisi[] = " concat(k,'.',l,'.',m,'.',n,'.',o) like '".$_POST['fmKODE']."%'";			if(!empty($_POST['fmBARANG'])) $arrKondisi[] = " nm_rekening like '%".$_POST['fmBARANG']."%'";
		
		
		//$arrKondisi[] = " q='00'";
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
		
		/*if($fmORDER1 == ''){
			$arrOrders[] = " p ";
			$arrOrders[] = " q ";
		}
		switch($fmORDER1){
			case '1': $arrOrders[] = " p $Asc1 " ;break;
		}	*/
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		//$Order ="";
		//limit --------------------------------------
		/**$HalDefault=cekPOST($this->Prefix.'_hal',1);	//Cat:Settingan Lama				
		$Limit = " limit ".(($HalDefault	*1) - 1) * $Main->PagePerHal.",".$Main->PagePerHal; //$LimitHal = '';
		$Limit = $Mode == 3 ? '': $Limit;
		//noawal ------------------------------------
		$NoAwal= $Main->PagePerHal * (($HalDefault*1) - 1);							
		$NoAwal = $Mode == 3 ? 0: $NoAwal;		
		**/
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
	
	function setTopBar(){
	   	return '';
	}	
	
	function windowShow(){		
		$cek = ''; $err=''; $content=''; 
		$json = TRUE;	//$ErrMsg = 'tes';
		
		
		$c1 = cekPOST2('c1nya');
		$c = cekPOST2('cnya');
		$d = cekPOST2('dnya');
		$e = cekPOST2('enya');
		$e1 = cekPOST2('e1nya');
		$darinya = cekPOST2('darinya');
		$jns_spp = cekPOST2('haljns_sppnya');
		
		$judul = $darinya == "sp2d"?"SPM":"SPP";
				
		$form_name = $this->Prefix."Form";
		$FormContent = $this->genDaftarInitial();
		$form = centerPage(
				"<form name='$form_name' id='$form_name' method='post' action=''>".
				createDialog(
					$form_name.'_div', 
					$FormContent,
					900,
					500,
					'CARI NOMOR '.$judul,
					'',
					InputTypeHidden("c1_cari",$c1).
					InputTypeHidden("c_cari",$c).
					InputTypeHidden("d_cari",$d).
					InputTypeHidden("e_cari",$e).
					InputTypeHidden("e1_cari",$e1).
					InputTypeHidden("dari_hal",$darinya).
					InputTypeHidden("jns_spp",$jns_spp).
					InputTypeHidden($this->Prefix."_idplh",$this->form_idplh).
					InputTypeHidden($this->Prefix."_fmST",$this->form_fmST).
					"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >"
					,//$this->setForm_menubawah_content(),
					$this->form_menu_bawah_height
				).
				"</form>"
		);
		$content = $form;
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function Get_Id(){
		global $DataPengaturan;
		$cek='';$err='';$content = array();
		
		$Id = cekPOST("IDnya");
		
		$qry = $DataPengaturan->QyrTmpl1Brs($this->TblName, "*", "WHERE Id='$Id' ");
		$dt = $qry["hasil"];
		
		$content["IdSPP"] = $dt["Id"]; 
		$content["refid_terima"] = $dt["refid_terima"]; 
		$content["no_spp"] = $dt["nomor_spp"]; 
		$content["jns_spp"] = $DataPengaturan->Daftar_arr_pencairan_dana[$dt['jns_spp']]; 
		$content["jns_spm"] = $DataPengaturan->Daftar_arr_pencairan_dana_SPM[$dt['jns_spp']]; 
		
		//Program
		$content["program"] = $DataPengaturan->GetProgKeg($dt["bk"],$dt["ck"],$dt["dk"],$dt["p"]);
		 
		//Kegiatan
		$content["kegiatan"] = $DataPengaturan->GetProgKeg($dt["bk"],$dt["ck"],$dt["dk"],$dt["p"],$dt["q"]); 
		
		//Pekerjaan
		$qry_penerimaan = $DataPengaturan->QyrTmpl1Brs("t_penerimaan_barang", "pekerjaan", "WHERE Id='".$dt["refid_terima"]."'");
		$dt_penerimaan = $qry_penerimaan["hasil"];
		
		$content["pekerjaan"] = $dt_penerimaan["pekerjaan"];
		
		//Tanggal & No Kontrak, penyedia 
		$content["tgl_kontrak"] = $dt["tgl_dok_kontrak"];
		$content["no_kontrak"] = $dt["no_dok_kontrak"];
		$content["penyedia"] = $dt["penyedia_barang"];
		$content["uraian"] = $dt["uraian"];
		
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$cariIdSPP = new cariIdSPPObj();
?>