<?php

 include "pages/pencarian/DataPengaturan.php";
 $DataOption = $DataPengaturan->DataOption();

class cariRekeningPajakObj  extends DaftarObj2{	
	var $Prefix = 'cariRekeningPajak';
	var $elCurrPage="HalDefault";
	var $SHOW_CEK = TRUE;
	var $TblName = 'v1_ref_potongan_spm_rek'; //bonus
	var $TblName_Hapus = 'ref_potongan_spm';
	var $MaxFlush = 10;
	var $TblStyle = array( 'koptable', 'cetak','cetak'); //berdasar mode
	var $ColStyle = array( 'GarisDaftar', 'GarisCetak','GarisCetak');
	var $KeyFields = array('Id');
	var $FieldSum = array();//array('jml_harga');
	var $SumValue = array();
	var $FieldSum_Cp1 = array( 14, 13, 13);//berdasar mode
	var $FieldSum_Cp2 = array( 1, 1, 1);	
	var $checkbox_rowspan = 1;
	var $PageTitle = 'ADMINISTRASI SYSTEM';
	var $PageIcon = 'images/pengadaan_ico.png';
	var $ico_width = '28.8';
	var $ico_height = '28.8';
	var $pagePerHal ='';
	//var $cetak_xls=TRUE ;
	var $fileNameExcel='pemasukan.xls';
	var $namaModulCetak='ADMINISTRASI SYSTEM';
	var $Cetak_Judul = 'Pemasukan';	
	var $Cetak_Mode=2;
	var $Cetak_WIDTH = '30cm';
	var $Cetak_OtherHTMLHead;
	var $FormName = 'cariRekeningPajakForm';
	var $noModul=14; 
	var $TampilFilterColapse = 0; //0
	
	var $arr_cari = array(
						array("1","KODE"),
						array("2","NAMA REKENING"),
						array("3","URAIAN REKENING"),
						array("4","NAMA POTONGAN"),
					);
	function setTitle(){
		return 'CARI REKENING PAJAK';
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
		case 'GetData'					: $fm = $this->GetData();break;	  	   
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
			fn_TagScript("js/pencarian/DataPengaturan.js").
			fn_TagScript("js/pencarian/".$this->Prefix.".js").
			$scriptload;
	}
	
	function setPage_HeaderOther(){
		return "";
	}
		
	//daftar =================================
	function setKolomHeader($Mode=1, $Checkbox=''){
	 $NomorColSpan = $Mode==1? 2: 1;
	 $headerTable =
	  "<thead>
	   <tr>
	  	   <th class='th01' width='5'>No.</th>".
	  	   /*$Checkbox*/"		
		   <th class='th01' width='100px'>KODE</th>
		   <th class='th01'>NAMA REKENING</th>
		   <th class='th01'>URAIAN REKENING</th>
		   <th class='th01'>NAMA POTONGAN</th>
		   <th class='th01' width='50px'>PERSEN</th>
	   </thead>";
	 
		return $headerTable;
	}	
	
	function setKolomData($no, $isi, $Mode, $TampilCheckBox){
	 global $Ref, $DataPengaturan;
	 
	 $kodeRek = $DataPengaturan->Gen_valRekening($isi);
	 
	 $data = BtnText($kodeRek, $this->Prefix.".GetData(".$isi["Id"].")");
	 
	 $Koloms = array();
	 $Koloms[] = array('align="center"', $no.'.' );
	  /*if ($Mode == 1) $Koloms[] = array(" align='center'  ", $TampilCheckBox);*/
	 $Koloms[] = array('align="center" width="100px"',$data);
	 $Koloms[] = array('align="left"', $isi['nm_rekening'] );
	 $Koloms[] = array('align="left"', $isi['uraian_rek'] );
	 $Koloms[] = array('align="left"', $isi['nama_potongan']);
	 $Koloms[] = array('align="right" width="50px"', $isi['persen']."%");
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
	 
	$fmPILCARI = cekPOST2('fmPILCARI');	
	$fmPILCARIvalue = $_REQUEST['fmPILCARIvalue'];		
	$kodeprogram = $_REQUEST['kodeprogram'];		
	//tgl bulan dan tahun
	$fmFiltTglBtw = $_REQUEST['fmFiltTglBtw'];
	$fmFiltTglBtw_tgl1 = $_REQUEST['fmFiltTglBtw_tgl1'];
	$fmFiltTglBtw_tgl2 = $_REQUEST['fmFiltTglBtw_tgl2'];
	$fmORDER1 = cekPOST('fmORDER1');
	$fmDESC1 = cekPOST('fmDESC1');
	
	$TampilOpt =
			//<table width=\"100%\" class=\"adminform\">
			"<tr><td>".
			$vOrder=
			genFilterBar(
				array(cmbArray("fmPILCARI",$fmPILCARI,$this->arr_cari,"--- CARI BERDASARKAN ---","style='width:200px;'"),
					"<input type='text' value='".$fmPILCARIvalue."' placeholder='PENCARIAN' name='fmPILCARIvalue' id='fmPILCARIvalue' size='70'>",
					"<input type='button' id='btTampil' value='Cari' onclick='".$this->Prefix.".refreshList(true)'>"
					),			
				'','');
				;
			
			
		return array('TampilOpt'=>$TampilOpt);
	}			
	
	function getDaftarOpsi($Mode=1){
		global $Main, $HTTP_COOKIE_VARS;
		$UID = $_COOKIE['coID']; 
		//kondisi -----------------------------------
				
		$arrKondisi = array();		
		
		$fmPILCARI = cekPOST2('fmPILCARI');	
		$fmPILCARIvalue = cekPOST2('fmPILCARIvalue');
		
		if($fmPILCARI != '' && $fmPILCARIvalue != ''){
			switch ($fmPILCARI){
				case "1":$arrKondisi[] = " concat(k,'.',l,'.',m,'.',n,'.',o) like '%$fmPILCARIvalue%'";break;
				case "2":$arrKondisi[] = " nm_rekening like '%$fmPILCARIvalue%'";break;
				case "3":$arrKondisi[] = " uraian_rek like '%$fmPILCARIvalue%'";break;
				case "4":$arrKondisi[] = " nama_potongan like '%$fmPILCARIvalue%'";break;
			}
		}
		
		
		$Kondisi= join(' and ',$arrKondisi);		
		$Kondisi = $Kondisi =='' ? '':' Where '.$Kondisi;
		
		//Order -------------------------------------
		$fmORDER1 = cekPOST('fmORDER1');
		$fmDESC1 = cekPOST('fmDESC1');			
		$Asc1 = $fmDESC1 ==''? '': 'desc';		
		$arrOrders = array();
				
		$Order= join(',',$arrOrders);	
		$OrderDefault = '';// Order By no_terima desc ';
		$Order =  $Order ==''? $OrderDefault : ' Order By '.$Order;
		
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
				
		$form_name = $this->FormName;
		$jenis=cekPOST2('jenis');
		$refid_spp=cekPOST2('refid_spp');
		$judul = "PILIH REKENING POTONGAN PAJAK";
		if($jenis == "2")$judul = "PILIH REKENING RETENSI DAN DENDA KETERLAMBATAN";
		$dataHidden="";
		if(isset($_REQUEST["form_pengeluarankas_idplh"])){
			$dataHidden.=
				InputTypeHidden("AsalHalaman", "FormPengeluaranKas").
				InputTypeHidden("IdPengeluaranKas", cekPOST2("form_pengeluarankas_idplh"));
		}
		//if($err==''){
			$FormContent = $this->genDaftarInitial($ref_jenis);
			$form = centerPage(
					"<form name='$form_name' id='$form_name' method='post' action=''>".
					createDialog(
						$form_name.'_div', 
						$FormContent,
						900,
						500,
						$judul,
						'',
						/*"
						<input type='button' value='Pilih' onclick ='".$this->Prefix.".windowSave()' >".*/
						"<input type='button' value='Batal' onclick ='".$this->Prefix.".windowClose()' >".
						"<input type='hidden' id='jenis' name='jenis' value='$jenis' >".
						"<input type='hidden' id='refid_spp' name='refid_spp' value='$refid_spp' >".
						$dataHidden
						,//$this->setForm_menubawah_content(),
						$this->form_menu_bawah_height
					).
					"</form>"
			);
			$content = $form;//$content = 'content';	
		//}
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
	function GetData(){
		global $DataPengaturan;
		$cek = ''; $err=''; $content='';
		
		$Id = cekPOST2("Id"); 
		$refid_spp = cekPOST2("refid_spp");
		 
		$qry = $DataPengaturan->QyrTmpl1Brs("v1_ref_potongan_spm_rek", "*","WHERE Id='$Id' ");$cek.=$qry["cek"];
		$dt = $qry["hasil"];
		
		if($dt["Id"] == NULL || $dt["Id"] == "")$err="Data Tidak Valid !";
		if($err == "")$content['Id']=$dt["Id"];					
		
		return	array ('cek'=>$cek, 'err'=>$err, 'content'=>$content);
	}
	
}
$cariRekeningPajak = new cariRekeningPajakObj();
?>